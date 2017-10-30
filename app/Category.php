<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    function diaries(){
    	return $this->hasMany('App\Diary');
    }
}
