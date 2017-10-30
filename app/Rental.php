<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    public function users(){
    	return $this->belongsTo('App\User');
    }

    public function houses(){
    	return $this->belongsTo('App\House');
    }

    public function payments(){
    	return $this->belongsTo('App\Payment');
    }
}
