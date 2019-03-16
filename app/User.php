<?php

namespace App;

use App\Models\Diary;
use App\Models\District;
use App\Models\House;
use App\Models\Province;
use App\Models\Rental;
use App\Models\Review;
use App\Models\Role;
use App\Models\SubDistrict;
use App\Models\Subscribe;
use App\Models\UserVerification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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

    public function followers($user_id)
    {
        $count = Subscribe::where('writer', $user_id)->count();
        if (($count/1000000) > 1) {
            $count = ($count/1000000);
            $count = $count."M";
        }
        elseif (($count/1000) > 1) {
            $count = ($count/1000);
            $count = $count."k";
        }
        return $count;
    }

    public function following($user_id)
    {
        $count = Subscribe::where('follower', $user_id)->count();
        if (($count/1000000) > 1) {
            $count = ($count/1000000);
            $count = $count."M";
        }
        elseif (($count/1000) > 1) {
            $count = ($count/1000);
            $count = $count."k";
        }
        return $count;
    }

    public function diaries() {
        return $this->hasMany(Diary::class);
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
        return $this->hasMany(Rental::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function subscribe($diary_id)
    {
        $diary = Diary::find($diary_id);
        $subscribe = Subscribe::where('writer', $diary->user_id)->where('follower', Auth::user()->id)->first();
        return $subscribe;
    }

    public function verification() {
        return $this->belongsTo(UserVerification::class, 'user_verifications_id');
    }
}
