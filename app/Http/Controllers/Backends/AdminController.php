<?php

namespace App\Http\Controllers\Backends;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin', ['only' => 'index']);
	}
    
    public function index()
    {
        $payments = Payment::where('payment_status',  'Waiting')->get();
        $payments_id = array();
        foreach ($payments as $key => $payment) {
            array_push($payments_id, $payment->id);
        }
        $rentals = Rental::whereIn('payment_id', $payments_id)->count();
        
        return view('admin.dashboard')->with('rentals', $rentals);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.auth.register');
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, [
            'name'          => 'required',
            'email'         => 'required',
            'password'      => 'required'
        ]);

        // store in the database
        $admins = new Admin;
        $admins->name = $request->name;
        $admins->email = $request->email;
        $admins->password=bcrypt($request->password);
        $admins->save();
        return redirect()->route('admin.auth.login');
    }
}
