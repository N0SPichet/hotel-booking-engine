<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\House;
use App\Addresscountry;
use App\Addressstate;
use App\Addresscity;
use Image;
use Storage;
use Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $houses = House::where('users_id', $user->id)->get();
        return view('users.show')->with('user', $user)->with('houses', $houses);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $cities = Addresscity::all();
        $countries = Addresscountry::all();
        $states = Addressstate::all();
        return view('users.edit')->with('cities', $cities)->with('user', $user)->with('countries', $countries)->with('states', $states);
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
        //validate the data
        $this->validate($request, array(
            'user_fname' => 'required|max:255',
            'user_lname' => 'required|max:255',
            'user_tel' => 'max:10',
        ));

        $user = User::find($id);

        $user->user_fname = $request->input('user_fname');
        $user->user_lname = $request->input('user_lname');

        $user->user_tel = $request->input('user_tel');

        $user->user_gender = $request->input('user_gender');
        if ($user->user_gender == '1') {
            $user->user_gender = 'Male';
        }
        else{
            $user->user_gender = 'Female';
        }

        $user->user_address = $request->input('user_address');
        $user->user_city = $request->input('user_city');
        $user->user_state = $request->input('user_state');
        $user->user_country = $request->input('user_country');

        $user->user_description = $request->input('user_description');

        Session::flash('success', 'Profile updated successfully.');

        $user->save();

        return redirect()->route('users.profile', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function description($id){
        $user = User::find($id);
        return view('users.description')->with('user', $user);
    }

    public function ureport($id){
        $user = User::find($id);

        if($user->user_score == 1){
            return redirect()->route('users.show', $id);
        }
        
        $user->user_score = $user->user_score - 0.1;

        $user->save();

        Session::flash('success', 'This user has been reported.');

        return redirect()->route('users.show', $id);
    }

    public function updateimage(Request $request, $id){
        $user = User::find($id);

        if ($request->hasFile('user_image')) {
            $image = $request->file('user_image');
            $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/users/'.$filename);
            Image::make($image)->save($location);
            //new image
            if ($user->user_image == NULL){
                $user->user_image = $filename;
            }
            //update image
            else if ($user->user_image != NULL){
                $oldFilename = $user->user_image;
                $user->user_image = $filename;
                Storage::delete('users/'.$oldFilename);
            }
        }

        $user->save();

        Session::flash('success', 'Your profile picture has been updated.');

        return redirect()->route('users.profile', $user->id);
    }
}
