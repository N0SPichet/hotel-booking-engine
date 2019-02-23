<?php

namespace App\Models;

use App\Models\House;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'room_reviews';

    public function houses() {
    	return $this->belongsTo(House::class);
    }

    public function user() {
    	return $this->belongsTo(User::class);
    }
}
