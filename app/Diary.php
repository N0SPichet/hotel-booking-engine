<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $table = 'diaries';

    public function users(){
    	return $this->belongsTo('App\User');
    }

    public function categories(){
    	return $this->belongsTo('App\Category');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function diary_images(){
        return $this->hasMany('App\DiaryImage');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function rentals(){
        return $this->belongsTo('App\Rental');
    }
}
