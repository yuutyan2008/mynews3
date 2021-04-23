<?php

namespace App;

//NewsはModelクラスから継承したクラス
use Illuminate\Database\Eloquent\Model;

//Newsは単数型newsテーブルを利用するクラスとして用意する
class News extends Model
{
    //$guardプロパティは入力フォームの値がnullでもエラーにならない保護設定。
    //idフィールドはデータベースで自動的に番号が入るため、Modelで
    protected $guarded = array('id');

    // validation:項目ごとに検証ルールを割り当て、入力情報を検証
    //入力が必須なもの以外には不要
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    // 従テーブルのHistory Modelメソッド（１対複数のため複数形）から主テーブルのNews Modelに関連付けを行い
    //$this( Newクラスを指す）のhasmanyメソッドを呼び出し、引数には関連づけるHistoryモデル
    //hasManyメソッドにより、newsの変更履歴一覧を取得できる
    public function histories()
    {
      return $this->hasMany('App\History');

    }
}