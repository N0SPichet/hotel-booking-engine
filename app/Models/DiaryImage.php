<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaryImage extends Model
{
    protected $table = 'diary_images';

    public function diary(){
    	return $this->belongsTo(Diary::class);
    }
}
