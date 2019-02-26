<?php

namespace App\Models;

use App\Models\House;
use Illuminate\Database\Eloquent\Model;

class Housetype extends Model
{
    protected $table = 'housetypes';

    public function houses(){
        return $this->hasMany(House::class);
    }
}
