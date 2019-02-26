<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    protected $table = 'images';

    public function house(){
    	return $this->belongsTo(House::class);
    }
}
