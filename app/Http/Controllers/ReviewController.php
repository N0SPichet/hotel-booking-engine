<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Review;
use App\House;
use Session;
use Purifier;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'house_id' => 'required',
            'rental_id' => 'required',
            'clean' => 'required|min:1|max:5',
            'amenity' => 'required|min:1|max:5',
            'service' => 'required|min:1|max:5',
            'host' => 'required|min:1|max:5',
            'comment' => 'required|min:5|max:2000'
        ));
        if (Auth::check()) {
            $review = new Review;
            $review->clean = $request->clean;
            $review->amenity = $request->amenity;
            $review->service = $request->service;
            $review->host = $request->host;
            $review->comment = Purifier::clean($request->comment);
            $review->user_id = Auth::user()->id;
            $review->house_id = $request->house_id;
            $review->rental_id = $request->rental_id;
            $review->save();

            Session::flash('success', 'Review was added');
            return redirect()->route('rentals.show', [$review->rental_id]);
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
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
        if (Auth::check()) {
            $review = Review::find($id);
            if ($review) {
                if ($review->user_id == Auth::user()->id) {
                    return view('reviews.edit')->with('review', $review);
                }
                else {
                    Session::flash('fail', "This review is no longer available.");
                    return back();
                }
            }
            else {
                Session::flash('fail', "This review is no longer available.");
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
        $this->validate($request, array(
            'comment' => 'required|min:5|max:2000'
        ));
        if (Auth::check()) {
            $review = Review::find($id);
            if ($review) {
                if ($review->user_id == Auth::user()->id) {
                    if ($request->clean) {
                        $review->clean = $request->clean;
                    }
                    if ($request->amenity) {
                        $review->amenity = $request->amenity;
                    }
                    if ($request->service) {
                        $review->service = $request->service;
                    }
                    if ($request->host) {
                        $review->host = $request->host;
                    }
                    $review->comment = Purifier::clean($request->comment);
                    $review->save();

                    Session::flash('success', 'Review was edited.');
                    return redirect()->route('rentals.show', [$review->rental_id]);
                }
                else {
                    Session::flash('fail', "This review is no longer available.");
                    return back();
                }
            }
            else {
                Session::flash('fail', "This review is no longer available.");
                return back();
            }
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
        if (Auth::check()) {
            $review = Review::find($id);
            $review->delete();
            Session::flash('success', 'Comment deleted.');
            return back();
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }
}
