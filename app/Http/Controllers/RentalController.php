<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\Diary;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Houserule;
use App\Models\Housetype;
use App\Models\Map;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Review;
use App\Models\Subscribe;
use App\User;
use Carbon\Carbon;
use DateTime;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Mail;
use Session;

class RentalController extends Controller
{
    use GlobalFunctionTraits;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('crole:Admin')->except('create', 'show', 'store', 'edit', 'update', 'destroy', 'mytrip', 'rentmyrooms', 'rentals_agreement', 'accept_rentalrequest', 'reject_rentalrequest', 'rental_cancel', 'renthistories', 'checkcode', 'not_reviews');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rentals = Rental::orderBy('id', 'desc')->paginate(10);
        return view('rentals.index')->with('rentals', $rentals);
    }

    public function mytrip($userId)
    {   
        $user = User::findOrFail($userId);
        if (Auth::user()->id == $user->id) {
            $rentals = Rental::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);
            $reviews = Review::where('user_id', $user->id)->get();
            $rentals_id = array();
            foreach ($reviews as $key => $review) {
                array_push($rentals_id, $review->rental_id);
            }
            $rentals_not_review = Rental::whereNotIn('id', $rentals_id)->where('user_id', $user->id)->where('checkin_status', '1')->get();
            $data = array(
                'review_count' => $rentals_not_review->count()
            );
            return view('rentals.mytrip')->with('rentals', $rentals)->with($data);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function not_reviews($userId)
    {
        $user = User::findOrFail($userId);
        if (Auth::user()->id == $user->id) {
            $myReviews = Review::where('user_id', Auth::user()->id)->get();
            $rentals_id = array();
            foreach ($myReviews as $key => $review) {
                array_push($rentals_id, $review->rental_id);
            }
            $rentals = Rental::whereNotIn('id', $rentals_id)->where('user_id', Auth::user()->id)->where('checkin_status', '1')->paginate(5);
            $data = array(
                'review_count' => $rentals->count()
            );
            return view('rentals.mytrip')->with('rentals', $rentals)->with($data);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rentals.create');
    }

    public function rentals_agreement(Request $request)
    {
        $this->validate($request, array(
            'datein' => 'required',
            'dateout' => 'required'
        ));
        $have_customer = '0';
        $datein = $request->datein;
        $dateout = $request->dateout;
        $house = House::find($request->id);
        if ($dateout > $datein) {
            // nstart>start && nstart>=stop ok
            // nstart<start && nstop<=start ok
            if ($house->checkType($house->id)) {
                $food = $request->food;
                $guest = $request->guest;
                $room = $request->room;
                $now = Carbon::now('Asia/bangkok');
                $now->subDay();
                $rentals = Rental::where('houses_id', $house->id)->where('rental_datein', '>', $now)->where( function ($query) {
                    $query->where('host_decision', 'ACCEPT')->where('checkin_status', '0');
                })->orderBy('id', 'desc')->get();
                foreach ($rentals as $rental) {
                    if ($rental->payment->payment_status == 'Waiting' || $rental->payment->payment_status == 'Approved' || $rental->payment->payment_status == null) {
                        if ($datein > $rental->rental_datein) {
                            // echo "in after<br>";
                            if ($datein >= $rental->rental_dateout) {
                                // echo "in after out<br>";
                                if ($rental->payment->payment_status == 'Waiting' || $rental->payment->payment_status == 'Approved' || $rental->payment->payment_status == null) {
                                    $have_customer = '0';
                                }
                                else {
                                    $have_customer = '1';
                                }
                            }
                            else {
                                // echo "in before out";
                                $have_customer = '1';
                            }
                        }
                        elseif ($datein == $rental->rental_datein) {
                            // echo "in same<br>";
                            if ($rental->payment->payment_status == 'Waiting' || $rental->payment->payment_status == 'Approved' || $rental->payment->payment_status == null) {
                                if ($rental->no_rooms != $request->room) {
                                    $have_customer = '0';
                                }
                                else {
                                    $have_customer = '1';
                                }
                            }
                            else {
                                $have_customer = '1';
                            }
                        }
                        elseif ($datein < $rental->rental_datein) {
                            // echo "in before<br>";
                            if ($dateout <= $rental->rental_datein) {
                                // echo "out before in";
                                if ($rental->payment->payment_status == 'Waiting' || $rental->payment->payment_status == 'Approved' || $rental->payment->payment_status == null) {
                                    $have_customer = '0';
                                }
                                else {
                                    $have_customer = '1';
                                }
                            }
                            elseif ($dateout > $rental->rental_datein) {
                                // echo "out after out";
                                $have_customer = '1';
                            }
                        }
                    }
                }
                if ($have_customer == '0') {
                    $data = array(
                        'id' => $house->id,
                        'types' => 'room',
                        'datein' => $datein,
                        'dateout' => $dateout,
                        'guest' => $guest,
                        'food' => $food,
                        'no_rooms' => $room
                    );
                    return view('rentals.agreement')->with($data)->with('house', $house);
                }
                Session::flash('fail', 'We have a customer in this day. Please choose other day!');
                return back();
            }
            else {
                $no_type_single = '0';
                $no_type_deluxe_single = '0';
                $no_type_double_room = '0';
                if ($request->type_single) {
                    $no_type_single = $request->type_single;
                }
                if ($request->type_deluxe_single) {
                    $no_type_deluxe_single = $request->type_deluxe_single;
                }
                if ($request->type_double_room) {
                    $no_type_double_room = $request->type_double_room;
                }
                $data = array(
                    'id' => $house->id,
                    'types' => 'apartment',
                    'datein' => $datein,
                    'dateout' => $dateout,
                    'no_type_single' => $no_type_single,
                    'type_single_price' => $house->apartmentprices->single_price,
                    'no_type_deluxe_single' => $no_type_deluxe_single,
                    'type_deluxe_single_price' => $house->apartmentprices->deluxe_single_price,
                    'no_type_double_room' => $no_type_double_room,
                    'type_double_room_price' => $house->apartmentprices->double_price
                );
                return view('rentals.agreement')->with($data)->with('house', $house);
            }
        }
        else {
            Session::flash('fail', 'Invalid date format, date in should come before date out!');
            return back();
        }
    }

    public function accept_rentalrequest(Rental $rental)
    {
        if ($rental->payment->payment_status == null && $rental->payment->payment_status != 'Cancel' && $rental->payment->payment_status != 'Out of Date') {
            $rental->host_decision = 'ACCEPT';

            $premessage = "Dear " . $rental->user->user_fname;
            $detailmessage = "Your host was accepted your booking " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout));
            $endmessage = "Next please have a payment to complete booking!";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - Booking request confirm",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage,
                'rentlUserId' => $rental->user_id
            );

            Mail::send('emails.booking_accepted', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });

            $rental->save();
            Session::flash('success', 'Thank you for accept this request.');
            return redirect()->route('rentals.rentmyrooms', $rental->user_id);
        }
        else {
            $payment = Payment::find($rental->payment_id);
            Session::flash('fail', "Cannot accept - This trip is already $payment->payment_status.");
            return back();
        }

    }

    public function reject_rentalrequest(Rental $rental) 
    {
        if ($rental->payment->payment_status == null && $rental->payment->payment_status != 'Cancel' && $rental->payment->payment_status != 'Out of Date') {
            $rental->host_decision = 'REJECT';
            $rental->rental_checkroom = '1';
            $rental->save();
            Session::flash('success', 'This request was rejected.');
            return redirect()->route('rentals.rentmyrooms', $rental->user_id);
        }
        else {
            $payment = Payment::find($rental->payment_id);
            Session::flash('fail', "Cannot reject - This trip is already $payment->payment_status.");
            return back();
        }
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
            'id' => 'required',
            'datein' => 'required',
            'dateout' => 'required',
        ));
        $house = House::find($request->id);
        $payment = new Payment;
        $rental = new Rental;
        $payment->save();
        if ($request->types == 'apartment') {            
            $rental->no_type_single = $request->no_type_single;
            $rental->type_single_price = $request->type_single_price;
            
            $rental->no_type_deluxe_single = $request->no_type_deluxe_single;
            $rental->type_deluxe_single_price = $request->type_deluxe_single_price;

            $rental->no_type_double_room = $request->no_type_double_room;
            $rental->type_double_room_price = $request->type_double_room_price;
            
            $rental->discount = $house->apartmentprices->discount;
        }
        else {
            $rental->rental_guest = $request->guest;
            $rental->no_rooms = $request->no_rooms;
            $rental->inc_food = $request->food;
        }
        $rental->rental_datein = $request->datein;
        $rental->rental_dateout = $request->dateout;
        $rental->checkin_status = '0';
        $rental->user_id = Auth::user()->id;
        $rental->houses_id = $request->id;
        $rental->payment_id = $payment->id;
        $rental->save();

        $premessage = "Dear " . $rental->houses->user->user_fname;
        $detailmessage = $rental->user->user_fname . " " . $rental->user->user_lname . " request to booking your room. Please check Rentals page for accept this request";

        $data = array(
            'email' => $rental->houses->user->email,
            'subject' => "LTT - You have new customer",
            'bodyMessage' => $premessage,
            'detailmessage' => $detailmessage,
            'ownerId' => $rental->houses_id
        );

        Mail::send('emails.booking_request', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        $premessage = "Dear " . $rental->user->user_fname;
        $detailmessage = $rental->user->user_fname . " " . $rental->user->user_lname . " you was succussfully booking stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout));
        $endmessage = "Now, wait for host accept your booking and have a payment!";

        $data = array(
            'email' => $rental->user->email,
            'subject' => "LTT - Booking request confirm",
            'bodyMessage' => $premessage,
            'detailmessage' => $detailmessage,
            'guest' => $rental->rental_guest,
            'endmessage' => $endmessage,
            'rentlUserId' => $rental->user_id
        );

        Mail::send('emails.booking_confirm', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });


        Session::flash('success', 'You was succussfully booking, Now wait for host accept your booking and have a payment!');

        return redirect()->route('rentals.mytrips', Auth::user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rentalId)
    {
        $rental = Rental::find($rentalId);
        if (!is_null($rental)) {
            if (Auth::user()->id == $rental->user_id || Auth::user()->id == $rental->houses->user_id || Auth::user()->hasRole('Admin')) {
                $types_id = $this->getTypeId('apartment');
                $house = House::where('id', $rental->houses_id)->whereIn('housetype_id', $types_id)->first();
                if (!is_null($house)) {
                    $datetime1 = new DateTime($rental->rental_datein);
                    $datetime2 = new DateTime($rental->rental_dateout);
                    $interval = $datetime1->diff($datetime2);
                    $years = $interval->format('%y');
                    $months = $interval->format('%m');
                    $days = $interval->format('%d');
                    
                    $type_single_price = $rental->houses->apartmentprices->single_price*$rental->no_type_single*$days;
                    $type_deluxe_single_price = $rental->houses->apartmentprices->deluxe_single_price*$rental->no_type_deluxe_single*$days;
                    $type_double_room_price = $rental->houses->apartmentprices->double_price*$rental->no_type_double_room*$days;
                    $total_price = floor(($type_single_price + $type_deluxe_single_price + $type_double_room_price) * (1 - (0.01 * $rental->discount)));
                    $fee = floor($total_price*0.1);
                    $total_price = $total_price + $fee;

                    $review = Review::where('user_id', $rental->user_id)->where('rental_id', $rental->id)->first();
                    $map = Map::where('houses_id', $rental->houses->id)->first();
                    $data = array(
                        'days' => $days,
                        'type_single_price' => $type_single_price,
                        'type_deluxe_single_price' => $type_deluxe_single_price,
                        'type_double_room_price' => $type_double_room_price,
                        'fee' => $fee,
                        'total_price' => $total_price,
                        'types' => 'apartment'
                    );
                    return view('rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
                }
                else {
                    $types_id = $this->getTypeId('room');
                    $house = House::where('id', $rental->houses_id)->whereIn('housetype_id', $types_id)->first();
                    if (!is_null($house)) {
                        $datetime1 = new DateTime($rental->rental_datein);
                        $datetime2 = new DateTime($rental->rental_dateout);
                        $interval = $datetime1->diff($datetime2);
                        $years = $interval->format('%y');
                        $months = $interval->format('%m');
                        $days = $interval->format('%d');
                        $food_price = 0;

                        if ($days/7 >= 1 && $months < 1) {
                            $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                            if ($rental->inc_food == '1') {
                                $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                            }
                            $total_price = floor(($room_price + $food_price) * (1-(0.01 * $rental->houses->houseprices->weekly_discount)));
                            if (!$rental->houses->checkType($rental->houses_id)) {
                                $total_price *= $rental->no_rooms;
                            }
                            $fee = floor($total_price*0.1);
                            $total_price = $total_price + $fee;
                        }
                        elseif ($months >= 1) {
                            $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                            if ($rental->inc_food == '1') {
                                $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                            }
                            $total_price = floor(($room_price + $food_price) * (1-(0.01 * $rental->houses->houseprices->monthly_discount)));
                            if (!$rental->houses->checkType($rental->houses_id)) {
                                $total_price *= $rental->no_rooms;
                            }
                            $fee = floor($total_price*0.1);
                            $total_price = $total_price + $fee;
                        }
                        elseif ($days < 7) {
                            $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                            if ($rental->inc_food == '1') {
                                $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                            }
                            $total_price = floor(($room_price + $food_price));
                            if (!$rental->houses->checkType($rental->houses_id)) {
                                $total_price *= $rental->no_rooms;
                            }
                            $fee = floor($total_price*0.1);
                            $total_price = $total_price + $fee;
                        }
                        $review = Review::where('user_id', $rental->user_id)->where('rental_id', $rental->id)->first();
                        $map = Map::where('houses_id', $rental->houses->id)->first();
                        $data = array(
                            'days' => $days,
                            'total_price' => $total_price,
                            'types' => 'room'
                        );
                        return view('rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
                    }
                }
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        else {
            Session::flash('fail', 'This rental is no longer available.');
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Rental $rental)
    {
        if (!is_null($rental)) {
            if (Auth::user()->id == $rental->user_id) {
                $types_id = $this->getTypeId('apartment');
                $house = House::where('id', $rental->houses_id)->whereIn('housetype_id', $types_id)->first();
                $payment = Payment::find($rental->payment_id);
                $datetime1 = new DateTime($rental->rental_datein);
                $datetime2 = new DateTime($rental->rental_dateout);
                $interval = $datetime1->diff($datetime2);
                $years = $interval->format('%y');
                $months = $interval->format('%m');
                $days = $interval->format('%d');
                if (!is_null($house)) {
                    if ($payment->payment_status != 'Approved' && $payment->payment_status != 'Cancel' && $payment->payment_status != 'Out of Date' && $payment->payment_status != 'Reject' && $rental->host_decision == 'ACCEPT') {
                        $type_single_price = $rental->houses->apartmentprices->single_price*$rental->no_type_single*$days;
                        $type_deluxe_single_price = $rental->houses->apartmentprices->deluxe_single_price*$rental->no_type_deluxe_single*$days;
                        $type_double_room_price = $rental->houses->apartmentprices->double_price*$rental->no_type_double_room*$days;
                        $total_price = floor(($type_single_price + $type_deluxe_single_price + $type_double_room_price) * (1 - (0.01 * $rental->discount)));
                        $fee = floor($total_price*0.1);
                        $total_price = $total_price + $fee;
                        $discount = $rental->discount;
                        $data = array(
                            'years' => $years,
                            'months' => $months,
                            'days' => $days,
                            'discount' => $discount,
                            'type_single_price' => $type_single_price,
                            'type_deluxe_single_price' => $type_deluxe_single_price,
                            'type_double_room_price' => $type_double_room_price,
                            'fee' => $fee,
                            'total_price' => $total_price
                        );
                        return view('rentals.payment-apartment')->with($data)->with('rental', $rental)->with('payment', $payment);
                    }
                    elseif ($rental->host_decision == 'REJECT') {
                        Session::flash('fail', 'This payment already rejected by host.');
                        return back();
                    }
                    else {
                        Session::flash('success', 'This payment already '. $payment->payment_status. '.');
                        return back();
                    }
                    
                }
                else {
                    $types_id = $this->getTypeId('room');
                    $house = House::where('id', $rental->houses_id)->whereIn('housetype_id', $types_id)->first();
                    if (!is_null($house)) {
                        if ($payment->payment_status != 'Approved' && $payment->payment_status != 'Cancel' && $payment->payment_status != 'Out of Date' && $payment->payment_status != 'Reject' && $rental->host_decision == 'ACCEPT') {
                            $food_price = 0;
                            if ($days/7 >= 1 && $months < 1) {
                                $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                                if ($rental->inc_food == '1') {
                                    $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                                }
                                $total_price = floor(($room_price + $food_price) * (1-(0.01 * $rental->houses->houseprices->weekly_discount)));
                                if (!$rental->houses->checkType($rental->houses_id)) {
                                    $total_price *= $rental->no_rooms;
                                }
                                $fee = floor($total_price*0.1);
                                $total_price = $total_price + $fee;
                                $discount = $rental->houses->houseprices->weekly_discount;
                            }
                            elseif ($months >= 1) {
                                $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                                if ($rental->inc_food == '1') {
                                    $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                                }
                                $total_price = floor(($room_price + $food_price) * (1-(0.01 * $rental->houses->houseprices->monthly_discount)));
                                if (!$rental->houses->checkType($rental->houses_id)) {
                                    $total_price *= $rental->no_rooms;
                                }
                                $fee = floor($total_price*0.1);
                                $total_price = $total_price + $fee;
                                $discount = $rental->houses->houseprices->monthly_discount;
                            }
                            elseif ($days < 7) {
                                $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                                if ($rental->inc_food == '1') {
                                    $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                                }
                                $total_price = floor(($room_price + $food_price));
                                if (!$rental->houses->checkType($rental->houses_id)) {
                                    $total_price *= $rental->no_rooms;
                                }
                                $fee = floor($total_price*0.1);
                                $total_price = $total_price + $fee;
                                $discount = 0;
                            }
                            $data = array(
                                'id' => $rental->id,
                                'fee' => $fee,
                                'total_price' => $total_price,
                                'discount' => $discount,
                                'datein' => $rental->rental_datein,
                                'dateout' => $rental->rental_dateout,
                                'years' => $years,
                                'months' => $months,
                                'days' => $days,
                                'guest' => $rental->rental_guest
                            );    
                            return view('rentals.payment-room')->with($data)->with('rental', $rental)->with('payment', $payment);
                        }
                        elseif ($rental->host_decision == 'REJECT') {
                            Session::flash('fail', 'This payment already rejected by host.');
                            return back();
                        }
                    }
                }
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        else {
            Session::flash('fail', 'This trip is no longer available.');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paymentId)
    {
        $payment = Payment::find($paymentId);
        if (Auth::user()->id == $payment->rental->user_id) {
            $payment->payment_bankname = $request->banks_id;
            $payment->payment_bankaccount = $request->payment_bankaccount;
            $payment->payment_holder = $request->payment_holder;
            $payment->payment_amount = $request->payment_amount;
            $payment->payment_status = $request->payment_status;
            if ($request->hasFile('payment_transfer_slip')) {
                if ($payment->payment_transfer_slip != null) {
                    $location = public_path('images/payments/'.$payment->id.'/'.$payment->payment_transfer_slip);
                    File::delete($location);
                }
                $image = $request->file('payment_transfer_slip');
                $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/payments/'.$payment->id.'/');
                if (!file_exists($location)) {
                    $result = File::makeDirectory($location, 0775, true);
                }
                $location = public_path('images/payments/'.$payment->id.'/'.$filename);
                Image::make($image)->resize(640, 1062)->save($location);
                $payment->payment_transfer_slip = $filename;
            }
            $payment->save();

            $rental = Rental::where('payment_id', $payment->id)->first();
            $rental->discount = $request->discount;
            $rental->save();

            $premessage = "Dear " . $rental->user->user_fname . " " . $rental->user->user_lname . " , With reference to your request for bill payment via LTT Service as follows.";
            $detailmessage = $rental->user->user_fname . " " . $rental->user->user_lname . " has pay " . $rental->payment->payment_amount . " thai baht for booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . ".";
            $endmessage = "Now, wait for checking payment then you will completely booking and have a code for check-in.";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - Payment Result for Customer",
                'cusName' => $rental->user->user_fname,
                'bodyMessage' => $premessage,
                'detailmessage' =>  $detailmessage,
                'endmessage' => $endmessage,
                'rentlUserId' => $rental->user_id
            );

            Mail::send('emails.payment_confirm', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });

            return redirect()->route('rentals.mytrips', Auth::user()->id);
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

    public function rental_approve($rentalId)
    {
        $rental = Rental::find($rentalId);
        $payment = Payment::find($rental->payment_id);

        if ($payment->payment_status == 'Waiting') {
            $rental->checkincode = str_random(10);
            $payment->payment_status = "Approved";
            $rental->save();
            $payment->save();

            $premessage = "Dear " . $rental->user->user_fname;
            $detailmessage = $rental->user->user_fname . " request to booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been approved!";
            $endmessage = "Thank you and have a great trip!";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - You have a trip",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage,
                'rentlUserId' => $rental->user_id
            );

            Mail::send('emails.payment_approved', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });

            Session::flash('success', 'This trip has been approved.');
        }
        else {
            Session::flash('fail', "Cannot Approve - This trip is already $payment->payment_status");
        }
        return redirect()->route('rentals.index');
    }

    public function rental_cancel($rentalId)
    {
        $rental = Rental::find($rentalId);
        $payment = Payment::find($rental->payment_id);

        if ($rental->checkin_status == '1') {
            Session::flash('fail', 'Cannot Cancel - Rental #ID' . $rental->id . ' is already check in by yourself.');
        }
        else if ($payment->payment_status == 'Reject') {
            Session::flash('fail', 'Cannot Cancel - Rental #ID' . $rental->id . ' is already rejected by admin.');
        }
        else if ($payment->payment_status == 'Cancel') {
            Session::flash('fail', 'Cannot Cancel - Rental #ID' . $rental->id . ' is already canceled by yourself.');
        }
        else if ($rental->host_decision == 'REJECT') {
            Session::flash('fail', 'Cannot Cancel - Rental #ID' . $rental->id . ' is already rejected by host.');
        }
        else {
            $payment->payment_status = "Cancel";
            $payment->save();
            $rental->checkincode = null;
            $rental->rental_checkroom = '1';
            $rental->checkin_status = '2';
            $rental->save();
            if (!$rental->houses->checkType($rental->houses_id)) {
                $house = House::find($rental->houses->id);
                $house->no_rooms = $house->no_rooms + $rental->no_rooms;
                $house->save();
            }
            Session::flash('success', 'This trip has been canceled.');
        }
        return redirect()->route('rentals.mytrips', $rental->user_id);
    }

    public function rental_reject($rentalId)
    {
        $rental = Rental::find($rentalId);
        $payment = Payment::find($rental->payment_id);

        if ($payment->payment_status == 'Waiting') {
            $payment->payment_status = "Reject";
            if (!$rental->houses->checkType($rental->houses_id)) {
                $house = House::find($rental->houses->id);
                $house->no_rooms = $house->no_rooms + $rental->no_rooms;
                $house->save();
            }
            $rental->checkin_status = '2';

            $premessage = "Dear " . $rental->user->user_fname;
            $detailmessage = $rental->user->user_fname . " request to booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been rejected!";
            $endmessage = "Please try to send your payment transfer slip again and we will check for you.";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - You have a trip",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage
            );

            Mail::send('emails.payment_approved', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });
            
            $payment->save();
            Session::flash('success', 'This trip has been rejected.');
        }
        else {
            Session::flash('fail', "Cannot Reject - This trip is already $payment->payment_status.");
        }
        return redirect()->route('rentals.index');
    }

    public function rentmyrooms(User $user)
    {
        $now = Carbon::yesterday();
        $houses = House::where('user_id', Auth::user()->id)->get();
        $houses_id = array();
        foreach ($houses as $key => $house) {
            array_push($houses_id, $house->id);
        }
        
        /*payment with my house rentals*/
        $payments_confirmed_id = array();
        $rentals = Rental::where('rental_datein', '>=', $now)->whereIn('houses_id', $houses_id)->get();
        foreach ($rentals as $key => $rental) {
            array_push($payments_confirmed_id, $rental->payment_id);
        }
        
        /*rental with payment approve status*/
        $payments = Payment::whereIn('id', $payments_confirmed_id)->where('payment_status', 'Approved')->get();
        $payments_approved_id = array();
        foreach ($payments as $key => $payment) {
            array_push($payments_approved_id, $payment->id);
        }
        $rentals_approved = Rental::whereIn('payment_id', $payments_approved_id)->get();
        $payment_approved_badge = Payment::whereIn('id', $payments_confirmed_id)->where('payment_status', 'Approved')->count();
        
        /*rental with waiting status*/
        $payments = Payment::whereIn('id', $payments_confirmed_id)->where('payment_status', 'Waiting')->get();
        $payments_waiting_id = array();
        foreach ($payments as $key => $payment) {
            array_push($payments_waiting_id, $payment->id);
        }
        $rentals_waiting = Rental::whereIn('payment_id', $payments_waiting_id)->get();
        $payment_waiting_badge = Rental::whereIn('payment_id', $payments_waiting_id)->count();

        if (!is_null($houses)) {
            $rentals = Rental::whereIn('houses_id', $houses_id)->get();
            $rental_new = Rental::whereIn('houses_id', $houses_id)->where(function ($query) {
                $query->where('host_decision', null)->where('rental_checkroom', '!=', '1');
            })->count();
            $rent_count = array();
            foreach ($houses as $key => $house) {
                $rent_count_get = Rental::where('houses_id', $house->id)->where('host_decision', null)->count();
                array_push($rent_count, $rent_count_get);
            }

            $data = array(
                'rental_new' => $rental_new,
                'payment_waiting_badge' => $payment_waiting_badge,
                'payment_approved_badge' => $payment_approved_badge,
                'rent_count' => $rent_count
            );
            return view('rentals.rentmyrooms')->with($data)->with('rentals', $rentals)->with('houses', $houses)->with('rentals_approved', $rentals_approved)->with('rentals_waiting', $rentals_waiting);
        }

        else{
            $rentals = Rental::where('id', '0')->get();
            $data = array(
                'rental_new' => 0,
                'payment_waiting_badge' => 0,
                'payment_approved_badge' => 0
            );
            return view('rentals.rentmyrooms')->with($data)->with('rentals', $rentals)->with('houses', $houses)->with('arriverentals', $arriverentals)->with('waiting_payment', $waiting_payment);
        }
    }

    public function renthistories()
    {
        $now = Carbon::now();
        $houses = House::where('user_id', Auth::user()->id)->get();
        $houses_id = array();
        foreach ($houses as $key => $house) {
            array_push($houses_id, $house->id);
        }

        if (!is_null($houses)) {
            foreach ($houses as $house) {
                $rentals_approved = Rental::where('rental_datein', '<', $now)->whereIn('houses_id', $houses_id)->orderBy('id', 'desc')->where('checkin_status', '1')->get();
                $rentals = Rental::where('rental_datein', '<', $now)->whereIn('houses_id', $houses_id)->orderBy('id', 'desc')->get();
            }
        }

        else{
            $rentals_approved = Rental::where('id', '0')->get();
            $rentals = Rental::where('id', '0')->get();
        }
        return view('rentals.rhistories')->with('rentals', $rentals)->with('rentals_approved', $rentals_approved)->with('houses', $houses);
    }

    public function checkcode(Request $request) {
        $this->validate($request, array(
            'rent_id' => 'required',
            'checkin_code' => 'required',
        ));
        $user_id = Auth::user()->id;
        $rent_id = $request->rent_id;
        $checkin_code = $request->checkin_code;
        $rental = Rental::find($rent_id);

        if (!is_null($rental)) {
            if (Auth::user()->id == $rental->houses->user_id){
                if ($checkin_code == $rental->checkincode) {
                    $rental->checkin_status = '1';
                    $rental->save();
                    $datetime1 = new DateTime($rental->rental_datein);
                    $datetime2 = new DateTime($rental->rental_dateout);
                    $interval = $datetime1->diff($datetime2);
                    $years = $interval->format('%y');
                    $months = $interval->format('%m');
                    $days = $interval->format('%d');
                    $days = $days + 1;
                    for ($i=0; $i <= $days; $i++) {
                        $diary = new Diary;
                        $diary->publish = '0';
                        if ($i == 0) {
                            $diary->title = 'Diary Title';
                            $diary->message = "Short story of this trip.";
                        }
                        if ($i != 0) {
                            $diary->message = 'Story about day '. $i;
                        }
                        $diary->days = $i;
                        $diary->user_id = $rental->user_id;
                        $diary->category_id = '1';
                        $diary->rental_id = $rental->id;
                        $diary->save();
                    }
                    $subscribe = Subscribe::where('writer', $diary->user_id)->where('follower', Auth::user()->id)->first();
                    if (is_null($subscribe)) {
                        $subscribe = new Subscribe;
                    }
                    $subscribe->writer = $diary->user_id;
                    $subscribe->follower = Auth::user()->id;
                    $subscribe->save();

                    $subscribe = Subscribe::where('writer', $diary->user_id)->where('follower', $diary->user_id)->first();
                    if (is_null($subscribe)) {
                        $subscribe = new Subscribe;
                    }
                    $subscribe->writer = $diary->user_id;
                    $subscribe->follower = $diary->user_id;
                    $subscribe->save();

                    return redirect()->route('rentals.show', $rental->id)->with('rental', $rental);
                }
                else {
                    Session::flash('fail', "Code invalid");
                    return back();
                }
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        else {
            $error_m = $checkin_code . "Invalid code.";
            return view('pages._error')->with('error_m', $error_m);
        }
    }
}
