<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Mail;
use Session;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('helps.index');
    }

    public function checkincode() 
    {
        $randomString = str_random(10);
        return view('helps.checkin')->with('randomString', $randomString);
    }

    public function getContact()
    {
        return view('helps.contact');
    }

    public function postContact(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10'
        ]);

        $data = array(
            'email' => $request->email,
            'subject' => 'LTT - You have new contact via contact form',
            'bodyMessage' => $request->subject,
            'detailmessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('pichetfuengfoo@gmail.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was sent');
        return view('helps.contact');
    }

    public function getContactHost($id)
    {
        $house = House::where('users_id', $id)->first();
        return view('helps.contacthost')->with('house', $house);
    }

    public function postContactHost(Request $request)
    {
        $this->validate($request, [
            'hostname' => 'required',
            'receiveremail' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'guest' => 'required',
            'message' => 'required|min:10'
        ]);

        $data = array(
            'premessage' =>  "Dear " . $request->hostname,
            'receiveremail' => $request->receiveremail,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'guest' => $request->guest,
            'subject' => 'LTT - You have new contact via contact host',
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contacthost', $data, function($message) use ($data){
            $message->from('noreply@ltt.com');
            $message->to($data['receiveremail']);
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was sent');
        return redirect()->route('rooms.show', $request->id);
    }

    public function getmaps ()
    {
        return view('helps.getmaps');
    }
}
