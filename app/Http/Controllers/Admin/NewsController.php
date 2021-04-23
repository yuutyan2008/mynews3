<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\News;
//時刻を扱うために Carbonという日付操作ライブラリを使う
use Carbon\Carbon;

//App直下のHistoryモデルを使う
use App\History;

//imageの保存をS3になるよう変更
use Storage;




class NewsController extends Controller
{
  public function add()
  {
      return view('admin.news.create');
  }

  public function create(Request $request)
  {

      // Varidationを行う。Newsディレクトリの$rules変数を呼び出す
      $this->validate($request, News::$rules);

      $news = new News;
      $form = $request->all();

      // formに画像があれば、保存する
      if (isset($form['image'])) {
        $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
        $news->image_path = Storage::disk('s3')->url($path);   
      } else {
          $news->image_path = null;
      }

      unset($form['_token']);
      unset($form['image']);
      // データベースに保存する
      $news->fill($form);
      $news->save();

      return redirect('admin/news/create');
  }

  public function index(Request $request)
  {
    //$requestの中の検索欄へのuser入力値cond_titleのを、変数cond_titleに代入
      $cond_title = $request->cond_title;
      //検索欄が空欄でなければ
      if ($cond_title != '') {
      //newsテーブルのtitleカラムで$cond_titleユーザー入力文字に一致するレコードを全て取得
          $posts = News::where('title', $cond_title)->get();
      } else {
      //News Modelを使って、データベースに保存されている、newsテーブルのレコードをすべて取得し、変数$postsに代入
          $posts = News::all();
      }
      /*
        index.blade.phpのファイルに取得したレコード（$posts）と、
        ユーザーが入力した文字列（$cond_title）を渡し、ページを開く
        view(ファイル名, 使いたい配列)
      */
      return view('admin.news.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }

  // 以下を追記

  public function edit(Request $request)
  {
      // News Modelからデータを取得する
      $news = News::find($request->id);
      if (empty($news)) {
        abort(404);    
      }
      return view('admin.news.edit', ['news_form' => $news]);
  }


  public function update(Request $request)
  {
     /*
      Validationをかける.
      第1引数に$requestとすると様々な値をチェックできる。
      第２引数ModelのNewsクラスの$rulesメソッド(validationのルールをまとめたもの)にアクセスしたい
    */
      $this->validate($request, News::$rules);
      // News Modelからデータを取得する
      $news = News::find($request->id);
      // 送信されてきたフォームデータを格納する
      $news_form = $request->all();
      
      if ($request->remove == 'true') {
            $news_form['image_path'] = null;
        } elseif ($request->file('image')) {
      //画像の取得から保存までの場所$pathを定義し、public/imageディレクトリに保存できたら$pathに代入//
            $path = Storage::disk('s3')->putFile('/',$form['image'],'public');
      //$pathの経路public/imageディレクトリを削除し、ファイル名だけをフォームに入力
            $news->image_path = Storage::disk('s3')->url($path);
        } else {
            $news_form['image_path'] = $news->image_path;
        }
      //news_formから送信されてきた[ ]を削除
      unset($news_form['_token']);
      unset($news_form['image']);
      unset($news_form['remove']);

      // 該当するデータを上書きして保存する
      $news->fill($news_form)->save();
      
      //History Modelにも編集履歴を追加
      $history = new History;
      //オブジェクト変数（インスタンス化されたHistoryクラス）からnews_idメソッドを呼び出す=newsオブジェクトからidメソッドを呼び出す
      //
      $history->news_id = $news->id;
      //Carbon:日付操作ライブラリで現在時刻を取得し、History Modelの edited_at として記録
      $history->edited_at = Carbon::now();
      $history->save();


      return redirect('admin/news');
  }
  
    public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      // dd($request);
      $news = News::find($request->id);
      // 削除する
      $news->delete();
      return redirect('admin/news/');
  }  


}