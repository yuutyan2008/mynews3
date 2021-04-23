<?php
//use文
use Illuminate\Support\Facades\Schema;
//カラム操作するためのBlueprintクラスの使用
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

//Migrationを継承したクラスとして
class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     /*title と body と image_path を追記
       upメソッドはテーブル生成処理を行う
       テーブル生成はSchema::createメソッドで行い、第一引数はテーブル名
       第二引数はテーブル作成のための処理についての無名関数。無名関数の引数として渡されるBlueprintクラスのメソッドがフィールドを設定する
       */
    public function up()
    {
        //blueprintクラスのtableインスタンスでstringメソッドを呼び出し、bodyカラム作成
    
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title'); // ニュースのタイトルを保存するカラム
            $table->string('body');  // ニュースの本文を保存するカラム
            $table->string('image_path')->nullable();  // 画像のパスを保存するカラム
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     //downメソッドはテーブル削除処理を行う。schemaクラスのdropIfExistsメソッドを使用
    public function down()
    {
        //引数に指定したnewsテーブルがあれば、削除
        Schema::dropIfExists('news');
    }
}