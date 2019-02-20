<?php

namespace App;

use App\Models\District;
use App\Models\House;
use App\Models\Province;
use App\Models\Role;
use App\Models\SubDistrict;
use App\Models\UserVerification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    protected $table = 'users';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_fname', 
        'user_lname',
        'user_tel',
        'user_sex',
        'user_address',
        'user_city',
        'user_state',
        'user_country',
        'user_description',
        'email', 
        'password',
        'user_verifications_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    public function diaries() {
        return $this->hasMany('App\Diary');
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function houses() {
        return $this->hasMany(House::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function rentals() {
        return $this->hasMany('App\Rental');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function verification() {
        return $this->belongsTo(UserVerification::class, 'user_verifications_id');
    }
}
