<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Himage extends Model
{
    protected $table = 'images';

    public function houses(){
    	return $this->belongsTo('App\
    		House');
    }
}
