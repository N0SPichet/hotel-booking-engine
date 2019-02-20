<?php

namespace App\Models;

use App\Models\House;
use App\Models\PostalCode;
use App\Models\Province;
use App\Models\SubDistrict;
use App\User;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function houses(){
        return $this->hasMany(House::class);
    }

    public function postal_codes()
    {
        return $this->hasMany(PostalCode::class);
    }

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

    public function sub_districts()
    {
    	return $this->hasMany(SubDistrict::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
