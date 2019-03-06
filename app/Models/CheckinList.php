<?php

namespace App\Models;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Model;

class CheckinList extends Model
{
	protected $fillable = ['checkin_name', 'checkin_lastname', 'checkin_personal_id', 'checkin_tel', 'rental_id'];

    public function rental()
    {
    	return $this->belongsTo(Rental::class);
    }
}
