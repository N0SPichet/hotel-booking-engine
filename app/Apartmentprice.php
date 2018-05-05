<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartmentprice extends Model
{
    protected $table = 'apartmentprices';

    public function houses(){
    	return $this->hasMany('App\House');
    }
}
