<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guestarrive extends Model
{
    protected $table = 'guestarrives';

    public function houses(){
    	return $this->hasMany('App\House');
    }
}
