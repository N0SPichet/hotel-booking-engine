<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Diary;
use App\Category;
use Session;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $diaries = Diary::orderBy('updated_at', 'desc')->paginate(10);
        return view('diaries.index')->with('diaries', $diaries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('diaries.create')->with('categories', $categories);
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
            'title' => 'required|max:255',
            'categories_id' => 'required|integer',
            'message' => 'required'
        ));
        //store in the database
        $diary = new Diary;

        $diary->users_id = Auth::user()->id;
        $diary->title = $request->title;
        $diary->categories_id = $request->categories_id;
        $diary->message = $request->message;

        $diary->save();

        Session::flash('success', 'This diary was succussfully save!');

        return redirect()->route('diary.single', $diary->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $diary = Diary::find($id);
        $categories = Category::all();
        return view('diaries.show')->with('diary', $diary)->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diary = Diary::find($id);
        $categories = Category::all();
        $cats = array();
        foreach ($categories as $category) {
            $cats[$category->id] = $category->category_name;
        }
        return view('diaries.edit')->with('diary', $diary)->with('categories', $cats);
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
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'categories_id' => 'required|integer',
            'message' => 'required'
        ));

        $diary = Diary::find($id);

        $diary->users_id = Auth::user()->id;
        $diary->title = $request->input('title');
        $diary->categories_id = $request->input('categories_id');
        $diary->message = $request->input('message');

        $diary->save();

        Session::flash('success', 'This diary was successfully saved.');

        return redirect()->route('diary.single', $diary->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $diary = Diary::find($id);

        $diary->delete();

        return redirect()->route('diaries.index');
    }
}
