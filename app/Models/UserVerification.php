<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $table = 'user_verifications';

    public function users() {
    	return $this->hasOne(User::class);
    }
}
