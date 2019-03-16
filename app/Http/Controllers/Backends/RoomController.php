<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\House;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
	use GlobalFunctionTraits;

	public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function index()
    {
        $types_id = $this->getTypeId('room');
        $houses = House::where('publish', '!=', '3')->whereIn('housetype_id', $types_id)->orderBy('id')->paginate(10);
        return view('admin.rooms.index')->with('houses', $houses);
    }

    public function as_owner($houseId){
        $types_id = $this->getTypeId('room');
        $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
        if (!is_null($house)) {
            if ($house->publish != '3') {
                $map = Map::where('houses_id', $house->id)->first();
                return view('admin.rooms.as-owner')->with('house', $house)->with('map', $map);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('admin.rooms.index');
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
            if (!is_null($house)) {
                return redirect()->route('admin.apartments.as-owner', $houseId);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('admin.rooms.index');
        }
    }
}
