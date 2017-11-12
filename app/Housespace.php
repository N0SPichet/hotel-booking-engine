<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Housespace extends Model
{
    protected $table = 'housespaces';

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
