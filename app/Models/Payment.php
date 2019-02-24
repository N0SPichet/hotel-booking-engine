<?php

namespace App\Models;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    function rental(){
    	return $this->hasOne(Rental::class);
    }
}
