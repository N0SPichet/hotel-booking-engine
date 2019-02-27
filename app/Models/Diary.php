<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\DiaryImage;
use App\Models\Rental;
use App\Models\Tag;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $table = 'diaries';

    public function users(){
    	return $this->belongsTo(User::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function diary_images(){
        return $this->hasMany(DiaryImage::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function rentals(){
        return $this->belongsTo(Rental::class);
    }
}
