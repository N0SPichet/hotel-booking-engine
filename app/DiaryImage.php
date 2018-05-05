<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaryImage extends Model
{
    protected $table = 'diary_images';

    public function diaries(){
    	return $this->belongsTo('App\Diary');
    }
}
