<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'houses';

    public function users() {
    	return $this->belongsTo('App\User');
    }

    public function rentals() {
        return $this->belongsTo('App\Rental');
    }

    public function addresscities() {
    	return $this->belongsTo('App\Addresscity');
    }

    public function addresscountries() {
    	return $this->belongsTo('App\Addresscountry');
    }

    public function addressstates() {
    	return $this->belongsTo('App\Addressstate');
    }

    public function housetypes() {
        return $this->belongsTo('App\housetypes');
    }

    public function images() {
        return $this->hasMany('App\Himage');
    }

    public function houseitems() {
        return $this->belongsToMany('App\Houseitem');
    }

    public function houserules() {
        return $this->belongsToMany('App\Houserule');
    }
}
