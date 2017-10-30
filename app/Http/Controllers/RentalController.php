<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Rental;
use App\Payment;
use App\House;
use App\Himage;
use Image;
use Session;

class RentalController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
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
        //
        return view('rentals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the data
        $this->validate($request, array(
            'id' => 'required',
            'datein' => 'required',
            'dateout' => 'required',
            'guest' => 'required',
        ));
        //store in the database
        $payment = new Payment;

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

        $paymentid = Payment::orderby('created_at', 'desc')->first();

        $rental = new Rental;

        $rental->payments_id = $paymentid->id;
        $rental->users_id = Auth::user()->id;
        $rental->houses_id = $request->id;
        $rental->rental_datein = $request->datein;
        $rental->rental_dateout = $request->dateout;
        $rental->rental_guest = $request->guest;

        $rental->save();

        Session::flash('success', 'This booking was succussfully save!');

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
        //
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
        //
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

    public function rentals_agreement(Request $request){
        //validate the data
        $this->validate($request, array(
            'datein' => 'required',
            'dateout' => 'required',
            'guest' => 'required'
        ));
        
        $rentals = new Rental;

        $id = $request->id;
        $datein = $request->datein;
        $dateout = $request->dateout;
        $guest = $request->guest;

        $data = array(  'id' => $id,
                        'datein' => $datein,
                        'dateout' => $dateout,
                        'guest' => $guest);
        if (Auth::check()){
            return view('rentals.agreement')->with($data);
        }
        else{
            return redirect()->route('login');
        }
        
    }

    public function payment(Request $request){
        if ($request->agreement == 'not agree') {
            return redirect()->route('home');
        }
        //validate the data
        $this->validate($request, array(
            'datein' => 'required',
            'dateout' => 'required',
            'guest' => 'required'
        ));
        $rentals = new Rental;

        $id = $request->id;
        $guest = $request->guest;

        $houses = House::where('id', $id)->get();
        foreach ($houses as $house) {
            $house_title = $house->house_title;
            $house_price = $house->house_price;
        }

        $datein = $request->datein;
        $dateout = $request->dateout;
       
        $din_m = date('m', strtotime($request->datein));
        $dout_m = date('m', strtotime($request->dateout));

        $din_d = date('j', strtotime($request->datein));
        $dout_d = date('j', strtotime($request->dateout));
        
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

        $stay_price = $house_price * $diff;

        $total_price = ($stay_price/100)*7 + $stay_price;

        $data = array(  'id' => $id,
                        'house_title' => $house_title,
                        'house_price' => $house_price,
                        'stay_price' => $stay_price,
                        'total_price' => $total_price,
                        'datein' => $datein,
                        'dateout' => $dateout,
                        'diff' => $diff,
                        'guest' => $guest);
        
        return view('rentals.payment')->with($data);
    }

    public function rapproved($id){
        $rental = Rental::find($id);

        $idpayment = $rental->payments_id;
        $payments = Payment::where('id', $idpayment)->first();

        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $rental->checkincode = $randomString;
        $payments->payment_status = "Approved";

        $rental->save();
        $payments->save();

        Session::flash('success', 'This trip has been approved.');

        return redirect()->route('rentals.index');
    }

    public function rcancel($id){
        $rental = Rental::find($id);

        $idpayment = $rental->payments_id;
        $payments = Payment::where('id', $idpayment)->first();

        $payments->payment_status = "Cancel";

        $payments->save();

        Session::flash('success', 'This trip has been canceled.');

        return redirect()->route('mytrips');
    }

    public function rejecttrip($id){
        $rental = Rental::find($id);

        $idpayment = $rental->payments_id;
        $payments = Payment::where('id', $idpayment)->first();

        $payments->payment_status = "Reject";

        $payments->save();

        Session::flash('success', 'This trip has been rejected.');

        return redirect()->route('rentals.index');
    }

    public function rmyrooms(){

        //SELECT * FROM rentals WHERE houses_id IN ('1', '11', '12')
        $houses = House::where('users_id', Auth::user()->id)->get();
        $i = 0;
        $hid[] = NULL;
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

    public function checkcode(Request $request) {
        $this->validate($request, array(
            'rent_id' => 'required',
            'checkin_code' => 'required',
        ));

        $user_id = Auth::user()->id;
        $rent_id = $request->rent_id;
        $checkin_code = $request->checkin_code;

        $rental = Rental::find($rent_id);
        //$rental = Rental::where('houses_id', $rental->houses->id)->first();

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

    public function generateRandomString() {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        $randomString;

        return view('pages._blank')->with('randomString', $randomString);
    }

}
