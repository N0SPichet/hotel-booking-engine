<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use App\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::orderBy('id')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function show($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
            return view('admin.users.show')->with('user', $user);
        }
        else {
            $name_str = explode("@", $userId);
            $name_str = explode("_", $name_str[1]);
            $user = User::where('user_fname', 'like', '%'.$name_str[0].'%')->where('user_lname', 'like', '%'.$name_str[1].'%')->first();
            if (!is_null($user)) {
                return view('admin.users.show')->with('user', $user);
            }
        }
        Session::flash('fail', 'This user is no longer available.');
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
        return view('admin.users.index-verify')->with('users', $users);
    }

    public function verify_show($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
        	return view('admin.users.verification_show')->with('user', $user);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function verify_approve($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
            $verification = UserVerification::find($user->user_verifications_id);
            $verification->verify = '1';
            $passport = bcrypt(Auth::user()->id.Auth::user()->email.Auth::user()->created_at);
            $passport = str_replace(' ', '-', $passport);
            $passport = preg_replace('/[^A-Za-z0-9\-]/', '', $passport);
            $verification->passport = $passport;
            $verification->save();
            return redirect()->route('admin.users.verify-show', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function verify_reject($userId)
    {
        $user = User::find($userId);
        if (!is_null($user)) {
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
            return redirect()->route('admin.users.verify-show', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }

    public function block($userId){
        $user = User::find($userId);
        if (!is_null($user)) {
            if($user->user_score === 0){
                return redirect()->route('admin.users.show', $user->id);
            }
            $user->user_score = 0;
            $user->save();
            Session::flash('success', 'This user has been blocked.');
            return redirect()->route('admin.users.show', $user->id);
        }
        else {
            Session::flash('fail', 'This user is no longer available.');
            return back();
        }
    }
}
