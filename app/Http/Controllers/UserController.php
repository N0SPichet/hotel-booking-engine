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
        $this->middleware('auth');
        $this->middleware('crole:Admin')->except('show', 'edit', 'update', 'userprofile', 'updateimage', 'description', 'verify_user', 'verify_show', 'verify_request', 'verify_show');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (!is_null($user)) {
            $houses = House::where('user_id', $user->id)->get();
            return view('users.show')->with('user', $user)->with('houses', $houses);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->id === $user->id) {
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
        if (Auth::user()->id === $user->id) {
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
            return redirect()->route('users.profile', $user->id);
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

    public function verify_index()
    {
        $verifications = UserVerification::where('verify', '0')->get();
        $vrf_id = array();
        foreach ($verifications as $index => $verify) {
            array_push($vrf_id, $verify->id);
        }
        $users = NULL;
        if (count($verifications) != '0') {
            foreach ($verifications as $index => $verify) {
                $users = User::whereIn('user_verifications_id', $vrf_id)->get();
            }
        }
        return view('users.index-verify')->with('users', $users);
    }

    public function verify_show(User $user)
    {
        if ($user) {
            if (Auth::user()->id === $user->id || Auth::user()->hasRole('Admin')) {
                return view('users.verification_show')->with('user', $user);
            }
            else {
                return back();
            }
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
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
            return redirect()->route('users.profile', Auth::user()->id);
        }
        else {
            return redirect()->route('users.profile', Auth::user()->id);
        }
    }

    public function verify_approve(User $user)
    {
        if ($user) {
            $verification = UserVerification::find($user->user_verifications_id);
            $verification->verify = '1';
            $passport = bcrypt(Auth::user()->id.Auth::user()->email.Auth::user()->created_at);
            $passport = str_replace(' ', '-', $passport);
            $passport = preg_replace('/[^A-Za-z0-9\-]/', '', $passport);
            $verification->passport = $passport;
            $verification->save();
            return redirect()->route('users.verify-show', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function verify_reject(User $user)
    {
        if ($user) {
            $user_verification = UserVerification::find($user->user_verifications_id);
            $filename = $user_verification->id_card;
            $location = public_path('images/verification/'.$user->id.'/'.$filename);
            File::delete($location);
            $filename = $user_verification->census_registration;
            $location = public_path('images/verification/'.$user->id.'/'.$filename);
            File::delete($location);
            $user_verification->verify = '2';
            $user_verification->title = null;
            $user_verification->name = null;
            $user_verification->lastname = null;
            $user_verification->id_card = null;
            $user_verification->census_registration = null;
            $user_verification->save();
            return redirect()->route('user.verify-show', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
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

    public function block(User $user){
        if ($user) {
            if($user->user_score === 0){
                return redirect()->route('users.show', $user->id);
            }
            $user->user_score = 0;
            $user->save();
            Session::flash('success', 'This user has been blocked.');
            return redirect()->route('users.show', $user->id);
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
            return redirect()->route('users.profile', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }
}
