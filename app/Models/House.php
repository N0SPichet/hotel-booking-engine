<?php

namespace App\Models;

use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
use App\User;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'houses';

    public function apartmentprices() {
        return $this->belongsTo('App\Apartmentprice');
    }

    public function users() {
    	return $this->belongsTo(User::class);
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
        return $this->belongsToMany(Houseamenity::class);
    }

    public function housedetails() {
        return $this->belongsToMany(Housedetail::class);
    }

    public function houserules() {
        return $this->belongsToMany(Houserule::class);
    }

    public function housespaces() {
        return $this->belongsToMany(Housespace::class);
    }

    public function housetypes() {
        return $this->belongsTo(Housetype::class);
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
