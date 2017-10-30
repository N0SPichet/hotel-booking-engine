<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addressstate extends Model
{
    protected $table = 'addressstates';

    public function house(){
        return $this->hasMany('App\House');
    }
}
