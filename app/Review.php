<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'room_reviews';

    public function houses() {
    	return $this->belongsTo('App\House');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
