<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = array('id');
    // validation:項目ごとに検証ルールを割り当て、入力情報を検証
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
    );
    
    // ProfileHistory ModelからProfile Modelに関連付けを行い、
    public function profilehistories()
    {
      return $this->hasMany('App\ProfileHistory');

    }
    
    
    
    

}