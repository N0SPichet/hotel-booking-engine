<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Rental;
use App\Payment;
use App\House;
use App\Houserule;
use App\Himage;
use Image;
use Mail;
use Session;

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
            'dateout' => 'required',
            'guest' => 'required'
        ));

        $id = $request->id;
        $house = House::find($id);
        $datein = $request->datein;
        $dateout = $request->dateout;
        $guest = $request->guest;
        $data = array(  'id' => $id,
                        'datein' => $datein,
                        'dateout' => $dateout,
                        'guest' => $guest);
        if (Auth::check()){
            return view('rentals.agreement')->with($data)->with('house', $house);
        }
        else{
            return redirect()->route('login');
        }
    }

    public function acceptnew($id)
    {
        $rental = Rental::find($id);
        if ($rental->payments->payment_status == NULL) {
            $rental->host_decision = 'ACCEPT';
        }
        $rental->save();
        Session::flash('success', 'Thank you for accept this request.');
        return redirect()->route('rentals.rmyrooms');
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
            'guest' => 'required',
        ));
        $payment = new Payment;
        $rental = new Rental;
        $payment->save();
        $rental->payments_id = $payment->id;
        $rental->users_id = Auth::user()->id;
        $rental->houses_id = $request->id;
        $rental->rental_datein = $request->datein;
        $rental->rental_dateout = $request->dateout;
        $rental->rental_guest = $request->guest;
        $rental->save();

        $premessage = $rental->users->user_fname . " " . $rental->users->user_lname . " request to booking your room. Please check Rentals page for accept this request";

        $data = array(
            'email' => $rental->houses->users->email,
            'subject' => "You Have New Renter",
            'hostName' => $rental->houses->users->user_fname,
            'bodyMessage' => $premessage
        );

        Mail::send('emails.booking', $data, function($message) use ($data){
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
        $rental = Rental::find($id);
        return view('rentals.show')->with('rental', $rental);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rental = Rental::find($id);
        $payment = Payment::where('id', $rental->payments->payments_id)->first();
        $din_m = date('m', strtotime($rental->rental_datein));
        $dout_m = date('m', strtotime($rental->rental_dateout));
        $din_d = date('j', strtotime($rental->rental_datein));
        $dout_d = date('j', strtotime($rental->rental_dateout));
        $diff_m = $dout_m - $din_m;
        $diff_d = $dout_d - $din_d;

        if ($diff_m == 0){
            $diff = $diff_d;
        }
        else{
            if ($din_m == 1||$din_m == 3||$din_m == 5||$din_m == 7||$din_m == 8||$din_m == 10||$din_m == 12){
                $number = 31;
            }
            else if ($din_m == 4||$din_m == 6||$din_m == 9||$din_m == 11){
                $number = 30;
            }
            else if ($din_m == 2){
                $number = 28;
            }
            $temp_m = $diff_m * $number;
            $diff = $temp_m + $diff_d;
        }

        if (($diff%7 ==0) || $diff/7 >= 1) {
            $stay_price = ($rental->houses->houseprices->price * $diff)*0.94;
        }
        else {
            $stay_price = $rental->houses->houseprices->price * $diff;
        }

        $total_price = ($stay_price/100)*7 + $stay_price;

        $data = array(  'id' => $id,
                        'stay_price' => $stay_price,
                        'total_price' => $total_price,
                        'datein' => $rental->rental_datein,
                        'dateout' => $rental->rental_dateout,
                        'diff' => $diff,
                        'guest' => $rental->rental_guest);
        
        return view('rentals.payment')->with($data)->with('rental', $rental)->with('payment', $payment);
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
        $payment = Payment::find($id);
        $payment->payment_bankname = $request->banks_id;
        $payment->payment_bankaccount = $request->payment_bankaccount;
        $payment->payment_holder = $request->payment_holder;
        $payment->payment_status = $request->payment_status;
        if ($request->hasFile('payment_transfer_slip')) {
            $image = $request->file('payment_transfer_slip');
            $filename = time() . Auth::user()->id . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/payments/'.$filename);
            Image::make($image)->resize(640, 1062)->save($location);
            $payment->payment_transfer_slip = $filename;
        }
        $payment->save();
        return redirect()->route('mytrips');
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

        $idpayment = $rental->payments_id;
        $payment = Payment::where('id', $idpayment)->first();

        if ($payment->payment_status == 'Waiting') {

            $rental->checkincode = str_random(10);
            $payment->payment_status = "Approved";
            $rental->save();
            $payment->save();

            Session::flash('success', 'This trip has been approved.');
        }
        else if ($payment->payment_status == 'Approved') {
            Session::flash('fail', 'Cannot Approve - This trip is already approved.');
        }
        else if ($payment->payment_status == 'Reject') {
            Session::flash('fail', 'Cannot Approve - This trip is already reject.');
        }
        else if ($payment->payment_status == 'Cancel') {
            Session::flash('fail', 'Cannot Approve - This trip is already cancel.');
        }

        return redirect()->route('rentals.index');
    }

    public function rcancel($id){
        $rental = Rental::find($id);

        $idpayment = $rental->payments_id;
        $payment = Payment::where('id', $idpayment)->first();

        if ($payment->payment_status == 'Waiting') {

            $payment->payment_status = "Cancel";
            $payment->save();
            Session::flash('success', 'This trip has been canceled.');
        }
        else if ($payment->payment_status == 'Approved') {
            Session::flash('fail', 'Cannot Cancel - This trip is already approved.');
        }
        else if ($payment->payment_status == 'Reject') {
            Session::flash('fail', 'Cannot Cancel - This trip is already reject.');
        }
        else if ($payment->payment_status == 'Cancel') {
            Session::flash('fail', 'Cannot Cancel - This trip is already cancel.');
        }

        return redirect()->route('mytrips');
    }

    public function rejecttrip($id){
        $rental = Rental::find($id);

        $idpayment = $rental->payments_id;
        $payment = Payment::where('id', $idpayment)->first();
        if ($payment->payment_status == 'Waiting') {
            $payment->payment_status = "Reject";

            $payment->save();

            Session::flash('success', 'This trip has been rejected.');
        }
        else if ($payment->payment_status == 'Approved') {
            Session::flash('fail', 'Cannot Reject - This trip is already approved.');
        }
        else if ($payment->payment_status == 'Reject') {
            Session::flash('fail', 'Cannot Reject - This trip is already reject.');
        }
        else if ($payment->payment_status == 'Cancel') {
            Session::flash('fail', 'Cannot Reject - This trip is already cancel.');
        }

        return redirect()->route('rentals.index');
    }

    public function rmyrooms()
    {
        //SELECT * FROM rentals WHERE houses_id IN ('1', '11', '12')
        $houses = House::where('users_id', Auth::user()->id)->get();
        $i = 0;
        $hid = array();
        foreach ($houses as $house) {
            $hid[$i] = $house->id;
            $i++;
        }

        if (count($houses) != '0') {
            foreach ($houses as $house) {
                $rentals = Rental::whereIn('houses_id', $hid)->get();
            }
            return view('rentals.rmyrooms')->with('rentals', $rentals)->with('houses', $houses);
        }

        else{
            $rentals = Rental::where('id', '0')->get();
            return view('rentals.rmyrooms')->with('rentals', $rentals)->with('houses', $houses);
        }
        
    }

    public function rhistories()
    {
        $houses = House::where('users_id', Auth::user()->id)->get();
        $i = 0;
        $hid = array();
        foreach ($houses as $house) {
            $hid[$i] = $house->id;
            $i++;
        }

        if (count($houses) != '0') {
            foreach ($houses as $house) {
                $rentals = Rental::whereIn('houses_id', $hid)->get();
            }
        }

        else{
            $rentals = Rental::where('id', '0')->get();
        }

        return view('rentals.rhistories')->with('rentals', $rentals)->with('houses', $houses);
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

        if ($rental != NULL) {
            if ($user_id == $rental->houses->users_id){
                if ($checkin_code == $rental->checkincode) {
                    $rental->checkin_status = '1';
                }

                $rental->save();
                return redirect()->route('rentals.show', $rental->id)->with('rental', $rental);
            }
        }
        else{
            $error_m = $checkin_code;
            return view('pages._error')->with('error_m', $error_m);
        }
    }

}
