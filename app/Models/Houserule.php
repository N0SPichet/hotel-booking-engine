<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Houserule extends Model
{
    protected $table = 'houserules';

    public function houses(){
        return $this->belongsToMany(House::class);
    }
}
