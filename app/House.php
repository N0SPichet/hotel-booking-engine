<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'houses';

    public function apartmentprices() {
        return $this->belongsTo('App\Apartmentprice');
    }

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
        return $this->belongsTo('App\Housetype');
    }

    public function roomtypes() {
        return $this->belongsTo('App\RoomType');
    }

    public function guestarrives() {
        return $this->belongsTo('App\Guestarrive');
    }

    public function images() {
        return $this->hasMany('App\Himage');
    }

    public function houseamenities() {
        return $this->belongsToMany('App\Houseamenity');
    }

    public function housespaces() {
        return $this->belongsToMany('App\Housespace');
    }

    public function houserules() {
        return $this->belongsToMany('App\Houserule');
    }

    public function housedetails() {
        return $this->belongsToMany('App\Housedetail');
    }

    public function foods() {
        return  $this->belongsTo('App\Food');
    }

    public function houseprices() {
        return $this->belongsTo('App\Houseprice');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }
}
