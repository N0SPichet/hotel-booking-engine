<?php

namespace App\Http\Controllers\Traits;

use App\Models\House;
use App\Models\Housetype;

trait GlobalFunctionTraits
{
    /*
    this trait was use in
    Models
    - House
    Controller
    - ApartmentController
    - RoomController
    - RentalController
    */
    
    /*check in status 0 not checkin 1 checkin 2 cancel*/
    /*diaries publish flag 0 private, 1 public, 2 subscriber*/
	/*house publish flag 0 private, 1 public, 2 trash, 3 permanant delete*/
	public $select_types_global = ['type 2 apartment', 'type 3 apartment'];

	private function getTypeId($request)
    {
        $select_types = $this->select_types_global;
        if ($request == 'room') {
            $types = Housetype::whereNotIn('name', $select_types)->get();
        }
        else {
            $types = Housetype::whereIn('name', $select_types)->get();
        }
        $types_id = array();
        foreach ($types as $key => $type) {
            array_push($types_id, $type->id);
        }
        return $types_id;
    }

    private function getType($request)
    {
        $select_types = $this->select_types_global;
        if ($request == 'room') {
            $types = Housetype::whereNotIn('name', $select_types)->get();
        }
        else {
            $types = Housetype::whereIn('name', $select_types)->get();
        }
        return $types;
    }

    public function checkType($houseId)
    {
        $types_id = $this->getTypeId('room');
        $houses = House::where('id', $houseId)->whereIn('housetypes_id', $types_id)->first();
        if (!is_null($houses)) {
            return true;
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $houses = House::where('id', $houseId)->whereIn('housetypes_id', $types_id)->first();
            return false;
        }
    }
}
