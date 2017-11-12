<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Houseamenity;
use Session;

class HouseamenityController extends Controller
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
        $houseamenities = Houseamenity::all();

        return view('houseamenities.index')->with('houseamenities', $houseamenities);
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
        $this->validate($request, array(
            'amenityname' => 'required'
        ));
        $houseamenity = new Houseamenity;
        $houseamenity->amenityname = $request->amenityname;
        $houseamenity->save();

        Session::flash('success', 'New Amenity was successfully created');

        return redirect()->route('houseamenities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $houseamenity = Houseamenity::find($id);
        return view('houseamenities.show')->with('houseamenity', $houseamenity);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $houseamenity = Houseamenity::find($id);
        return view('houseamenities.edit')->with('houseamenity', $houseamenity);
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
        $houseamenity = Houseamenity::find($id);

        $this->validate($request, array(
            'amenityname' => 'required'
        ));
        $houseamenity->amenityname = $request->amenityname;
        $houseamenity->save();
        Session::flash('success', 'This amenity was successfully updated.');
        return redirect()->route('houseamenities.show', $houseamenity->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $amenity = Houseamenity::find($id);
        $amenity->houses()->detach();
        $amenity->delete();
        Session::flash('success', 'The amenity was successfully deleted');
        return redirect()->route('amenities.index');
    }
}
