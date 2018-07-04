<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Diary;
use App\Map;
use App\Rental;
use App\Payment;
use App\House;
use App\Houserule;
use App\Himage;
use App\Review;
use Image;
use Mail;
use Session;
use Carbon\Carbon;
use DateTime;

class RentalController extends Controller
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
        $rentals = Rental::orderBy('created_at', 'desc')->paginate(10);
        return view('rentals.index')->with('rentals', $rentals);
    }

    public function mytrip()
    {
        if (Auth::check()) {
            $rentals = Rental::where('users_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(5);
            $review_id = Review::where('user_id', Auth::user()->id)->get();
            $re_id = array();
            foreach ($review_id as $key => $review) {
                $re_id[$key] = $review->rental_id;
            }
            $rental_id = Rental::whereNotIn('id', $re_id)->where(function ($query) {
                $query->where('users_id', Auth::user()->id)->where('checkin_status', '1');
            })->get();
            $review_count = 0;
            foreach ($rental_id as $key => $rental) {
                $review_count = $key+1;
            }
            $data = array(
                'review_count' => $review_count
            );
            return view('rentals.mytrip')->with('rentals', $rentals)->with($data);
        }
        else {
            Session::flash('success', 'You need to login first!');
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
        return view('rentals.create');
    }

    public function rentals_agreement(Request $request)
    {
        $this->validate($request, array(
            'datein' => 'required',
            'dateout' => 'required'
        ));

        $datein = $request->datein;
        $dateout = $request->dateout;
        $house = House::find($request->id);
        if ($dateout > $datein) {
            // nstart>start && nstart>=stop ok
            // nstart<start && nstop<=start ok
            if ($house->housetypes_id == '1' || $house->housetypes_id == '5') {
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
                    'housetypes_id' => $house->housetypes_id,
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
            else {
                $food = $request->food;
                $guest = $request->guest;
                $room = $request->room;
                $now = Carbon::now('Asia/bangkok');
                $now->subDay();
                $rentals = Rental::where('houses_id', $house->id)->where('rental_datein', '>', $now)->where( function ($query) {
                    $query->where('host_decision', 'ACCEPT')->where('checkin_status', '0');
                })->orderBy('created_at', 'desc')->get();
                foreach ($rentals as $rental) {
                    if ($rental->payments->payment_status == 'Waiting' || $rental->payments->payment_status == 'Approved' || $rental->payments->payment_status == NULL) {
                        // echo $rental->rental_datein ." => ". $rental->rental_dateout. "<br>";
                        if ($datein > $rental->rental_datein) {
                            if ($datein >= $rental->rental_dateout && $dateout > $rental->rental_dateout) {
                                // echo " OK" . "<br><br>";
                                if ($rental->payments->payment_status == 'Waiting' || $rental->payments->payment_status == 'Approved' || $rental->payments->payment_status == NULL) {
                                    if ($rental->no_rooms != $request->room) {
                                    
                                    }
                                    else {
                                        Session::flash('fail', 'We have a customer in this day. Please choose other day!A' . $rental->id);
                                        return back();
                                    }
                                }
                            }
                            else {
                                // echo " FAIL" . "<br><br>";
                                Session::flash('fail', 'We have a customer in this day. Please choose other day!B' . $rental->id);
                                return back();
                            }
                        }
                        elseif ($datein == $rental->rental_datein) {
                            // echo " FAIL" . "<br><br>";
                            if ($rental->payments->payment_status == 'Waiting' || $rental->payments->payment_status == 'Approved' || $rental->payments->payment_status == NULL) {
                                if ($rental->no_rooms != $request->room) {
                                    
                                }
                                else {
                                    Session::flash('fail', 'We have a customer in this day. Please choose other room number!C' . $rental->id);
                                    return back();
                                }
                            }
                            else {
                                Session::flash('fail', 'We have a customer in this day. Please choose other day!D' . $rental->id);
                                return back();
                            }
                        }
                        elseif ($datein < $rental->rental_datein) {
                            if ($dateout <= $rental->rental_datein) {
                                // echo " OK" . "<br><br>";
                                if ($rental->payments->payment_status == 'Waiting' || $rental->payments->payment_status == 'Approved' || $rental->payments->payment_status == NULL) {
                                    if ($rental->no_rooms != $request->room) {

                                    }
                                    else {

                                    }
                                }
                            }
                            elseif ($dateout > $rental->rental_datein) {
                                // echo " FAIL" . "<br><br>";
                                Session::flash('fail', 'We have a customer in this day. Please choose other day!F' . $rental->id);
                                return back();
                            }
                        }
                    }
                }
                $data = array(
                    'id' => $house->id,
                    'housetypes_id' => $house->housetypes_id,
                    'datein' => $datein,
                    'dateout' => $dateout,
                    'guest' => $guest,
                    'food' => $food,
                    'no_rooms' => $room
                );
                return view('rentals.agreement')->with($data)->with('house', $house);
            }
        }
        else {
            Session::flash('fail', 'Invalid date format, date in should come before date out!');
            return back();
        }
    }

    public function acceptnew($id)
    {
        $rental = Rental::find($id);
        if ($rental->payments->payment_status == NULL && $rental->payments->payment_status != 'Cancel' && $rental->payments->payment_status != 'Out of Date') {
            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
                $rental->host_decision = 'ACCEPT';
            }
            else {
                $rental->host_decision = 'ACCEPT';
            }

            $premessage = "Dear " . $rental->users->user_fname;
            $detailmessage = "Your host was accepted your booking " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout));
            $endmessage = "Next please have a payment to complete booking!";

            $data = array(
                'email' => $rental->users->email,
                'subject' => "LTT - Booking request confirm",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage
            );

            Mail::send('emails.booking_accepted', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });

            $rental->save();
            Session::flash('success', 'Thank you for accept this request.');
            return redirect()->route('rentals.rmyrooms');
        }
        else {
            $payment = Payment::find($rental->payments->id);
            Session::flash('fail', "Cannot reject - This trip is already $payment->payment_status.");
            return back();
        }

    }

    public function rejectnew($id) 
    {
        $rental = Rental::find($id);
        if ($rental->payments->payment_status == NULL && $rental->payments->payment_status != 'Cancel' && $rental->payments->payment_status != 'Out of Date') {
            $rental->host_decision = 'REJECT';
            $rental->rental_checkroom = '1';
            $rental->save();
            Session::flash('success', 'This request was rejected.');
            return redirect()->route('rentals.rmyrooms');
        }
        else {
            $payment = Payment::find($rental->payments->id);
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
        if ($request->housetypes_id == '1' || $request->housetypes_id == '5') {
            $rental->users_id = Auth::user()->id;
            $rental->houses_id = $request->id;
            
            $rental->rental_datein = $request->datein;
            $rental->rental_dateout = $request->dateout;
            
            $rental->no_type_single = $request->no_type_single;
            $rental->type_single_price = $request->type_single_price;
            
            $rental->no_type_deluxe_single = $request->no_type_deluxe_single;
            $rental->type_deluxe_single_price = $request->type_deluxe_single_price;

            $rental->no_type_double_room = $request->no_type_double_room;
            $rental->type_double_room_price = $request->type_double_room_price;
            
            $rental->discount = $house->apartmentprices->discount;
            $rental->checkin_status = '0';
            $rental->payments_id = $payment->id;
        }
        elseif ($request->housetypes_id) {
            $rental->users_id = Auth::user()->id;
            $rental->houses_id = $request->id;
            $rental->rental_datein = $request->datein;
            $rental->rental_dateout = $request->dateout;
            $rental->rental_guest = $request->guest;
            $rental->payments_id = $payment->id;
            $rental->no_rooms = $request->no_rooms;
            $rental->inc_food = $request->food;
            $rental->checkin_status = '0';
        }
        $rental->save();

        $premessage = "Dear " . $rental->houses->users->user_fname;
        $detailmessage = $rental->users->user_fname . " " . $rental->users->user_lname . " request to booking your room. Please check Rentals page for accept this request";

        $data = array(
            'email' => $rental->houses->users->email,
            'subject' => "LTT - You have new customer",
            'bodyMessage' => $premessage,
            'detailmessage' => $detailmessage
        );

        Mail::send('emails.booking_request', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        $premessage = "Dear " . $rental->users->user_fname;
        $detailmessage = $rental->users->user_fname . " " . $rental->users->user_lname . " you was succussfully booking stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout));
        $endmessage = "Now, wait for host accept your booking and have a payment!";

        $data = array(
            'email' => $rental->users->email,
            'subject' => "LTT - Booking request confirm",
            'bodyMessage' => $premessage,
            'detailmessage' => $detailmessage,
            'guest' => $rental->rental_guest,
            'endmessage' => $endmessage
        );

        Mail::send('emails.booking_confirm', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        Session::flash('success', 'You was succussfully booking, Now wait for host accept your booking and have a payment!');

        return redirect()->route('mytrips');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::check()) {
            $rental = Rental::find($id);
            if ($rental) {
                $house = House::find($rental->houses_id);
                if ($house->housetypes_id == '1' || $house->housetypes_id == '5') {
                    if (Auth::user()->level == '0' || $rental->users->id == Auth::user()->id || $rental->houses->users->id == Auth::user()->id) {
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

                        $review = Review::where('user_id', $rental->users->id)->where('house_id', $rental->houses->id)->where('rental_id', $rental->id)->first();
                        $map = Map::where('houses_id', $rental->houses->id)->first();
                        $data = array(
                            'days' => $days,
                            'type_single_price' => $type_single_price,
                            'type_deluxe_single_price' => $type_deluxe_single_price,
                            'type_double_room_price' => $type_double_room_price,
                            'fee' => $fee,
                            'total_price' => $total_price
                        );
                        return view('rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
                    }
                    else {
                        Session::flash('fail', "Request not found, You don't have permission to see this files!");
                        return back();
                    }
                }
                else {
                    if (Auth::user()->level == '0' || $rental->users->id == Auth::user()->id || $rental->houses->users->id == Auth::user()->id) {
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
                            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
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
                            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
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
                            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
                                $total_price *= $rental->no_rooms;
                            }
                            $fee = floor($total_price*0.1);
                            $total_price = $total_price + $fee;
                        }
                        $review = Review::where('user_id', $rental->users->id)->where('house_id', $rental->houses->id)->where('rental_id', $rental->id)->first();
                        $map = Map::where('houses_id', $rental->houses->id)->first();
                        $data = array(
                            'days' => $days,
                            'total_price' => $total_price
                        );
                        return view('rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
                    }
                    else {
                        Session::flash('fail', "Request not found, You don't have permission to see this files!");
                        return back();
                    }
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
            $rental = Rental::find($id);
            if ($rental) {
                if (Auth::user()->id == $rental->users->id) {
                    $payment = Payment::find($rental->payments->id);
                    $house = House::find($rental->houses_id);
                    $datetime1 = new DateTime($rental->rental_datein);
                    $datetime2 = new DateTime($rental->rental_dateout);
                    $interval = $datetime1->diff($datetime2);
                    $years = $interval->format('%y');
                    $months = $interval->format('%m');
                    $days = $interval->format('%d');

                    if ($house->housetypes_id == '1' || $house->housetypes_id == '5') {
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
                        if ($payment->payment_status != 'Approved' && $payment->payment_status != 'Cancel' && $payment->payment_status != 'Out of Date' && $payment->payment_status != 'Reject' && $rental->host_decision == 'ACCEPT') {
                            $food_price = 0;
                            if ($days/7 >= 1 && $months < 1) {
                                $room_price = $rental->houses->houseprices->price*$rental->rental_guest*$days;
                                if ($rental->inc_food == '1') {
                                    $food_price = $rental->houses->houseprices->food_price*$rental->rental_guest*$days;
                                }
                                $total_price = floor(($room_price + $food_price) * (1-(0.01 * $rental->houses->houseprices->weekly_discount)));
                                if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
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
                                if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
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
                                if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
                                    $total_price *= $rental->no_rooms;
                                }
                                $fee = floor($total_price*0.1);
                                $total_price = $total_price + $fee;
                                $discount = 0;
                            }
                            $data = array(
                                'id' => $id,
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
                        else {
                            Session::flash('success', 'This payment already '. $payment->payment_status. '.');
                            return back();
                        }
                    }
                }
                else {
                    Session::flash('fail', 'This trip is no longer available.');
                    return back();
                }
            }
            else {
                Session::flash('fail', 'This trip is no longer available.');
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
        if (Auth::check()) {
            $payment = Payment::find($id);
            $payment->payment_bankname = $request->banks_id;
            $payment->payment_bankaccount = $request->payment_bankaccount;
            $payment->payment_holder = $request->payment_holder;
            $payment->payment_amount = $request->payment_amount;
            $payment->payment_status = $request->payment_status;
            if ($request->hasFile('payment_transfer_slip')) {
                if ($payment->payment_transfer_slip != NULL) {
                    Storage::delete('payments/'.$filename);
                }
                $image = $request->file('payment_transfer_slip');
                $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/payments/'.$filename);
                Image::make($image)->resize(640, 1062)->save($location);
                $payment->payment_transfer_slip = $filename;
            }
            $payment->save();

            $rental = Rental::where('payments_id', $payment->id)->first();
            $rental->discount = $request->discount;
            $rental->save();

            $premessage = "Dear " . $rental->users->user_fname . " " . $rental->users->user_lname . " , With reference to your request for bill payment via LTT Service as follows.";
            $detailmessage = $rental->users->user_fname . " " . $rental->users->user_lname . " has pay " . $rental->payments->payment_amount . " thai baht for booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . ".";
            $endmessage = "Now, wait for checking payment then you will completely booking and have a code for check-in.";

            $data = array(
                'email' => $rental->users->email,
                'subject' => "LTT - Payment Result for Customer",
                'cusName' => $rental->users->user_fname,
                'bodyMessage' => $premessage,
                'detailmessage' =>  $detailmessage,
                'endmessage' => $endmessage
            );

            Mail::send('emails.payment_confirm', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });

            return redirect()->route('mytrips');
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

    public function rapproved($id)
    {
        $rental = Rental::find($id);
        $payment = Payment::find($rental->payments_id);
        

        if ($payment->payment_status == 'Waiting') {
            $rental->checkincode = str_random(10);
            $payment->payment_status = "Approved";
            $rental->save();
            $payment->save();

            $premessage = "Dear " . $rental->users->user_fname;
            $detailmessage = $rental->users->user_fname . " request to booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been approved!";
            $endmessage = "Thank you and have a great trip!";

            $data = array(
                'email' => $rental->users->email,
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

            Session::flash('success', 'This trip has been approved.');
        }
        else {
            Session::flash('fail', "Cannot Approve - This trip is already $payment->payment_status");
        }
        return redirect()->route('rentals.index');
    }

    public function rcancel($id)
    {
        $rental = Rental::find($id);
        $payment = Payment::find($rental->payments_id);

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
            $rental->checkincode = NULL;
            $rental->rental_checkroom = '1';
            $rental->checkin_status = '2';
            $rental->save();
            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
                $house = House::find($rental->houses->id);
                $house->no_rooms = $house->no_rooms + $rental->no_rooms;
                $house->save();
            }
            Session::flash('success', 'This trip has been canceled.');
        }
        return redirect()->route('mytrips');
    }

    public function rejecttrip($id)
    {
        $rental = Rental::find($id);
        $payment = Payment::find($rental->payments_id);

        if ($payment->payment_status == 'Waiting') {
            $payment->payment_status = "Reject";
            if ($rental->houses->housetypes_id == '1' || $rental->houses->housetypes_id == '5') {
                $house = House::find($rental->houses->id);
                $house->no_rooms = $house->no_rooms + $rental->no_rooms;
                $house->save();
            }
            $rental->checkin_status = '2';

            $premessage = "Dear " . $rental->users->user_fname;
            $detailmessage = $rental->users->user_fname . " request to booking room " . $rental->houses->house_title . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been rejected!";
            $endmessage = "Please try to send your payment transfer slip again and we will check for you.";

            $data = array(
                'email' => $rental->users->email,
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

    public function rmyrooms()
    {
        if (Auth::check()) {
            //SELECT * FROM rentals WHERE houses_id IN ('1', '11', '12')
            $houses = House::where('users_id', Auth::user()->id)->get();
            $house_id = array();
            foreach ($houses as $key => $house) {
                $house_id[$key] = $house->id;
            }

            $now = Carbon::yesterday();
            $arrive_confirm = array();
            $arriverentals = Rental::where('rental_datein', '>=', $now)->whereIn('houses_id', $house_id)->get();
            foreach ($arriverentals as $key => $arriverental) {
                $arrive_confirm[$key] = $arriverental->payments_id;
            }

            $paymentcheck = Payment::whereIn('id', $arrive_confirm)->where('payment_status', 'Approved')->get();
            $payment_approved_badge = Payment::whereIn('id', $arrive_confirm)->where('payment_status', 'Approved')->count();
            $payment_approved = array();
            foreach ($paymentcheck as $key => $payment) {
                $payment_approved[$key] = $payment->id;
            }

            $arriverentals = Rental::whereIn('payments_id', $payment_approved)->get();

            $paymentcheck = Payment::whereIn('id', $arrive_confirm)->where('payment_status', 'Waiting')->get();
            $payment_approved = array();
            foreach ($paymentcheck as $key => $payment) {
                $payment_approved[$key] = $payment->id;
            }

            $waiting_payment = Rental::whereIn('payments_id', $payment_approved)->get();
            $payment_waiting_badge = Rental::whereIn('payments_id', $payment_approved)->count();

            if (count($houses) != '0') {
                $rentals = Rental::whereIn('houses_id', $house_id)->get();
                $rental_new = Rental::whereIn('houses_id', $house_id)->where(function ($query) {
                    $query->where('host_decision', NULL)->where('rental_checkroom', '!=', '1');
                })->count();

                $p_id = array();
                foreach ($rentals as $key => $rental) {
                    $p_id[$key] = $rental->payments_id;
                }

                $payment_waiting = Payment::whereIn('id', $p_id)->where(function ($query) {
                    $query->where('payment_status', 'Waiting');
                })->count();

                $data = array(
                    'rental_new' => $rental_new,
                    'payment_waiting' => $payment_waiting,
                    'payment_waiting_badge' => $payment_waiting_badge,
                    'payment_approved_badge' => $payment_approved_badge
                );
                return view('rentals.rmyrooms')->with($data)->with('rentals', $rentals)->with('houses', $houses)->with('arriverentals', $arriverentals)->with('waiting_payment', $waiting_payment);
            }

            else{
                $rentals = Rental::where('id', '0')->get();
                $data = array(
                    'rental_new' => 0,
                    'payment_waiting_badge' => 0,
                    'payment_approved_badge' => 0
                );
                return view('rentals.rmyrooms')->with($data)->with('rentals', $rentals)->with('houses', $houses)->with('arriverentals', $arriverentals)->with('waiting_payment', $waiting_payment);
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function rhistories()
    {
        if (Auth::check()) {
            $now = Carbon::now();
            $houses = House::where('users_id', Auth::user()->id)->get();
            $house_id = array();
            foreach ($houses as $key => $house) {
                $house_id[$key] = $house->id;
            }

            if (count($houses) != '0') {
                foreach ($houses as $house) {
                    $rentals_approved = Rental::where('rental_datein', '<', $now)->whereIn('houses_id', $house_id)->orderBy('created_at', 'desc')->where('checkin_status', '1')->get();
                    $rentals = Rental::where('rental_datein', '<', $now)->whereIn('houses_id', $house_id)->orderBy('created_at', 'desc')->get();
                }
            }

            else{
                $rentals_approved = Rental::where('id', '0')->get();
                $rentals = Rental::where('id', '0')->get();
            }
            return view('rentals.rhistories')->with('rentals', $rentals)->with('rentals_approved', $rentals_approved)->with('houses', $houses);
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function checkcode(Request $request) {
        $this->validate($request, array(
            'rent_id' => 'required',
            'checkin_code' => 'required',
        ));
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $rent_id = $request->rent_id;
            $checkin_code = $request->checkin_code;

            $rental = Rental::find($rent_id);

            if ($rental != NULL) {
                if ($user_id == $rental->houses->users_id){
                    if ($checkin_code == $rental->checkincode) {
                        $rental->checkin_status = '1';
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
                            }
                            if ($i != 0) {
                                $diary->message = 'Story about day '. $i;
                            }
                            $diary->days = $i;
                            $diary->users_id = $rental->users->id;
                            $diary->categories_id = '1';
                            $diary->rentals_id = $rental->id;
                            $diary->save();
                        }
                        $rental->save();
                        return redirect()->route('rentals.show', $rental->id)->with('rental', $rental);
                    }
                    else
                    {
                        Session::flash('fail', "Code invalid");
                        return back();
                    }
                }
                else {
                    Session::flash('fail', 'Request not found please try other rooms!');
                    return back();
                }
            }
            else{
                $error_m = $checkin_code . "Invalid code.";
                return view('pages._error')->with('error_m', $error_m);
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function not_reviews()
    {
        if (Auth::check()) {
            $review_id = Review::where('user_id', Auth::user()->id)->get();
            $re_id = array();
            foreach ($review_id as $key => $review) {
                $re_id[$key] = $review->rental_id;
            }
            $rentals = Rental::whereNotIn('id', $re_id)->where(function ($query) {
                $query->where('users_id', Auth::user()->id)->where('checkin_status', '1');
            })->paginate(5);
            $review_count = 0;
            foreach ($rentals as $key => $rental) {
                $review_count = $key+1;
            }
            $data = array(
                'review_count' => $review_count
            );
            return view('rentals.mytrip')->with('rentals', $rentals)->with($data);
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

}
