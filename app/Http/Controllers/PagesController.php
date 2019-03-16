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

    public function aboutus()
    {
    	return view('pages.about');
    }

    public function dashboard_index()
    {
        $types_room_id = $this->getTypeId('room');
        $types_apartment_id = $this->getTypeId('apartment');
        $apartments = House::where('publish', '!=', '3')->whereIn('housetype_id', $types_apartment_id)->where('user_id', Auth::user()->id)->get();
        $rooms = House::where('publish', '!=', '3')->whereIn('housetype_id', $types_room_id)->where('user_id', Auth::user()->id)->get();
        $houses = Auth::user()->houses()->where('publish', '!=', '3')->get();
        $houses_id = array();
        foreach ($houses as $key => $house) {
            array_push($houses_id, $house->id);
        }
        $rentals = Rental::whereIn('house_id', $houses_id)->where('host_decision', 'waiting')->join('payments', 'rentals.payment_id', 'payments.id')->whereNull('payment_status')->get();
        return view('dashboard.index')->with('apartments', $apartments)->with('rooms', $rooms)->with('rentals', $rentals);
    }

    public function dashboard_diaries_index()
    {
        $diaries = Auth::user()->diaries()->where(function ($query) {
            $query->whereNull('days')->orWhere('days', '0');
        })->orderBy('id', 'desc')->take(5)->get();
        return view('dashboard.index-diaries')->with('diaries', $diaries);
    }

    public function dashboard_trips_index()
    {
        $rentals = Auth::user()->rentals()->orderBy('id', 'desc')->take(5)->get();
        return view('dashboard.index-trips')->with('rentals', $rentals);
    }

    public function dashboard_hosts_index()
    {
        $types_apartment_id = $this->getTypeId('apartment');
        $types_room_id = $this->getTypeId('room');
        $apartments = Auth::user()->houses()->where('publish', '!=', '3')->whereIn('housetype_id', $types_apartment_id)->orderBy('id', 'desc')->take(5)->get();
        $rooms = Auth::user()->houses()->where('publish', '!=', '3')->whereIn('housetype_id', $types_room_id)->orderBy('id', 'desc')->take(5)->get();
        $apartments_total = Auth::user()->houses()->where('publish', '!=', '3')->whereIn('housetype_id', $types_apartment_id)->count();
        $rooms_total = Auth::user()->houses()->where('publish', '!=', '3')->whereIn('housetype_id', $types_room_id)->count();
        $data = [
            'apartments_total'=>$apartments_total,
            'rooms_total'=>$rooms_total
        ];
        return view('dashboard.index-hosts')->with('apartments', $apartments)->with('rooms', $rooms)->with($data);
    }

    public function dashboard_rentals_index()
    {
        return redirect()->route('rentals.rentmyrooms', Auth::user()->id);
    }

    public function dashboard_summary_index()
    {
        $houses = Auth::user()->houses;
        $houses_id = array();
        foreach ($houses as $key => $house) {
            array_push($houses_id, $house->id);
        }

        $rental_accept = Rental::whereIn('house_id', $houses_id)->where(function ($query) {
            $query->where('host_decision', 'accept');
        })->count();

        $rental_reject = Rental::whereIn('house_id', $houses_id)->where(function ($query) {
            $query->where('host_decision', 'reject');
        })->count();

        $rental_ignore = Rental::whereIn('house_id', $houses_id)->where(function ($query) {
            $query->where('host_decision', 'waiting')->where('rental_checkroom', '!=', '1');
        })->count();

        $rentals = Rental::whereIn('house_id', $houses_id)->get();
        $payments_id = array();
        foreach ($rentals as $key => $rental) {
            array_push($payments_id, $rental->payment_id);
        }

        $payment_approved = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $query->where('payment_status', 'Approved');
        })->get();
        $total_payment = 0;
        foreach ($payment_approved as $key => $payment) {
            $total_payment += $payment->payment_amount * 0.9;
        }

        $payment_approved = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $lastmonth =  new Carbon('last month');
            $query->where('payment_status', 'Approved')->where('created_at', '>=', $lastmonth);
        })->get();
        $payment_lastmonth = 0;
        foreach ($payment_approved as $key => $payment) {
            $payment_lastmonth += $payment->payment_amount * 0.9;
        }

        $rentals_accept = Rental::whereIn('house_id', $houses_id)->where(function ($query) {
            $query->where('host_decision', 'accept');
        })->get();
        $payments_id = array();
        foreach ($rentals_accept as $key => $rental) {
            array_push($payments_id, $rental->payment_id);
        }

        $approved = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $query->where('payment_status', 'Approved');
        })->count();

        $waiting = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $query->where('payment_status', 'Waiting');
        })->count();

        $reject = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $query->where('payment_status', 'Reject');
        })->count();

        $cancel = Payment::whereIn('id', $payments_id)->where(function ($query) {
            $query->where('payment_status', 'Cancel');
        })->count();

        $ofd = Payment::whereIn('id', $payments_id)->where(function ($query) {
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
            'ofd' => $ofd
        );

        return view('dashboard.index-summary')->with('rentals', $rentals)->with($data);
    }

    public function dashboard_account_index()
    {
        return view('dashboard.index-account');
    }

    public function dashboard_rooms_online($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('room');
            $houses = House::where('publish', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('rooms.index-myroom')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('dashboard.index', Auth::user()->id);
    }

    public function dashboard_rooms_offline($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('room');
            $houses = House::where('publish', '!=', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('rooms.index-myroom')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('dashboard.index', Auth::user()->id);
    }

    public function dashboard_apartments_online($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('apartment');
            $houses = House::where('publish', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('apartments.index-myapartment')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('dashboard.index', Auth::user()->id);
    }

    public function dashboard_apartments_offline($userId)
    {
        if (Auth::user()->id == $userId) {
            $types_room_id = $this->getTypeId('apartment');
            $houses = House::where('publish', '!=', '1')->whereIn('housetype_id', $types_room_id)->where('user_id', $userId)->orderBy('id')->paginate(10);
            return view('apartments.index-myapartment')->with('houses', $houses);
        }
        Session::flash('fail', 'Unauthorized access.');
        return redirect()->route('dashboard.index', Auth::user()->id);
    }
}
