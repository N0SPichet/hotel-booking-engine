<?php

namespace App\Models;

use App\Models\Diary;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    function diaries(){
    	return $this->hasMany(Diary::class);
    }
}
