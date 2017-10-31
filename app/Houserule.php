<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Houserule extends Model
{
    protected $table = 'houserules';

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
