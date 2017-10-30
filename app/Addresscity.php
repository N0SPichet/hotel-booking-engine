<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addresscity extends Model
{
    protected $table = 'addresscities';

    public function house(){
        return $this->hasMany('App\House');
    }
}
