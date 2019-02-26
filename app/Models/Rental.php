<?php

namespace App\Models;

use App\Models\House;
use App\Models\Payment;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function houses(){
    	return $this->belongsTo(House::class);
    }

    public function payment(){
    	return $this->belongsTo(Payment::class);
    }

    public function diaries(){
        return $this->hasMany('App\Diary');
    }
}
