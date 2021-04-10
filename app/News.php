<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//
class News extends Model
{
    protected $guarded = array('id');

    // validation:項目ごとに検証ルールを割り当て、入力情報を検証
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    
    // History ModelからNews Modelに関連付けを行い、
    public function histories()
    {
      return $this->hasMany('App\History');

    }
}