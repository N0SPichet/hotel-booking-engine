<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Housedetail extends Model
{
    protected $table = 'housedetails';

    public function houses(){
        return $this->belongsToMany(House::class);
    }
}
