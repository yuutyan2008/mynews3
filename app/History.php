<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//model名（History）は単数形、テーブル名は複数形
class History extends Model
{
    //guardedプロパティ
    protected $guarded = array('id');

    //validation
    public static $rules = array(
        'news_id' => 'required',
        'edited_at' => 'required',
        'profile_id' => 'required',
    );
}