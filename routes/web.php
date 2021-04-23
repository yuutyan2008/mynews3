<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//トップページにアクセスしたときの処理
Route::get('/', function () {
    return view('welcome');
});
//どのcontrollerへ処理を渡すかについてのルーティング。admin投稿者用から始まるアドレスを指定
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
     Route::get('news/create', 'Admin\NewsController@add');//controllerのadd actionにrouteを割り当てる
     Route::post('news/create', 'Admin\NewsController@create'); //情報入力フォームにアクセスがあると、controllerのcreateアクションに割り当てる（登録する）
     Route::get('profile/create', 'Admin\ProfileController@add');
     Route::get('profile/edit', 'Admin\ProfileController@edit');
     Route::post('profile/create', 'Admin\ProfileController@create'); # Lara13課題
     Route::get('news', 'Admin\NewsController@index'); // 追記
     Route::get('news/edit', 'Admin\NewsController@edit'); // Lara16
     Route::post('news/edit', 'Admin\NewsController@update'); // Lara16
     Route::get('news/delete', 'Admin\NewsController@delete');// Lara16
     Route::post('profile/edit', 'Admin\ProfileController@update');// Lara16課題
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//トップページにアクセスがあった時に
Route::get('/', 'NewsController@index');
Route::get('profile', 'ProfileController@index');


