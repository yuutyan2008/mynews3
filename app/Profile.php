<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
        protected $guarded = array('id');
    // validation機能でデータの不備を検証
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'introduction' => 'required',
        'hobby' => 'required',
    );
}