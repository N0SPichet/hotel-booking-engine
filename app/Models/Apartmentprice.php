<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Apartmentprice extends Model
{
    protected $table = 'apartmentprices';

    public function houses(){
    	return $this->hasMany(House::class);
    }
}
