<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserVerification;
use App\House;
use App\Addresscountry;
use App\Addressstate;
use App\Addresscity;
use File;
use Image;
use Storage;
use Session;
use Purifier;

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
        if (Auth::check()) {
            if (Auth::user()->level == '0') {
                $users = User::all();
                return view('users.index', compact('users'));
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function userverify_index()
    {
        if (Auth::check()) {
            if (Auth::user()->level == '0') {
                $verifications = UserVerification::where('verify', '0')->get();
                $vrf_id = array();
                foreach ($verifications as $index => $verify) {
                    $vrf_id[$index] = $verify->id;
                }
                $users = NULL;
                if (count($verifications) != '0') {
                    foreach ($verifications as $index => $verify) {
                        $users = User::whereIn('user_verifications_id', $vrf_id)->get();
                    }
                }
                return view('users.index-verify')->with('users', $users);
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
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
        if ($user) {
            $houses = House::where('users_id', $user->id)->get();
            return view('users.show')->with('user', $user)->with('houses', $houses);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function userverify_show($id)
    {
        if (Auth::check()) {
            $user = User::find($id);
            if ($user) {
                if (Auth::user()->id == $user->id || Auth::user()->level == '0') {
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
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function userverify()
    {
        if (Auth::check()) {
            if (Auth::user()->user_verifications->verify != '1') {
                if (Auth::user()->user_verifications->title == NULL && Auth::user()->user_verifications->name == NULL && Auth::user()->user_verifications->lastname == NULL && Auth::user()->user_verifications->id_card == NULL && Auth::user()->user_verifications->census_registration == NULL) {
                    return view('users.verification_form');
                }
                else {
                    Session::flash('success', "You already submit the verification form.");
                    return back();
                }
            }
            else {
                Session::flash('success', "Your account already verifired.");
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function userrequestverify(Request $request)
    {
        $verification = UserVerification::find(Auth::user()->user_verifications_id);
        if ($request) {
            $verification->verify = '0';
            $verification->title = $request->title;
            $verification->name = $request->name;
            $verification->lastname = $request->lastname;
            if ($request->hasFile('id_card')) {
                $image = $request->file('id_card');
                $filename = time() . '01' . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/verification/id_card/'.Auth::user()->id.'/');
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
                    $location = public_path('images/users/'.$oldFilename);
                    File::delete($location);
                }
            }
            if ($request->hasFile('census_registration')) {
                $image = $request->file('census_registration');
                $filename = time() . '02' . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/verification/census_registration/'.Auth::user()->id.'/');
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
                    $location = public_path('images/users/'.$oldFilename);
                    File::delete($location);
                }
            }
            $verification->save();
            Session::flash('success', "Thank you, It will be considered shortly after, the maximum time of consideration being 24 hours. In case your request is declined, you will receive a notification to your e-mail address.");
            return redirect()->route('users.profile');
        }
    }

    public function userverify_approve($id)
    {
        if (Auth::check()) {
            if (Auth::user()->level == '0') {
                $user = User::find($id);
                if ($user) {
                    $user_verification = UserVerification::find($user->user_verifications_id);
                    $user_verification->verify = '1';
                    $user_verification->save();
                    return redirect()->route('user.verify-show', $user->id);
                }
                else {
                    Session::flash('fail', 'This user is no longer available.');
                    return back();
                }
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function userverify_reject($id)
    {
        if (Auth::check()) {
            if (Auth::user()->level == '0') {
                $user = User::find($id);
                if ($user) {
                    $user_verification = UserVerification::find($user->user_verifications_id);
                    $filename = $user_verification->id_card;
                    $location = public_path('images/verification/id_card/'.$user->id.'/'.$filename);
                    File::delete($location);
                    $filename = $user_verification->census_registration;
                    $location = public_path('images/verification/census_registration/'.$user->id.'/'.$filename);
                    File::delete($location);
                    $user_verification->verify = '2';
                    $user_verification->title = NULL;
                    $user_verification->name = NULL;
                    $user_verification->lastname = NULL;
                    $user_verification->id_card = NULL;
                    $user_verification->census_registration = NULL;
                    $user_verification->save();
                    return redirect()->route('user.verify-show', $user->id);
                }
                else {
                    Session::flash('fail', 'This user is no longer available.');
                    return back();
                }
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
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
        if (Auth::check()) {
            if (Auth::user()->id == $id) {
                $user = User::find($id);
                $cities = Addresscity::all();
                $countries = Addresscountry::all();
                $states = Addressstate::all();
                return view('users.edit')->with('cities', $cities)->with('user', $user)->with('countries', $countries)->with('states', $states);
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
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
        //validate the data
        $this->validate($request, array(
            'user_fname' => 'required|max:255',
            'user_lname' => 'required|max:255',
            'user_tel' => 'max:10',
        ));
        if (Auth::check()) {
            if (Auth::user()->id == $id) {
                $user = User::find($id);

                $user->user_fname = $request->input('user_fname');
                $user->user_lname = $request->input('user_lname');

                $user->user_tel = $request->input('user_tel');

                $user->user_gender = $request->input('user_gender');
                if ($user->user_gender == '1') {
                    $user->user_gender = 'Male';
                }
                else {
                    $user->user_gender = 'Female';
                }

                $user->user_address = $request->input('user_address');
                if ($request->user_city != '0') {
                    $user->user_city = $request->input('user_city');
                }
                if ($request->user_state != '0') {
                    $user->user_state = $request->input('user_state');
                }
                if ($request->user_country != '0') {
                    $user->user_country = $request->input('user_country');
                }

                $user->user_description = Purifier::clean($request->input('user_description'));

                Session::flash('success', 'Profile updated successfully.');

                $user->save();

                return redirect()->route('users.profile', $user->id);
            }
            else {
                Session::flash('fail', 'Request not found, url invalid!');
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
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
        if ($user) {
            return view('users.description')->with('user', $user);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function ureport($id){
        $user = User::find($id);
        if ($user) {
            if($user->user_score == 1){
                return redirect()->route('users.show', $id);
            }
            $user->user_score = $user->user_score - 0.1;
            $user->save();
            Session::flash('success', 'This user has been reported.');
            return redirect()->route('users.show', $id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function updateimage(Request $request, $id){
        $user = User::find($id);
        if (Auth::check()) {
            if ($user) {
                if ($request->hasFile('user_image')) {
                    if ($user->user_image != NULL){
                        $oldFilename = $user->user_image;
                        $location = public_path('images/users/'.$user->id. '/' .$oldFilename);
                        File::delete($location);
                    }
                    $image = $request->file('user_image');
                    $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
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
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }
}
