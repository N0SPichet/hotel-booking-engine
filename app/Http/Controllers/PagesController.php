<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\House;
use App\Address;
use App\Addresscity;
use App\Addressstate;
use App\Addresscountry;
use DateTime;
use App\Diary;
use App\Category;
use Mail;
use App\Rental;
use App\Payment;
use App\User;
use App\Himage;
use Carbon;
use Session;

class PagesController extends Controller
{
    public function index() {
        // $tomorrow = Carbon::tomorrow();
        // $rentals_in = Rental::where('rental_datein', '<=', $tomorrow)->get();
        // foreach ($rentals_in as $rental) {
        //     if ($rental->payments->payment_status == NULL) {
        //         $rental->payments->payment_status = 'Out of Date';
        //         if ($rental->houses->housetypes_id == '1') {
        //             $house = House::find($rental->houses->id);
        //             $house->no_rooms = $house->no_rooms + $rental->no_rooms;
        //             $house->save();
        //         }
        //         $rental->rental_checkroom = '1';
        //         $rental->payments->save();
        //         $rental->save();
        //     }
        //     if ($rental->host_decision != 'ACCEPT') {
        //         $rental->host_decision = 'EARLY';
        //         $rental->rental_checkroom = '1';
        //         $rental->save();
        //     }
        // }
        // $rentals_out = Rental::where('rental_dateout', '<=', $tomorrow)->get();
        // foreach ($rentals_out as $rental) {
        //     if ($rental->rental_checkroom == '0') {
        //         if ($rental->checkin_status == '1') {
        //             if ($rental->houses->housetypes_id == '1') {
        //                 $house = House::find($rental->houses->id);
        //                 $house->no_rooms = $house->no_rooms + $rental->no_rooms;
        //                 $house->save();
        //             }
        //             $rental->rental_checkroom = '1';
        //             $rental->save();
        //         }
        //         if ($rental->host_decision == NULL && $rental->checkin_status == NULL){
        //             $rental->host_decision = 'REJECT';
        //             $rental->rental_checkroom = '1';
        //             $rental->save();
        //         }
        //     }
        // }

        $houses = House::where('publish', '2')->inRandomOrder()->paginate(10);
        $images = Himage::all();
        return view('pages.home')->with('houses', $houses)->with('images', $images);
    }

    // public function index() {
    //     return view('pages.home_new');
    // }

    public function indexSearch(Request $request) {
        if ($request->search) {
            $state = Addressstate::where('state_name', 'like', '%'.$request->search.'%')->first();
            if ($state != NULL) {
                $houses = House::where('publish', '1')->where('addressstates_id', $state->id)->paginate(10);
                $images = Himage::all();
            }
            else {
                $houses = NULL;
                $images = NULL;
            }
            return view('pages.home')->with('houses', $houses)->with('images', $images);
        }
        else {
            return redirect()->route('home');
        }
    }

    public function userprofile() {
        if (Auth::check()) {
            $user = User::where('email', Auth::user()->email)->first();
            return view('users.profile', compact('user'));
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    //Diaries
    public function mydiaries()
    {
        if (Auth::check()) {
            $diaries = Diary::where('users_id', Auth::user()->id)->whereNull('days')->orWhere('days', '0')->orderBy('created_at', 'desc')->paginate(10);
            return view('diaries.mydiary')->with('diaries', $diaries);
            }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function introroom()
    {
        if (Auth::check()) {
            return view('hosts.introroom');
        }
    }

    public function introapartment()
    {
        if (Auth::check()) {
            return view('hosts.introapartment');
        }
    }

    public function summary()
    {
        if (Auth::check()) {
            $house_id = House::where('users_id', Auth::user()->id)->get();
            $h_id = array();
            foreach ($house_id as $key => $house) {
                $h_id[$key] = $house->id;
            }

            $rentals = Rental::whereIn('houses_id', $h_id)->count();

            $rental_accept = Rental::whereIn('houses_id', $h_id)->where(function ($query) {
                $query->where('host_decision', 'ACCEPT');
            })->count();

            $rental_reject = Rental::whereIn('houses_id', $h_id)->where(function ($query) {
                $query->where('host_decision', 'REJECT');
            })->count();

            $rental_ignore = Rental::whereIn('houses_id', $h_id)->where(function ($query) {
                $query->where('host_decision', NULL)->where('rental_checkroom', '!=', '1');
            })->count();

            $rental_id = Rental::whereIn('houses_id', $h_id)->get();
            $p_id = array();
            foreach ($rental_id as $key => $rental) {
                $p_id[$key] = $rental->payments_id;
            }

            $payment_approved = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Approved');
            })->get();
            $total_payment = 0;
            foreach ($payment_approved as $key => $payment) {
                $total_payment += $payment->payment_amount * 0.9;
            }

            $payment_approved = Payment::whereIn('id', $p_id)->where(function ($query) {
                $lastmonth =  new Carbon('last month');
                $query->where('payment_status', 'Approved')->where('created_at', '>=', $lastmonth);
            })->get();
            $payment_lastmonth = 0;
            foreach ($payment_approved as $key => $payment) {
                $payment_lastmonth += $payment->payment_amount * 0.9;
            }

            $rentals_id = Rental::whereIn('houses_id', $h_id)->where(function ($query) {
                $query->where('host_decision', 'ACCEPT');
            })->get();
            $p_id = array();
            foreach ($rentals_id as $key => $rental) {
                $p_id[$key] = $rental->payments_id;
            }

            $approved = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Approved');
            })->count();

            $waiting = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Waiting');
            })->count();

            $reject = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Reject');
            })->count();

            $cancel = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Cancel');
            })->count();

            $ofd = Payment::whereIn('id', $p_id)->where(function ($query) {
                $query->where('payment_status', 'Out of Date');
            })->count();

            $data = array(
                'rental_accept' => $rental_accept,
                'rental_reject' => $rental_reject,
                'rental_ignore' => $rental_ignore,
                'total_payment' => $total_payment,
                'payment_lastmonth' => $payment_lastmonth,
                'approved' => $approved,
                'waiting' => $waiting,
                'reject' => $reject,
                'cancel' => $cancel,
                'ofd' => $ofd,
                'rental_id' => $rental_id
            );

            return view('pages.summary')->with('rentals', $rentals)->with($data);
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function aboutus()
    {
    	return view('pages.about');
    }
}
