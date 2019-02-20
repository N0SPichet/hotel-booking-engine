<?php

namespace App\Models;

use App\Models\District;
use App\Models\House;
use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function districts()
    {
    	return $this->hasMany(District::class);
    }

    public function houses(){
        return $this->hasMany(House::class);
    }

    public function postal_codes()
    {
    	return $this->hasMany(PostalCode::class);
    }

    public function users() {
        return $this->hasMany(User::class);
    }
}
