<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    public function houses(){
    	return $this->hasMany('App\House');
    }
}
