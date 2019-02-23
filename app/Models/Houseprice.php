<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Houseprice extends Model
{
    protected $table = 'houseprices';

    public function houses(){
    	return $this->hasMany(House::class);
    }
}
