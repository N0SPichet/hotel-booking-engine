<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\House;
use App\Models\Map;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RentalController extends Controller
{
	use GlobalFunctionTraits;

    public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
    {
        $rentals = Rental::where('rental_datein', '>=', Carbon::today())->orderBy('updated_at', 'asc')->paginate(10);
        return view('admin.rentals.index')->with('rentals', $rentals);
    }

    public function show($rentalId)
    {
        $rental = Rental::find($rentalId);
        if (!is_null($rental)) {
            $types_id = $this->getTypeId('apartment');
            $house = House::where('id', $rental->house_id)->whereIn('housetype_id', $types_id)->first();
            $total_price = 0;
            $fee = 0;
            $discount = 0;
            if (!is_null($house)) {
                $days = Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout));
                $type_single_price = $rental->type_single_price*$rental->no_type_single*$days;
                $type_deluxe_single_price = $rental->type_deluxe_single_price*$rental->no_type_deluxe_single*$days;
                $type_double_room_price = $rental->type_double_room_price*$rental->no_type_double_room*$days;
                $total_price = floor($type_single_price + $type_deluxe_single_price + $type_double_room_price);
                $discount = floor($total_price*(0.01 * $rental->discount));
                $fee = floor($total_price*0.1);
                $total_price = $total_price + $fee - $discount;
                $review = Review::where('user_id', $rental->user_id)->where('rental_id', $rental->id)->first();
                $map = Map::where('houses_id', $rental->house_id)->first();
                $data = array(
                    'type_single_price' => $type_single_price,
                    'type_deluxe_single_price' => $type_deluxe_single_price,
                    'type_double_room_price' => $type_double_room_price,
                    'total_price' => $total_price,
                    'discount' => $discount,
                    'fee' => $fee,
                    'types' => 'apartment'
                );
                return view('admin.rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
            }
            else {
                $types_id = $this->getTypeId('room');
                $house = House::where('id', $rental->house_id)->whereIn('housetype_id', $types_id)->first();
                if (!is_null($house)) {
                    $days = Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout));
                    $room_price = 0;
                    $food_price = 0;
                    $guest = 1;
                    $guest_food = 1;
                    if ($house->houseprices->type_price == '1') {
                        $guest = $rental->rental_guest;
                        $guest_food = $rental->rental_guest;
                    }
                    if ($days < 7) {
                        $room_price = $rental->room_price*$guest*$days;
                        if ($rental->select_food == '1') {
                            $food_price = $rental->house->houseprices->food_price*$guest_food*$days;
                        }
                        $total_price = floor(($room_price + $food_price));
                        if (!$rental->house->checkType($rental->house_id)) {
                            $total_price *= $rental->no_rooms;
                        }
                        $fee = floor($total_price*0.1);
                        $total_price = $total_price + $fee - $discount;
                    }
                    elseif ($days/7 >= 1 && $days < 30) {
                        $room_price = $rental->room_price*$guest*$days;
                        if ($rental->select_food == '1') {
                            $food_price = $rental->house->houseprices->food_price*$guest_food*$days;
                        }
                        $total_price = floor($room_price + $food_price);
                        if (!$rental->house->checkType($rental->house_id)) {
                            $total_price *= $rental->no_rooms;
                        }
                        $discount = floor($total_price*(0.01 * $rental->house->houseprices->weekly_discount));
                        $fee = floor($total_price*0.1);
                        $total_price = $total_price + $fee - $discount;
                    }
                    else {
                        $room_price = $rental->room_price*$guest*$days;
                        if ($rental->select_food == '1') {
                            $food_price = $rental->house->houseprices->food_price*$guest_food*$days;
                        }
                        $total_price = floor($room_price + $food_price);
                        if (!$rental->house->checkType($rental->house_id)) {
                            $total_price *= $rental->no_rooms;
                        }
                        $discount = floor($total_price*(0.01 * $rental->house->houseprices->monthly_discount));
                        $fee = floor($total_price*0.1);
                        $total_price = $total_price + $fee - $discount;
                    }
                    $review = Review::where('user_id', $rental->user_id)->where('rental_id', $rental->id)->first();
                    $map = Map::where('houses_id', $rental->house_id)->first();
                    $data = array(
                        'food_price' => $food_price,
                        'room_price' => $room_price,
                        'total_price' => $total_price,
                        'discount' => $discount,
                        'fee' => $fee,
                        'types' => 'room'
                    );
                    return view('admin.rentals.show')->with('rental', $rental)->with($data)->with('review', $review)->with('map', $map);
                }
            }
        }
        else {
            Session::flash('fail', 'This rental is no longer available.');
            return back();
        }
    }

    public function rental_approve($rentalId)
    {
        $rental = Rental::find($rentalId);
        $payment = Payment::find($rental->payment_id);

        if ($payment->payment_status == 'Waiting') {
            $code = Hash::make($rental->id.$rental->user->email.$rental->house_id);
            $code = str_replace(' ', '-', $code);
            $code = preg_replace('/[^A-Za-z0-9\-]/', '', $code);
            $rental->checkincode = substr($code, 2, 10);
            $payment->payment_status = "Approved";
            $rental->save();
            $payment->save();

            $premessage = "Dear " . $rental->user->user_fname;
            $detailmessage = $rental->user->user_fname . " request to booking room " . $rental->house->house_title . " at " . $rental->house->district->name . ", " . $rental->house->province->name . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been approved!";
            $endmessage = "Thank you and have a great trip!";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - Result of Bill Payment (Success)",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage,
                'rental' => $rental
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
        return redirect()->route('admin.rentals.index');
    }

    public function rental_reject($rentalId)
    {
        $rental = Rental::find($rentalId);
        $payment = Payment::find($rental->payment_id);

        if ($payment->payment_status != 'Approved' && $payment->payment_status != 'Reject' && $payment->payment_status != 'Cancel') {
            $payment->payment_status = "Reject";
            if (!$rental->house->checkType($rental->house_id)) {
                $house = House::find($rental->house_id);
                $house->no_rooms = $house->no_rooms + $rental->no_rooms;
                $house->save();
            }
            $rental->checkin_status = '2';

            $premessage = "Dear " . $rental->user->user_fname;
            $detailmessage = $rental->user->user_fname . " request to booking room " . $rental->house->house_title . " at " . $rental->house->district->name . ", " . $rental->house->province->name . " Stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout)) . " you payment has been rejected!";
            $endmessage = "Please try to send your payment transfer slip again and we will check for you.";

            $data = array(
                'email' => $rental->user->email,
                'subject' => "LTT - Result of Bill Payment (Reject)",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage,
                'rental' => $rental
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
        return redirect()->route('admin.rentals.index');
    }
}
