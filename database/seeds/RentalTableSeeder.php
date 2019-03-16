<?php

use App\Http\Controllers\Traits\GlobalFunctionTraits;
use App\Models\House;
use App\Models\Payment;
use App\Models\Rental;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class RentalTableSeeder extends Seeder
{
    use GlobalFunctionTraits;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$today = Carbon::today();
        $types_id = $this->getTypeId('room');
        $user = User::find(3);
        $house = House::where('publish', '1')->whereIn('housetype_id', $types_id)->where('user_id', '!=', $user->id)->first();
        
    	// sample 1
    	$today = $today->addDays(3);
    	$date_in = $today->toDateString();
    	$today = $today->addDays(4);
    	$date_out = $today->toDateString();

    	$payment = new Payment;
    	$payment->payment_status = 'Cancel';
    	$payment->save();

        $rental = new Rental;
        $rental->rental_datein = $date_in;
        $rental->rental_dateout = $date_out;
        $rental->rental_guest = 1;
        $rental->no_rooms = 1;
        $rental->select_food = '1';
        $rental->discount = 0;
        $rental->rental_checkroom = 0;
        $rental->user_id = $user->id;
        $rental->house_id = $house->id;
        $rental->payment_id = $payment->id;
        $rental->save();
        $this->sentMail($rental);

    	// sample 2
    	$today = $today->subDays(3);
    	$date_in = $today->toDateString();
    	$today = $today->addDays(4);
    	$date_out = $today->toDateString();

    	$payment = new Payment;
    	$payment->payment_bankname = 'Siam Commercial Bank';
    	$payment->payment_bankaccount = '1878748343';
    	$payment->payment_holder = 'User two';
    	$payment->payment_transfer_slip = '15511997713.jpg';
    	$payment->payment_status = 'Waiting';
    	$payment->payment_amount = '5280';
    	$payment->save();

        $rental = new Rental;
        $rental->host_decision = 'accept';
        $rental->rental_datein = $date_in;
        $rental->rental_dateout = $date_out;
        $rental->rental_guest = 1;
        $rental->no_rooms = 1;
        $rental->select_food = '1';
        $rental->discount = 0;
        $rental->rental_checkroom = 0;
        $rental->user_id = $user->id;
        $rental->house_id = $house->id;
        $rental->payment_id = $payment->id;
        $rental->save();
        $this->sentMail($rental);

        // sample 3
    	$today = $today->addDays(3);
    	$date_in = $today->toDateString();
    	$today = $today->addDays(4);
    	$date_out = $today->toDateString();

    	$payment = new Payment;
    	$payment->save();

        $rental = new Rental;
        $rental->rental_datein = $date_in;
        $rental->rental_dateout = $date_out;
        $rental->rental_guest = 1;
        $rental->no_rooms = 1;
        $rental->select_food = '1';
        $rental->discount = 0;
        $rental->rental_checkroom = 0;
        $rental->user_id = $user->id;
        $rental->house_id = $house->id;
        $rental->payment_id = $payment->id;
        $rental->save();
        $this->sentMail($rental);

        // sample 4
    	$today = $today->addDays(3);
    	$date_in = $today->toDateString();
    	$today = $today->addDays(4);
    	$date_out = $today->toDateString();

    	$payment = new Payment;
    	$payment->payment_bankname = 'Krungsri';
    	$payment->payment_bankaccount = '1878743454';
    	$payment->payment_holder = 'User two';
    	$payment->payment_transfer_slip = '15512019723.jpg';
    	$payment->payment_status = 'Approved';
    	$payment->payment_amount = '5280';
    	$payment->save();

        $rental = new Rental;
        $rental->host_decision = 'accept';
        $rental->rental_datein = $date_in;
        $rental->rental_dateout = $date_out;
        $rental->rental_guest = 1;
        $rental->no_rooms = 1;
        $rental->select_food = '1';
        $rental->discount = 0;
        $code = Hash::make($user->id.$user->email.$house->id);
        $code = str_replace(' ', '-', $code);
        $code = preg_replace('/[^A-Za-z0-9\-]/', '', $code);
        $rental->checkincode = substr($code, 2, 10);
        $rental->rental_checkroom = 0;
        $rental->user_id = $user->id;
        $rental->house_id = $house->id;
        $rental->payment_id = $payment->id;
        $rental->save();
        $this->sentMail($rental);
    }

    public function sentMail($rental)
    {
        $message = null;
        $endmessage = "Please check Rentals page to accept this request";

        $data = array(
            'email' => $rental->house->user->email,
            'subject' => "LTT - You have new customer for rental #".$rental->id,
            'bodyMessage' => $message,
            'endmessage' => $endmessage,
            'rental' => $rental
        );

        Mail::send('emails.booking_request', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });
        
        $message =  null;
        $endmessage = "Now, wait for host accept your booking and have a payment!";

        $data = array(
            'email' => $rental->user->email,
            'subject' => "LTT - Booking Confirmation for rental #".$rental->id,
            'bodyMessage' => $message,
            'endmessage' => $endmessage,
            'rental' => $rental
        );

        Mail::send('emails.booking_confirm', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });
    }
}
