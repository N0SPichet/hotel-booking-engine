<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Housetype extends Model
{
    protected $table = 'housetypes';

    public function houses(){
        return $this->hasMany('App\House');
    }
}
