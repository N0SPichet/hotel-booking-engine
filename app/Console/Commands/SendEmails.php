<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;
use DateTime;
use App\Rental;
use Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:notic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email to notic user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // \Log::info('I was here @' . Carbon::now());
        $now = Carbon::now('Asia/bangkok');
        $now->subDay();
        $rentals = Rental::where('rental_datein', '>', $now)->where( function ($query) {
            $query->where('host_decision', 'ACCEPT')->where('checkin_status', '0');
        })->get();
        $now->addDay();
        foreach ($rentals as $key => $rental) {
            $datetime = new DateTime($rental->rental_datein);
            $year = $datetime->format('20y');
            $month = $datetime->format('m');
            $day = $datetime->format('d');
            $dt = Carbon::create($year, $month, $day);
            $com_date = $dt->diffInDays($now);
            if ($com_date == '0' || $com_date == '1' || $com_date == '2' || $com_date == '3' || $com_date == '7' || $com_date == '30') {
                if ($com_date == '0') {
                    $when = 'To day';
                }
                if ($com_date == '1') {
                    $when = 'Tomorrow';
                }
                if ($com_date == '2') {
                    $when = 'next 2 Days';
                }
                if ($com_date == '3') {
                    $when = 'next 3 Days';
                }
                if ($com_date == '7') {
                    $when = 'Next Week';
                }
                if ($com_date == '30') {
                    $when = 'Next Month';
                }

                $premessage = "Dear " . $rental->users->user_fname;
                $detailmessage = "Rental No. " . $rental->id . " " . $when . " " . " You have a trip stay date " . date('jS F, Y', strtotime($rental->rental_datein)) . " to " . date('jS F, Y', strtotime($rental->rental_dateout));
                $endmessage = "be prepare your backpack for this great trip!";

                $data = array(
                    'email' => $rental->users->email,
                    'subject' => "LTT - You have a trip",
                    'bodyMessage' => $premessage,
                    'detailmessage' => $detailmessage,
                    'endmessage' => $endmessage,
                    'rentlUserId' => $rental->user_id
                );

                Mail::send('emails.notic_email', $data, function($message) use ($data){
                    $message->from('noreply@ltt.com');
                    $message->to($data['email']);
                    $message->subject($data['subject']);
                });
            }
        }
    }
}
