<?php

namespace App\Models;

use App\Models\Diary;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function diaries(){
    	return $this->belongsTo(Diary::class);
    }
}
