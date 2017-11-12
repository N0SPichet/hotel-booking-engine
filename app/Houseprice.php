<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Houseprice extends Model
{
    protected $table = 'houseprices';

    public function houses(){
    	return $this->hasMany('App\House');
    }
}
