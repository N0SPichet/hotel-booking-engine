<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\House;
use App\Map;
use App\Address;
use App\Addresscity;
use App\Addressstate;
use App\Addresscountry;
use App\Housetype;
use App\Houseamenity;
use App\Housespace;
use App\Guestarrive;
use App\Houserule;
use App\Housedetail;
use File;
use App\Food;
use App\Houseprice;
use App\Rental;
use App\Payment;
use App\Himage;
use App\Review;
use Image;
use Storage;
use Session;
use Purifier;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $states = Addressstate::where("addresscountry_id", '1')->get();
        // foreach ($states as $key => $state) {
        //     echo $state->id . '<br>';
        // }
        $houses = House::orderBy('id')->paginate(10);
        return view('rooms.index')->with('houses', $houses);
    }

    public function indexmyroom($id) {
        if ($id == Auth::user()->id) {
            $houses = House::where('users_id', $id)->where('housetypes_id','!=','1')->where('housetypes_id','!=','5')->orderBy('id')->paginate(10);
            return view('rooms.index-myroom')->with('houses', $houses);
        }
        else {
            Session::flash('fail', "Request not found, You don't have permission to see this files!");
            return back();
        }
    }

    public function getStateList(Request $request)
    {
        $states = Addressstate::where('addresscountry_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $id = $request->state_id;
        $cities = Addresscity::where("addressstate_id", $id)->get();
        // $cities = Addresscity::all();
        return response()->json($cities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check()) {
            $get_states = route('get_states');
            $get_cities = route('get_cities');
            $htypes = Housetype::where('type_name', '!=', 'Apartment')->where('type_name', '!=', 'Hotel')->get();
            $countries = Addresscountry::all();
            $houseamenities = Houseamenity::all();
            $housespaces = Housespace::all();
            $houserules = Houserule::all();
            $housedetails = Housedetail::all();
            return view('rooms.create')->with('htypes', $htypes)->with('countries', $countries)->with('houseamenities', $houseamenities)->with('housespaces', $housespaces)->with('houserules', $houserules)->with('housedetails', $housedetails)->with('get_states', $get_states)->with('get_cities', $get_cities);
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'house_property' => 'required',
            'house_capacity' => 'required',
            'house_guestspace' => 'required',
            'house_bedrooms' => 'required',
            'house_beds' => 'required',
            'house_bathroom' => 'required',
            'house_bathroomprivate' => 'required',
            'house_address' => 'required',
            'house_postcode' => 'required',
            'housetypes_id' => 'required',
            'addresscities_id' => 'required',
            'addressstates_id' => 'required',
            'addresscountries_id' => 'required',
            'house_title' => 'required',
            'notice' => 'required',
            'checkin_from' => 'required',
            'checkin_to' => 'required'
        ));

        if (Auth::check()) {
            $house = new House;
            $house->users_id = Auth::user()->id;
            $house->house_property = $request->house_property;
            $house->house_capacity = $request->house_capacity;
            $house->no_rooms = '1';
            $house->house_guestspace = $request->house_guestspace;
            $house->house_bedrooms = $request->house_bedrooms;
            $house->house_beds = $request->house_beds;
            $house->house_bathroom = $request->house_bathroom;
            $house->house_bathroomprivate = $request->house_bathroomprivate;
            $house->house_address = $request->house_address;
            $house->house_postcode = $request->house_postcode;
            $house->housetypes_id = $request->housetypes_id;
            $house->addresscities_id = $request->addresscities_id;
            $house->addressstates_id = $request->addressstates_id;
            $house->addresscountries_id = $request->addresscountries_id;

            $house->house_title = $request->house_title;
            $house->house_description = Purifier::clean($request->house_description);
            $house->about_your_place = Purifier::clean($request->about_your_place);
            $house->guest_can_access = Purifier::clean($request->guest_can_access);
            $house->optional_note = Purifier::clean($request->optional_note);
            $house->about_neighborhood = Purifier::clean($request->about_neighborhood);
            $house->optional_rules = $request->optional_rules;

            $guestarrive = new Guestarrive;
            $guestarrive->notice = $request->notice;
            $guestarrive->checkin_from = $request->checkin_from;
            $guestarrive->checkin_to = $request->checkin_to;
            $guestarrive->save();
            $house->guestarrives_id = $guestarrive->id;

            $price = new Houseprice;
            $price->price_perperson = $request->price_perperson;
            $price->price = $request->price;
            $price->food_price = $request->food_price;
            $price->welcome_offer = $request->welcome_offer;
            $price->weekly_discount = $request->weekly_discount;
            $price->monthly_discount = $request->monthly_discount;
            $price->save();
            $house->houseprices_id = $price->id;

            $map = new Map;
            $map->map_name = $request->map_name;
            $map->map_lat = $request->map_lat;
            $map->map_lng = $request->map_lng;

            $food = new Food;
            if ($request->food_breakfast == '1') {
                $food->breakfast = '1';
            }
            else {
                $food->breakfast = '0';
            }
            if ($request->food_lunch == '1') {
                $food->lunch = '1';
            }
            else {
                 $food->lunch = '0';
            }
            if ($request->food_dinner == '1') {
                $food->dinner = '1';
            }
            else {
                $food->dinner = '0';
            }
            $food->save();
            $house->foods_id = $food->id;

            $house->save();

            $map->houses_id = $house->id;
            $map->save();
            if ($request->hasFile('image_names')) {
                foreach ($request->image_names as $image_name) {
                    $images = new Himage;
                    $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
                    $location = public_path('images/houses/'.$filename);
                    Image::make($image_name)->resize(1440, 1080)->save($location);

                    $images->houses_id = $house->id;
                    $images->image_name = $filename;
                    $images->save();
                }
            }
            $house = House::find($house->id);
            $cover_image = Himage::where('houses_id', $house->id)->first();
            if ($cover_image) {
                $house->cover_image = $cover_image->image_name;
            }
            $house->save();

            $house->houseamenities()->sync($request->houseamenities, false);
            $house->housespaces()->sync($request->housespaces, false);
            $house->houserules()->sync($request->houserules, false);
            $house->housedetails()->sync($request->housedetails, false);

            Session::flash('success', 'This house was succussfully saved!');
            return redirect()->route('rooms.single', $house->id);
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function single($id){
        $house = House::find($id);
        if ($house) {
            if ($house->housetypes_id != '1') {
                if ($house->housetypes_id != '5') {
                    if (Auth::user()->level == '0' || Auth::user()->id == $house->users_id) {
                        $rentcount = Rental::where('houses_id', $house->id)->count();
                        $images = Himage::where('houses_id', $id)->get();
                        $map = Map::where('houses_id', $house->id)->first();
                        return view('rooms.single')->with('house', $house)->with('rentcount', $rentcount)->with('images', $images)->with('map', $map);
                    }
                    else {
                        Session::flash('fail', 'This room is no longer available.');
                        return back();
                    }
                }
                else {
                    return redirect()->route('apartments.single', $id);
                }
            }
            else {
                return redirect()->route('apartments.single', $id);
            }
        }
        else {
            Session::flash('fail', 'This room is no longer available.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $house = House::find($id);
        if (is_null($house)) {
            Session::flash('fail', 'This room is no longer available.');
            return back();
        }
        else {
            if ($house->publish == '2') {
                if ($house->housetypes_id == '1' || $house->housetypes_id == '5') {
                    return redirect()->route('apartments.show', $id);
                }
                else {
                    $images = Himage::where('houses_id', $id)->get();
                    $reviews = Review::where('house_id', $id)->get();
                    $clean = Review::where('house_id', $id)->avg('clean');
                    $amenity = Review::where('house_id', $id)->avg('amenity');
                    $service = Review::where('house_id', $id)->avg('service');
                    $host = Review::where('house_id', $id)->avg('host');
                    $avg = ($clean + $amenity + $service + $host)/4;
                    $avg = number_format((float)$avg, 2, '.', '');
                    $map = Map::where('houses_id', $house->id)->first();
                    return view('rooms.show')->with('house', $house)->with('images', $images)->with('avg', $avg)->with('map', $map);
                }
            }
            Session::flash('fail', 'This room is no longer available.');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $house = House::find($id);
        if ($house) {
            if ($house->housetypes_id == '1' || $house->housetypes_id == '5') {
                return redirect()->route('apartments.edit', $id);
            }
            else {
                if ($house->users->id == Auth::user()->id) {
                    $housetypes = Housetype::where('type_name', '!=', 'Apartment')->where('type_name', '!=', 'Hotel')->get();
                    $types = array();
                    foreach ($housetypes as $housetype) {
                        $types[$housetype->id] = $housetype->type_name;
                    }

                    $housecities = Addresscity::all();
                    $cities = array();
                    foreach ($housecities as $housecity) {
                        $cities[$housecity->id] = $housecity->city_name;
                    }

                    $housestates = Addressstate::all();
                    $states = array();
                    foreach ($housestates as $housestate) {
                        $states[$housestate->id] = $housestate->state_name;
                    }

                    $housecountries = Addresscountry::all();
                    $countries = array();
                    foreach ($housecountries as $housecountry) {
                        $countries[$housecountry->id] = $housecountry->country_name;
                    }

                    $houseamenities = Houseamenity::all();
                    $amenities = array();
                    foreach ($houseamenities as $houseamenity) {
                        $amenities[$houseamenity->id] = $houseamenity->amenityname;
                    }

                    $housespaces = Housespace::all();
                    $spaces = array();
                    foreach ($housespaces as $housespace) {
                        $spaces[$housespace->id] = $housespace->spacename;
                    }

                    $houseimages = Himage::where('houses_id', $house->id)->get();

                    $houserules = Houserule::all();
                    $rules = array();
                    foreach ($houserules as $houserule) {
                        $rules[$houserule->id] = $houserule->houserule_name;
                    }

                    $housedetails = Housedetail::all();
                    $details = array();
                    foreach ($housedetails as $housedetail) {
                        $details[$housedetail->id] = $housedetail->must_know;
                    }
                    return view('rooms.edit')->with('house', $house)->with('types', $types)->with('cities', $cities)->with('states', $states)->with('countries', $countries)->with('amenities', $amenities)->with('spaces', $spaces)->with('houseimages', $houseimages)->with('rules', $rules)->with('details', $details);
                }
                else {
                    Session::flash('fail', 'This room is no longer available.');
                    return back();
                }
            }
        }
        else {
            Session::flash('fail', 'This room is no longer available.');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'housetypes_id' => 'required',
            'house_capacity' => 'required',
            'house_bedrooms' => 'required',
            'house_beds' => 'required',
            'house_bathroom' => 'required',
            'house_bathroomprivate' => 'required',
            'addresscountries_id' => 'required',
            'house_address' => 'required',
            'addresscities_id' => 'required',
            'addressstates_id' => 'required',
            'house_postcode' => 'required',
            'house_title' => 'required',
            'notice' => 'required',
            'price' => 'required'
        ));

        $house = House::find($id);
        $house->publish = $request->publish;
        $house->housetypes_id = $request->housetypes_id;
        $house->house_capacity = $request->house_capacity;
        $house->house_guestspace = $request->house_guestspace;
        $house->house_bedrooms = $request->house_bedrooms;
        $house->house_beds = $request->house_beds;
        $house->house_bathroom = $request->house_bathroom;
        $house->house_bathroomprivate = $request->house_bathroomprivate;
        $house->addresscountries_id = $request->addresscountries_id;
        $house->house_address = $request->house_address;
        $house->addresscities_id = $request->addresscities_id;
        $house->addressstates_id = $request->addressstates_id;
        $house->house_postcode = $request->house_postcode;
        $house->house_title = $request->house_title;
        $house->cover_image = $request->cover_image;
        $house->house_description = Purifier::clean($request->house_description);
        $house->about_your_place = Purifier::clean($request->about_your_place);
        $house->guest_can_access = Purifier::clean($request->guest_can_access);
        $house->optional_note = Purifier::clean($request->optional_note);
        $house->about_neighborhood = Purifier::clean($request->about_neighborhood);
        
        $guestarrive = Guestarrive::find($house->guestarrives_id);
        $guestarrive->notice = $request->notice;

        $houseprice = Houseprice::find($house->houseprices_id);
        $houseprice->price_perperson = $request->price_perperson;
        $houseprice->price = $request->price;
        $houseprice->food_price = $request->food_price;

        $food = Food::find($house->foods_id);
        if ($request->food_breakfast == '1') {
            $food->breakfast = '1';
        }
        else {
            $food->breakfast = '0';
        }
        if ($request->food_lunch == '1') {
            $food->lunch = '1';
        }
        else {
             $food->lunch = '0';
        }
        if ($request->food_dinner == '1') {
            $food->dinner = '1';
        }
        else {
            $food->dinner = '0';
        }

        $houseprice->welcome_offer = $request->welcome_offer;
        $houseprice->weekly_discount = $request->weekly_discount;
        $houseprice->monthly_discount = $request->monthly_discount;
        if ($request->hasFile('image_names')) {
            foreach ($request->image_names as $image_name) {
                $image = new Himage;
                $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
                $location = public_path('images/houses/'.$filename);
                Image::make($image_name)->resize(1440, 1080)->save($location);
                $image->houses_id = $house->id;
                $image->image_name = $filename;
                $image->save();
            }
        }
        $guestarrive->save();
        $houseprice->save();
        $food->save();
        $house->save();

        if (isset($request->houseamenities)) {
            $house->houseamenities()->sync($request->houseamenities);
        }
        else {
            $house->houseamenities()->sync(array());
        }

        if (isset($request->housespaces)) {
            $house->housespaces()->sync($request->housespaces);
        }
        else {
            $house->housespaces()->sync(array());
        }

        if (isset($request->houserules)) {
            $house->houserules()->sync($request->houserules);
        }
        else {
            $house->houserules()->sync(array());
        }

        if (isset($request->housedetails)) {
            $house->housedetails()->sync($request->housedetails);
        }
        else {
            $house->housedetails()->sync(array());
        }

        Session::flash('success', 'This house was succussfully updated!');

        return redirect()->route('rooms.single', $house->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $house = House::find($id);
        $rental = Rental::where('houses_id', $house->id)->first();
        $images = Himage::all();
        if ($rental == NULL){
            $house->houseamenities()->detach();
            $house->housespaces()->detach();
            $house->houserules()->detach();
            $house->housedetails()->detach();
            foreach ($images as $image) {
                if ($image->houses_id == $house->id) {
                    $filename = $image->image_name;
                    $image->image_name = $filename;
                    $image->delete();
                    $location = public_path('images/houses/'.$filename);
                    File::delete($location);
                }
            }
            $map = Map::where('houses_id', $house->id)->first();
            $map->delete();
            $house->delete();
            $houseprice = Houseprice::find($house->houseprices_id);
            $houseprice->delete();
            $food = Food::find($house->foods_id);
            $food->delete();
            $guestarrive = Guestarrive::find($house->guestarrives_id);
            $guestarrive->delete();
            $alt = 'Room #ID ' . $house->id . ' Deleted';
        }
        else {
            $alt = 'Can not delete Room #ID ' . $house->id . ' because someone has rented.';
        }

        return redirect()->route('index-myroom', Auth::user()->id)->with('alert', $alt);
    }

    public function detroyimage($id)
    {
        $image = Himage::find($id);
        $filename = $image->image_name;
        $house_id = $image->houses_id;
        $location = public_path('images/houses/'.$filename);
        File::delete($location);
        $image->delete();
        return redirect()->route('rooms.single', $house_id);
    }
}
