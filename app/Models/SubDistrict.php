<?php

namespace App\Models;

use App\Models\District;
use App\Models\House;
use App\Models\PostalCode;
use App\User;
use Illuminate\Database\Eloquent\Model;

class SubDistrict extends Model
{
    public function district()
    {
    	return $this->belongsTo(District::class);
    }

    public function houses(){
        return $this->hasMany(House::class);
    }

    public function postal_code()
    {
    	return $this->hasOne(PostalCode::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
