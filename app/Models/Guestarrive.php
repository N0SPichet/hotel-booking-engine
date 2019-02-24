<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Guestarrive extends Model
{
    protected $table = 'guestarrives';

    public function houses(){
    	return $this->hasMany(House::class);
    }
}
