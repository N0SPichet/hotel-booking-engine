<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $table = 'user_verifications';

    public function users() {
    	return $this->hasMany('App\User');
    }
}
