<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\Category;
use App\Models\Diary;
use App\Models\HouseImage;
use App\Models\House;
use App\Models\Payment;
use App\Models\Province;
use App\Models\Rental;
use App\User;
use Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Session;

class PagesController extends Controller
{
    use GlobalFunctionTraits;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show', 'aboutus']]);
    }
    
    public function index() {
        $houses = House::where('publish', '1')->inRandomOrder()->paginate(10);
        $houses_id = array();
        foreach ($houses as $key => $house) {
            array_push($houses_id, $house->id);
        }
        $images = HouseImage::whereIn('house_id', $houses_id)->get();
        return view('pages.home')->with('houses', $houses)->with('images', $images);
    }

    public function indexSearch(Request $request) {
        if ($request->search) {
            $province = Province::where('name', 'like', '%'.$request->search.'%')->first();
            if (!is_null($province)) {
                $houses = House::where('publish', '1')->where('province_id', $province->id)->paginate(10);
                $houses_id = array();
                foreach ($houses as $key => $house) {
                    array_push($houses_id, $house->id);
                }
                $images = HouseImage::whereIn('house_id', $houses_id)->get();
                return view('pages.home')->with('houses', $houses)->with('images', $images);
            }
        }
        return redirect()->route('home');
    }

    public function introroom()
    {
        return view('hosts.introroom');
    }

    public function introapartment()
    {
        return view('hosts.introapartment');
    }

    public function summary()
    {
        $house_id = House::where('user_id', Auth::user()->id)->get();
        $h_id = array();
        foreach ($house_id as $key => $house) {
            $h_id[$key] = $house->id;
        }

        $rentals = Rental::whereIn('house_id', $h_id)->count();

        $rental_accept = Rental::whereIn('house_id', $h_id)->where(function ($query) {
            $query->where('host_decision', 'accept');
        })->count();

        $rental_reject = Rental::whereIn('house_id', $h_id)->where(function ($query) {
            $query->where('host_decision', 'reject');
        })->count();

        $rental_ignore = Rental::whereIn('house_id', $h_id)->where(function ($query) {
            $query->where('host_decision', 'waiting')->where('rental_checkroom', '!=', '1');
        })->count();

        $rental_id = Rental::whereIn('house_id', $h_id)->get();
        $p_id = array();
        foreach ($rental_id as $key => $rental) {
            $p_id[$key] = $rental->payment_id;
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

        $rentals_id = Rental::whereIn('house_id', $h_id)->where(function ($query) {
            $query->where('host_decision', 'accept');
        })->get();
        $p_id = array();
        foreach ($rentals_id as $key => $rental) {
            $p_id[$key] = $rental->payment_id;
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

    public function aboutus()
    {
    	return view('pages.about');
    }

    public function manages_index($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('room');
            $types_apartment_id = $this->getTypeId('apartment');
            $apartments = House::where('publish', '!=', '3')->whereIn('housetype_id', $types_apartment_id)->where('user_id', $userId)->get();
            $rooms = House::where('publish', '!=', '3')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->get();
            $diaries = Diary::whereIn('publish', ['0', '1', '2', '3'])->where(function($query) {
                $query->whereNull('days')->orWhere('days', '0');
            })->where('user_id', $userId)->get();
            return view('manages.index')->with('apartments', $apartments)->with('rooms', $rooms)->with('diaries', $diaries);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('manages.index', Auth::user()->id);
    }

    public function manages_rooms_online($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('room');
            $houses = House::where('publish', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('rooms.index-myroom')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('manages.index', Auth::user()->id);
    }

    public function manages_rooms_offline($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('room');
            $houses = House::where('publish', '!=', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('rooms.index-myroom')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('manages.index', Auth::user()->id);
    }

    public function manages_apartments_online($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('apartment');
            $houses = House::where('publish', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('apartments.index-myapartment')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('manages.index', Auth::user()->id);
    }

    public function manages_apartments_offline($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('apartment');
            $houses = House::where('publish', '!=', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('apartments.index-myapartment')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('manages.index', Auth::user()->id);
    }
}
