<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Houseamenity extends Model
{
    protected $table = 'houseamenities';

    public function houses(){
        return $this->belongsToMany(House::class);
    }
}
