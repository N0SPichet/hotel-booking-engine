<?php

namespace App\Models;

use App\Models\District;
use App\Models\House;
use App\Models\Province;
use App\Models\SubDistrict;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function houses(){
        return $this->hasMany(House::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function sub_district()
    {
    	return $this->belongsTo(SubDistrict::class);
    }
}
