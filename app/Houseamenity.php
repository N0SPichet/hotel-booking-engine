<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Houseamenity extends Model
{
    protected $table = 'houseamenities';

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
