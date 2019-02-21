<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Himage extends Model
{
    protected $table = 'images';

    public function houses(){
    	return $this->belongsTo(House::class);
    }
}
