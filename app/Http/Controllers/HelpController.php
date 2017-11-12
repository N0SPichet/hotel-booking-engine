<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\House;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'subject' => $request->subject,
            'bodyMessage' => $request->message
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
            'receiveremail' => 'required',
            'senderemail' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10'
        ]);

        $data = array(
            'receiveremail' => $request->receiveremail,
            'senderemail' => $request->senderemail,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contacthost', $data, function($message) use ($data){
            $message->from($data['senderemail']);
            $message->to($data['receiveremail']);
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was sent');
        return redirect()->route('rooms.show', $request->id);
    }
}
