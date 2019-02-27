<?php

namespace App\Models;

use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\Apartmentprice;
use App\Models\District;
use App\Models\Food;
use App\Models\Guestarrive;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houseprice;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
use App\Models\Province;
use App\Models\Rental;
use App\Models\Review;
use App\Models\SubDistrict;
use App\User;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use GlobalFunctionTraits;

    protected $table = 'houses';

    public function apartmentprices()
    {
        return $this->belongsTo(Apartmentprice::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function users() {
    	return $this->belongsTo(User::class);
    }

    public function rentals() {
        return $this->belongsTo(Rental::class);
    }

    public function guestarrives() {
        return $this->belongsTo(Guestarrive::class);
    }

    public function images() {
        return $this->hasMany(HouseImage::class);
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

    public function housetype() {
        return $this->belongsTo(Housetype::class);
    }

    public function foods() {
        return  $this->belongsTo(Food::class);
    }

    public function houseprices() {
        return $this->belongsTo(Houseprice::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
