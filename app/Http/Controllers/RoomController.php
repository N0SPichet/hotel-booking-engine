<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\House;
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
use App\Houseprice;
use App\Rental;
use App\Himage;
use Image;
use Storage;
use Session;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = House::inRandomOrder()->paginate(10);
        return view('rooms.index')->with('houses', $houses);
    }

    public function indexmyroom($id) {
        $houses = House::where('users_id', $id)->orderBy('id')->paginate(10);
        return view('rooms.index-myroom')->with('houses', $houses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $htypes = Housetype::all();
        $cities = Addresscity::all();
        $states = Addressstate::all();
        $countries = Addresscountry::all();
        $houseamenities = Houseamenity::all();
        $housespaces = Housespace::all();
        return view('rooms.create')->with('htypes', $htypes)->with('cities', $cities)->with('states', $states)->with('countries', $countries)->with('houseamenities', $houseamenities)->with('housespaces', $housespaces);
    }

    public function rsetscene(Request $request)
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
        ));

        $house = new House;
        $house->users_id = Auth::user()->id;
        $house->house_property = $request->house_property;
        $house->house_capacity = $request->house_capacity;
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
        
        $guestarrive = new Guestarrive;
        $guestarrive->save();
        $house->guestarrives_id = $guestarrive->id;

        $houseprice = new Houseprice;
        $houseprice->save();
        $house->houseprices_id = $houseprice->id;

        $house->save();
        $house->houseamenities()->sync($request->houseamenities, false);
        $house->housespaces()->sync($request->housespaces, false);
        return view('rooms.setscene')->with('id', $house->id);
    }

    public function rfinalstep(Request $request)
    {
        $this->validate($request, array(
            'id' => 'required',
            'house_title' => 'required'
        ));
        $house = House::find($request->id);
        $house->house_title = $request->house_title;
        $house->house_description = $request->house_description;
        $house->about_your_place = $request->about_your_place;
        $house->guest_can_access = $request->guest_can_access;
        $house->optional_note = $request->optional_note;
        $house->about_neighborhood = $request->about_neighborhood;

        foreach ($request->image_names as $image_name) {
            $images = new Himage;
            $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
            $location = public_path('images/houses/'.$filename);
            Image::make($image_name)->resize(1500, 1000)->save($location);

            $images->houses_id = $house->id;
            $images->image_name = $filename;
            $images->save();
        }
        $house->save();

        $houserules = Houserule::all();
        $housedetails = Housedetail::all();
        return view('rooms.finalstep')->with('id', $house->id)->with('houserules', $houserules)->with('housedetails', $housedetails);
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
            'id' => 'required',
            'notice' => 'required',
            'checkin_from' => 'required',
            'checkin_to' => 'required'
        ));

        $house = House::find($request->id);
        $guestarrive = Guestarrive::find($house->guestarrives_id);
        $guestarrive->notice = $request->notice;
        $guestarrive->checkin_from = $request->checkin_from;
        $guestarrive->checkin_to = $request->checkin_to;
        $guestarrive->save();

        $price = Houseprice::find($house->houseprices_id);
        $price->price = $request->price;
        $price->welcome_offer = $request->welcome_offer;
        $price->weekly_discount = $request->weekly_discount;
        $price->monthly_discount = $request->monthly_discount;
        $price->save();

        $cover_image = Himage::where('houses_id', $request->id)->first();
        $house->image_name = $cover_image->image_name;
        $house->save();

        $house->houserules()->sync($request->houserules, false);
        $house->housedetails()->sync($request->housedetails, false);

        Session::flash('success', 'This house was succussfully published!');

        return redirect()->route('rooms.single', $house->id);
    }

    public function single($id){
        $house = House::find($id);
        $rentcount = Rental::where('houses_id', $house->id)->count();
        $images = Himage::where('houses_id', $id)->get();
        return view('rooms.single')->with('house', $house)->with('rentcount', $rentcount)->with('images', $images);
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
        $images = Himage::where('houses_id', $id)->get();
        return view('rooms.show')->with('house', $house)->with('images', $images);
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

        $housetypes = Housetype::all();
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
        $images = array();
        $count = 1;
        foreach ($houseimages as $houseimage) {
            $images[$houseimage->id] = $count;
            $count++;
        }

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
        return view('rooms.edit')->with('house', $house)->with('types', $types)->with('cities', $cities)->with('states', $states)->with('countries', $countries)->with('amenities', $amenities)->with('spaces', $spaces)->with('images', $images)->with('rules', $rules)->with('details', $details);
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
        $house->housetypes_id = $request->housetypes_id;
        $house->house_capacity = $request->house_capacity;
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
        
        $idimage = $request->image_name;
        $image = Himage::find($idimage);
        $house->image_name = $image->image_name;
        $house->house_description = $request->house_description;
        $house->about_your_place = $request->about_your_place;
        $house->guest_can_access = $request->guest_can_access;
        $house->optional_note = $request->optional_note;
        $house->about_neighborhood = $request->about_neighborhood;
        echo $house->guestarrives_id;
        $guestarrive = Guestarrive::find($house->guestarrives_id);
        $guestarrive->notice = $request->notice;

        $houseprice = Houseprice::find($house->houseprices_id);
        $houseprice->price = $request->price;
        $houseprice->welcome_offer = $request->welcome_offer;
        $houseprice->weekly_discount = $request->weekly_discount;
        $houseprice->monthly_discount = $request->monthly_discount;
        if ($request->hasFile('image_names')) {
            foreach ($request->image_names as $image_name) {
                $image = new Himage;
                $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
                $location = public_path('images/houses/'.$filename);
                Image::make($image_name)->resize(1500, 1000)->save($location);
                $image->houses_id = $house->id;
                $image->image_name = $filename;
                $image->save();
            }
        }
        $guestarrive->save();
        $houseprice->save();
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
            $house->houserules()->detach();
            foreach ($images as $image) {
                if ($image->houses_id == $house->id) {
                    $filename = $image->image_name;
                    $image->image_name = $filename;
                    $image->delete();
                    Storage::delete('houses/'.$filename);
                }
            }
            $house->delete();
            $alt = 'Room #ID ' . $house->id . ' Deleted';
        }
        else {
            $alt = 'Can not delete Room #ID ' . $house->id . ' because someone has rented.';
        }

        return redirect()->route('rooms.index')->with('alert', $alt);
    }

    public function detroyimage($id)
    {
        $image = Himage::find($id);
        $filename = $image->image_name;
        $house_id = $image->houses_id;
        Storage::delete('houses/'.$filename);
        $image->delete();
        return redirect()->route('rooms.single', $house_id);
    }
}
