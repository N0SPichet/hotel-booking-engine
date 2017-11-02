<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\House;
use App\Houseitem;
use App\Houserule;
use App\Address;
use App\Addresscity;
use App\Addressstate;
use App\Addresscountry;
use App\Housetype;
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
        $houses = House::orderBy('updated_at', 'desc')->paginate(10);

        return view('rooms.index')->with('houses', $houses);
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
        return view('rooms.create')->with('htypes', $htypes)
                                   ->with('cities', $cities)
                                   ->with('states', $states)
                                   ->with('countries', $countries);
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
            'house_title' => 'required',
            'house_capacity' => 'required',
            'house_property' => 'required',
            'house_guestspace' => 'required',
            'house_bedrooms' => 'required',
            'house_beds' => 'required',
            'house_bathroom' => 'required',
            'house_bathroomprivate' => 'required',
            'house_address' => 'required',
            'house_postcode' => 'required',
            'house_price' => 'required',
            'housetypes_id' => 'required',
            'addresscities_id' => 'required',
            'addressstates_id' => 'required',
            'addresscountries_id' => 'required',
            'house_description' => 'required'
        ));

        $house = new House;

        $house->users_id = Auth::user()->id;
        $house->house_title = $request->house_title;
        $house->house_property = $request->house_property;
        $house->house_capacity = $request->house_capacity;
        $house->house_guestspace = $request->house_guestspace;
        $house->house_bedrooms = $request->house_bedrooms;
        $house->house_beds = $request->house_beds;
        $house->house_bathroom = $request->house_bathroom;
        $house->house_bathroomprivate = $request->house_bathroomprivate;
        $house->house_address = $request->house_address;
        $house->house_postcode = $request->house_postcode;
        $house->house_price = $request->house_price;
        $house->housetypes_id = $request->housetypes_id;
        $house->addresscities_id = $request->addresscities_id;
        $house->addressstates_id = $request->addressstates_id;
        $house->addresscountries_id = $request->addresscountries_id;
        $house->house_description = $request->house_description;

        $house->save();
        $house = House::orderby('created_at', 'desc')->first();
        $houseid = $house->id;

        $count = 0;
        foreach ($request->image_names as $image_name) {
            $images = new Himage;
            $filename = time() . $count . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
            $location = public_path('images/houses/'.$filename);
            Image::make($image_name)->resize(1600, 1000)->save($location);

            $images->houses_id = $houseid;
            $images->image_name = $filename;
            $images->save();

            $count++;
        }

        $house->houseitems()->sync($request->houseitems, false);

        $house->houserules()->sync($request->houserules, false);

        Session::flash('success', 'This house was succussfully uploaded!');

        return redirect()->route('rooms.single', $house->id);
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
        return view('rooms.room-detail')->with('house', $house)->with('images', $images);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
            $house->houseitems()->detach();
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

    public function hreport($id){
        //
    }

    public function single($id){
        $house = House::find($id);
        $images = Himage::where('houses_id', $id)->get();
        return view('rooms.single')->with('house', $house)->with('images', $images);
    }

    public function rsetscene(Request $request){

        $house_property = $request->house_property;
        $house_capacity = $request->house_capacity;
        $house_guestspace = $request->house_guestspace;
        $house_bedrooms = $request->house_bedrooms;
        $house_beds = $request->house_beds;
        $house_bathroom = $request->house_bathroom;
        $house_bathroomprivate = $request->house_bathroomprivate;
        $house_address = $request->house_address;
        $house_postcode = $request->house_postcode;
        $housetypes_id = $request->housetypes_id;
        $addresscities_id = $request->addresscities_id;
        $addressstates_id = $request->addressstates_id;
        $addresscountries_id = $request->addresscountries_id;

        $houseitems = Houseitem::all();

        $houserules = Houserule::all();

        $data = array(  'house_property' => $house_property,
                        'house_capacity' => $house_capacity,
                        'house_guestspace' => $house_guestspace,
                        'dateout' => $house_beds,
                        'house_bedrooms' => $house_bedrooms,
                        'house_beds' => $house_beds,
                        'house_bathroom' => $house_bathroom,
                        'house_bathroomprivate' => $house_bathroomprivate,
                        'house_address' => $house_address,
                        'house_postcode' => $house_postcode,
                        'housetypes_id' => $housetypes_id,
                        'addresscities_id' => $addresscities_id,
                        'addressstates_id' => $addressstates_id,
                        'addresscountries_id' => $addresscountries_id);

        return view('rooms.setscene')->with($data)->with('houseitems', $houseitems)->with('houserules', $houserules);
    }
}
