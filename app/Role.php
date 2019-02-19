<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = ['name', 'description'];

    public function users()
    {
    	return $this->belongsToMany('User::class', 'user_role', 'role_id', 'user_id');
    }
}
