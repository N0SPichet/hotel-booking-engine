<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Houseitem extends Model
{
	protected $table = 'houseitems';

    public function houses(){
        return $this->belongsToMany('App\House');
    }
}
