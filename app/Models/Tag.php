<?php

namespace App\Models;

use App\Models\Diary;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    public function diaries(){
        return $this->belongsToMany(Diary::class);
    }
}
