<?php
//閲覧者用

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\HTML;

// 追記
use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        /*News::all()は、Eloquentを使い全てのnewsテーブルを取得するというメソッド（処理）
          updated_at:投稿日時で、sortByDesc:updated_at新しいもの順に並べ替える
        */
        $posts = News::all()->sortByDesc('updated_at');

        if (count($posts) > 0) {
            /* shift:配列の最初のデータを削除し、その値を返すメソッド
              削除した最新データを$headline（最新の記事を格納）に代入
              $posts（最新記事以外を格納）
              最新とそれ以外で表記を変えたいため
            */
            $headline = $posts->shift();
        } else {
            $headline = null;
        }

        /*news/index.blade.php ファイルを渡している
          また View テンプレートに headline、 posts、という変数を渡している
        */
        return view('news.index', ['headline' => $headline, 'posts' => $posts]);
    }
}