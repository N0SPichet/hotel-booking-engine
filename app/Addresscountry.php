<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addresscountry extends Model
{
    protected $table = 'addresscountries';

    public function house(){
        return $this->hasMany('App\House');
    }
}
