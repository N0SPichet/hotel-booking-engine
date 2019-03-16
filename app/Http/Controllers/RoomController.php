<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\District;
use App\Models\Food;
use App\Models\Guestarrive;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houseprice;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
use App\Models\Map;
use App\Models\Payment;
use App\Models\Province;
use App\Models\Rental;
use App\Models\Review;
use App\Models\SubDistrict;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Image;
use Purifier;
use Session;
use Storage;

class RoomController extends Controller
{
    use GlobalFunctionTraits;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types_id = $this->getTypeId('room');
        $houses = Auth::user()->houses()->where('publish', '!=', '3')->whereIn('housetype_id', $types_id)->orderBy('id')->paginate(10);
        return view('rooms.index')->with('houses', $houses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = $this->getType('room');
        $provinces = Province::all();
        $districts = District::where('province_id', $provinces[0]->id)->get();
        $sub_districts = SubDistrict::where('district_id', $districts[0]->id)->get();
        $houseamenities = Houseamenity::all();
        $housespaces = Housespace::all();
        $houserules = Houserule::all();
        $housedetails = Housedetail::all();
        return view('rooms.create')->with('types', $types)->with('sub_districts', $sub_districts)->with('districts', $districts)->with('provinces', $provinces)->with('houseamenities', $houseamenities)->with('housespaces', $housespaces)->with('houserules', $houserules)->with('housedetails', $housedetails);
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
            'housetype_id' => 'required',
            'district_id' => 'required',
            'sub_district_id' => 'required',
            'province_id' => 'required',
            'house_title' => 'required',
            'notice' => 'required',
            'checkin_from' => 'required',
            'checkin_to' => 'required'
        ));
        $house = new House;
        $house->user_id = Auth::user()->id;
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
        $house->housetype_id = $request->housetype_id;
        $house->district_id = $request->district_id;
        $house->sub_district_id = $request->sub_district_id;
        $house->province_id = $request->province_id;

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
        $price->type_price = $request->type_price;
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
                $images = new HouseImage;
                $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
                $location = public_path('images/houses/'.$house->id.'/');
                if (!file_exists($location)) {
                    $result = File::makeDirectory($location, 0775, true);
                }
                $location = public_path('images/houses/'.$house->id.'/'.$filename);
                Image::make($image_name)->resize(1440, 1080)->save($location);
                $images->house_id = $house->id;
                $images->name = $filename;
                $images->save();
            }
        }
        
        $cover_image = HouseImage::where('house_id', $house->id)->first();
        if ($cover_image) {
            $house->cover_image = $cover_image->name;
        }
        $house->save();

        $house->houseamenities()->sync($request->houseamenities, false);
        $house->housespaces()->sync($request->housespaces, false);
        $house->houserules()->sync($request->houserules, false);
        $house->housedetails()->sync($request->housedetails, false);

        $premessage = "Dear " . $house->user->user_fname;
        $detailmessage = "At " . date('jS F, Y H:i:s', strtotime($house->created_at)) . " you have create a room name '". $house->house_title."'";
        $endmessage = "";

        $data = array(
            'email' => $house->user->email,
            'subject' => "LTT - Your property are ready to deploy",
            'bodyMessage' => $premessage,
            'detailmessage' => $detailmessage,
            'endmessage' => $endmessage,
            'house' => $house
        );

        Mail::send('emails.room_create', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        Session::flash('success', 'This house was succussfully saved!');
        return redirect()->route('rooms.owner', $house->id);
    }

    public function owner($houseId){
        $types_id = $this->getTypeId('room');
        $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
        if (!is_null($house)) {
            if ((Auth::user()->hasRole('Admin') || Auth::user()->id == $house->user_id) && $house->publish != '3') {
                $rentcount = Rental::where('house_id', $house->id)->count();
                $map = Map::where('houses_id', $house->id)->first();
                return view('rooms.single')->with('house', $house)->with('rentcount', $rentcount)->with('map', $map);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('rooms.index');
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
            if (!is_null($house)) {
                return redirect()->route('apartments.owner', $houseId);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('rooms.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($houseId)
    {
        $types_id = $this->getTypeId('room');
        $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
        if (!is_null($house)) {
            if ($house->publish == '1') {
                $clean = Review::where('house_id', $house->id)->avg('clean');
                $amenity = Review::where('house_id', $house->id)->avg('amenity');
                $service = Review::where('house_id', $house->id)->avg('service');
                $host = Review::where('house_id', $house->id)->avg('host');
                $avg = ($clean + $amenity + $service + $host)/4;
                $avg = number_format((float)$avg, 2, '.', '');
                $map = Map::where('houses_id', $house->id)->first();
                return view('rooms.show')->with('house', $house)->with('avg', $avg)->with('map', $map);
            }
            Session::flash('fail', 'This room is no longer available.');
            return back();
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
            if (!is_null($house)) {
                return redirect()->route('apartments.show', $houseId);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($houseId)
    {
        $types_id = $this->getTypeId('room');
        $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
        if (!is_null($house)) {
            if (Auth::user()->id == $house->user_id && $house->publish != '3') {
                $types = $this->getType('room');
                $provinces = Province::all();
                $districts = District::where('province_id', $provinces[0]->id)->get();
                $sub_districts = SubDistrict::where('district_id', $districts[0]->id)->get();
                if ($house->province_id !== null) {
                    $districts = District::where('province_id', $house->province_id)->get();
                }
                if ($house->district_id !== null) {
                    $sub_districts = SubDistrict::where('district_id', $house->district_id)->get();
                }
                $amenities = Houseamenity::all();
                $spaces = Housespace::all();
                $houseimages = HouseImage::where('house_id', $house->id)->get();
                $rules = Houserule::all();
                $details = Housedetail::all();
                return view('rooms.edit')->with('house', $house)->with('types', $types)->with('sub_districts', $sub_districts)->with('districts', $districts)->with('provinces', $provinces)->with('amenities', $amenities)->with('spaces', $spaces)->with('houseimages', $houseimages)->with('rules', $rules)->with('details', $details);
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        else {
            $types_id = $this->getTypeId('apartment');
            $house = House::where('id', $houseId)->whereIn('housetype_id', $types_id)->first();
            if (!is_null($house)) {
                return redirect()->route('apartments.edit', $house->id);
            }
            Session::flash('fail', 'Unauthorized access.');
            return redirect()->route('home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $houseId)
    {
        $this->validate($request, array(
            'housetype_id' => 'required',
            'house_capacity' => 'required',
            'house_bedrooms' => 'required',
            'house_beds' => 'required',
            'house_bathroom' => 'required',
            'house_bathroomprivate' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'sub_district_id' => 'required',
            'house_address' => 'required',
            'house_postcode' => 'required',
            'house_title' => 'required',
            'notice' => 'required',
            'price' => 'required'
        ));

        $house = House::find($houseId);
        if (Auth::user()->id == $house->user_id && $house->publish != '3') {
            $house->housetype_id = $request->housetype_id;
            $house->house_capacity = $request->house_capacity;
            $house->house_guestspace = $request->house_guestspace;
            $house->house_bedrooms = $request->house_bedrooms;
            $house->house_beds = $request->house_beds;
            $house->house_bathroom = $request->house_bathroom;
            $house->house_bathroomprivate = $request->house_bathroomprivate;
            $house->house_address = $request->house_address;
            $house->district_id = $request->district_id;
            $house->sub_district_id = $request->sub_district_id;
            $house->province_id = $request->province_id;
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
            $houseprice->type_price = $request->type_price;
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
                    $image = new HouseImage;
                    $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image_name->getClientOriginalExtension();
                    $location = public_path('images/houses/'.$house->id.'/');
                    if (!file_exists($location)) {
                        $result = File::makeDirectory($location, 0775, true);
                    }
                    $location = public_path('images/houses/'.$house->id.'/'.$filename);
                    Image::make($image_name)->resize(1440, 1080)->save($location);
                    $image->house_id = $house->id;
                    $image->name = $filename;
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
            return redirect()->route('rooms.owner', $house->id);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($houseId)
    {
        $house = House::find($houseId);
        if (Auth::user()->id == $house->user_id) {
            $rental = Rental::where('house_id', $house->id)->first();
            $images = HouseImage::where('house_id', $house->id)->get();
            if ($rental == NULL){
                $house->houseamenities()->detach();
                $house->housespaces()->detach();
                $house->houserules()->detach();
                $house->housedetails()->detach();
                foreach ($images as $image) {
                    if ($image->house_id == $house->id) {
                        $filename = $image->name;
                        $image->delete();
                        $location = public_path('images/houses/'.$houseId.'/'.$filename);
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
            return redirect()->route('rooms.index')->with('alert', $alt);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function temp_delete($houseId)
    {
        $house = House::find($houseId);
        if (!is_null($house)) {
            if (Auth::user()->id == $house->user_id && $house->publish != '3') {
                $house->publish = '2';
                $house->save();
                Session::flash('success', 'Move room '.$house->id.' to trash succussfully.');
                return redirect()->route('rooms.owner', $house->id);
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function permanent_delete($houseId)
    {
        $house = House::find($houseId);
        if (!is_null($house)) {
            if (Auth::user()->id == $house->user_id) {
                $house->publish = '3';
                $house->save();
                Session::flash('success', 'Permanent delete room '.$house->id.' succussfully.');
                return redirect()->route('rooms.index');
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function restore($houseId)
    {
        $house = House::find($houseId);
        if (!is_null($house)) {
            if (Auth::user()->id == $house->user_id && $house->publish != '3') {
                $house->publish = '0';
                $house->save();
                Session::flash('success', 'Restore room '.$house->id.' from trash succussfully.');
                return redirect()->route('rooms.owner', $house->id);
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function detroyimage(HouseImage $image)
    {
        $filename = $image->name;
        $houseId = $image->house_id;
        $location = public_path('images/houses/'.$houseId.'/'.$filename);
        File::delete($location);
        $image->delete();
        return redirect()->route('rooms.owner', $houseId);
    }
}
