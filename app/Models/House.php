<?php

namespace App\Models;

use App\Models\Apartmentprice;
use App\Models\District;
use App\Models\Food;
use App\Models\Guestarrive;
use App\Models\Himage;
use App\Models\House;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houseprice;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
use App\Models\Province;
use App\Models\Review;
use App\Models\SubDistrict;
use App\User;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    protected $table = 'houses';

    private $select_types_global = ['type 2 apartment', 'type 3 apartment'];

    public function apartmentprices()
    {
        return $this->belongsTo(Apartmentprice::class);
    }

    private function getTypeId($request)
    {
        $select_types = $this->select_types_global;
        if ($request == 'room') {
            $types = Housetype::whereNotIn('name', $select_types)->get();
        }
        else {
            $types = Housetype::whereIn('name', $select_types)->get();
        }
        $types_id = array();
        foreach ($types as $key => $type) {
            array_push($types_id, $type->id);
        }
        return $types_id;
    }

    public function checkType($houseId)
    {
        $types_id = $this->getTypeId('room');
        $houses = House::where('id', $houseId)->whereIn('housetypes_id', $types_id)->first();
        if (!is_null($houseId)) {
            return true;
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $houses = House::where('id', $houseId)->whereIn('housetypes_id', $types_id)->first();
            return false;
        }
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function users() {
    	return $this->belongsTo(User::class);
    }

    public function rentals() {
        return $this->belongsTo('App\Rental');
    }

    public function guestarrives() {
        return $this->belongsTo(Guestarrive::class);
    }

    public function images() {
        return $this->hasMany(Himage::class);
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
