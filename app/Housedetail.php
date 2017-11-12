<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Housedetail extends Model
{
    protected $table = 'housedetails';

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
