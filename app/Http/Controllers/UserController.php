<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\House;
use App\Models\Province;
use App\Models\SubDistrict;
use App\Models\UserVerification;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Purifier;
use Session;
use Storage;

class UserController extends Controller
{
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
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
            return view('users.show')->with('user', $user);
        }
        else {
            $name_str = explode("@", $userId);
            $name_str = explode("_", $name_str[1]);
            $user = User::where('user_fname', 'like', '%'.$name_str[0].'%')->where('user_lname', 'like', '%'.$name_str[1].'%')->first();
            if (!is_null($user)) {
                return view('users.show')->with('user', $user);
            }
        }
        Session::flash('fail', 'This user is no longer available.');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
            if (Auth::user()->id == $user->id) {
                $provinces = Province::all();
                $districts = District::where('province_id', $provinces[0]->id)->get();
                $sub_districts = SubDistrict::where('district_id', $districts[0]->id)->get();
                if ($user->province_id !== null) {
                    $districts = District::where('province_id', $user->province_id)->get();
                }
                if ($user->district_id !== null) {
                    $sub_districts = SubDistrict::where('district_id', $user->district_id)->get();
                }
                return view('users.edit')->with('sub_districts', $sub_districts)->with('districts', $districts)->with('provinces', $provinces)->with('user', $user);
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Request $request)
    {
        if (Auth::user()->id == $user->id) {
            if ($request->user_gender !== 0) {
                $user['user_gender'] = $request->user_gender;
            }
            if ($request->user_gender === 0) {
                $user['user_gender'] = null;
            }
            if ($request->province_id !== 0) {
                $user['province_id'] = $request->province_id;
            }
            if ($request->district_id !== 0) {
                $user['district_id'] = $request->district_id;
            }
            if ($request->sub_district_id !== 0) {
                $user['sub_district_id'] = $request->sub_district_id;
            }
            unset($request['user_gender']);
            unset($request['province_id']);
            unset($request['district_id']);
            unset($request['sub_district_id']);
            $request['user_description'] = Purifier::clean($request->input('user_description'));
            $user->update($request->all());
            Session::flash('success', 'Profile updated successfully.');
            $user->save();
            return redirect()->route('dashboard.account.index');
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
    public function destroy($id)
    {
        //
    }

    public function userprofile(User $user) {
        if (Auth::user()->id === $user->id) {
            return view('users.profile', compact('user'));
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function verify_user(User $user)
    {
        if (Auth::user()->id === $user->id) {
            if ($user->verification->verify !== '1') {
                return view('users.verification_form');
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function verify_request(Request $request)
    {
        $verification = UserVerification::find(Auth::user()->user_verifications_id);
        if ($request && $verification->verify !== '1') {
            $verification->title = $request->title;
            $verification->name = $request->name;
            $verification->lastname = $request->lastname;
            $verification->secret = $request->secret;
            if ($request->hasFile('id_card')) {
                $image = $request->file('id_card');
                $filename = 'id_'.time() . '01' . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/verifications/'.Auth::user()->id.'/');
                if (!file_exists($location)) {
                    $result = File::makeDirectory($location, 0775, true);
                }
                $request->file('id_card')->move($location, $filename);
                if ($verification->id_card == NULL){
                    $verification->id_card = $filename;
                }
                else if ($verification->id_card != NULL){
                    $oldFilename = $verification->id_card;
                    $verification->id_card = $filename;
                    $location = public_path('images/verifications/'.Auth::user()->id.'/'.$oldFilename);
                    File::delete($location);
                }
            }
            if ($request->hasFile('census_registration')) {
                $image = $request->file('census_registration');
                $filename = 'cr_'.time() . '02' . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/verifications/'.Auth::user()->id.'/');
                if (!file_exists($location)) {
                    $result = File::makeDirectory($location, 0775, true);
                }
                $request->file('census_registration')->move($location, $filename);
                if ($verification->census_registration == NULL){
                    $verification->census_registration = $filename;
                }
                else {
                    $oldFilename = $verification->census_registration;
                    $verification->census_registration = $filename;
                    $location = public_path('images/verifications/'.Auth::user()->id.'/'.$oldFilename);
                    File::delete($location);
                }
            }
            $verification->save();
            Session::flash('success', "Thank you, It will be considered shortly after, the maximum time of consideration being 24 hours. In case your request is declined, you will receive a notification to your e-mail address.");
        }
        return redirect()->route('dashboard.account.index');
    }

    public function description(User $user){
        if ($user) {
            return view('users.description')->with('user', $user);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function updateimage(User $user, Request $request){
        if ($user) {
            if ($request->hasFile('user_image')) {
                if ($user->user_image != NULL){
                    $oldFilename = $user->user_image;
                    $location = public_path('images/users/'.$user->id. '/' .$oldFilename);
                    File::delete($location);
                }
                $image = $request->file('user_image');
                $filename = 'pf'.time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $user->user_image = $filename;
                $location = public_path('images/users/'.Auth::user()->id.'/');
                if (!file_exists($location)) {
                    $result = File::makeDirectory($location, 0775, true);
                }
                $request->file('user_image')->move($location, $filename);
            }

            $user->save();
            Session::flash('success', 'Your profile picture has been updated.');
            return redirect()->route('dashboard.account.index');
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }
}
