<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Housespace extends Model
{
    protected $table = 'housespaces';

    public function houses(){
        return $this->belongsToMany(House::class);
    }
}
