<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Diary;
use App\Models\DiaryImage;
use App\Models\Rental;
use App\Models\Tag;
use App\Subscribe;
use App\User;
use Carbon\Carbon;
use DateTime;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Purifier;
use Session;
use Storage;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $diaries = Diary::where('publish', '1')->orWhere('publish', '2')->orderBy('created_at', 'desc')->paginate(8);
        return view('diaries.index')->with('diaries', $diaries);
    }

    public function tripdiary($rentalId){
        $rental = Rental::find($rentalId);
        if ($rental) {
            if (Auth::user()->id == $rental->user_id && $rental->checkin_status == '1') {
                $datetime1 = new DateTime($rental->rental_datein);
                $datetime2 = new DateTime($rental->rental_dateout);
                $interval = $datetime1->diff($datetime2);
                $years = $interval->format('%y');
                $months = $interval->format('%m');
                $days = $interval->format('%d');
                $days = $days + 1;

                $date[] = array();
                $rental_datein = $rental->rental_datein;
                for ($i=0; $i < $days; $i++) { 
                    $date[$i] = $rental_datein;
                    $rental_datein = date_create($rental_datein);
                    date_add($rental_datein, date_interval_create_from_date_string('1 days'));
                    $rental_datein = date_format($rental_datein, 'Y-m-d');
                }

                $diaries = Diary::where('rentals_id', $rentalId)->get();
                if ($diaries->isEmpty()) {
                    for ($i=0; $i <= $days; $i++) {
                        $diary = new Diary;
                        $diary->publish = '0';
                        if ($i == 0) {
                            $diary->title = 'Diary Title';
                        }
                        if ($i != 0) {
                            $diary->message = 'Story about day '. $i;
                        }
                        $diary->days = $i;
                        $diary->users_id = $rental->user_id;
                        $diary->categories_id = '1';
                        $diary->rentals_id = $rental->id;
                        $diary->save();
                    }
                }
                $diaries = Diary::where('rentals_id', $rentalId)->get();
                return view('diaries.tripdiary_single')->with('diaries', $diaries)->with('rental', $rental)->with('days', $days)->with('date', $date);
            }
            else {
                Session::flash('fail', "This diary is no longer available.");
                return back();
            }
        }
        else {
            Session::flash('fail', "This diary is no longer available.");
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('diaries.create')->with('categories', $categories)->with('tags', $tags);
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
            'title' => 'required|max:255',
            'categories_id' => 'required',
            'message' => 'required'
        ));
        if (Auth::check()) {
            $diary = new Diary;
            $diary->users_id = Auth::user()->id;
            $diary->title = $request->title;
            if ($request->cover_image) {
                $cover_image = $request->file('cover_image');
                $filename = time() . rand(9,99) . Auth::user()->id . '.' . $cover_image->getClientOriginalExtension();
                $location = public_path('images/diaries/'.$filename);
                Image::make($cover_image)->resize(1440,1080)->save($location);
                $diary->cover_image = $filename;
            }
            $diary->categories_id = $request->categories_id;
            $diary->message = Purifier::clean($request->message);
            $diary->save();
            if ($request->hasFile('images')) {
                foreach ($request->images as $diaryimage) {
                    $diary_image = new DiaryImage;
                    $filename = time() . rand(9,99) . Auth::user()->id . '.' . $diaryimage->getClientOriginalExtension();
                    $location = public_path('images/diaries/'.$filename);
                    Image::make($diaryimage)->resize(1440,1080)->save($location);
                    $diary_image->image = $filename;
                    $diary_image->diary_id = $diary->id;
                    $diary_image->save();
                }
            }
            $subscribe = new Subscribe;
            $subscribe->writer = $diary->users->id;
            $subscribe->follower = Auth::user()->id;
            $subscribe->save();
            $diary->tags()->sync($request->tags, false);
            Session::flash('success', 'This diary was succussfully save!');
            return redirect()->route('diary.single', $diary->id);
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function single($id)
    {
        if (Auth::check()) {
            $diary = Diary::find($id);
            if ($diary != NULL) {
                if (Auth::user()->id == $diary->users_id && $diary->rentals_id == NULL) {
                    $categories = Category::all();
                    return view('diaries.single')->with('diary', $diary)->with('categories', $categories);
                }
                else {
                    Session::flash('fail', "This diary is no longer available.");
                    return back();
                }
            }
            else {
                Session::flash('fail', "This diary is no longer available.");
                return back();
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
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
        $diary = Diary::where('id', $id)->where(function ($query) {
            $query->where('publish', '1')->orWhere('publish', '2');
        })->first();
        if ($diary) {
            if ($diary->rentals_id != NULL) {
                $rental = Rental::find($diary->rentals_id);
                $datetime1 = new DateTime($rental->rental_datein);
                $datetime2 = new DateTime($rental->rental_dateout);
                $interval = $datetime1->diff($datetime2);
                $years = $interval->format('%y');
                $months = $interval->format('%m');
                $days = $interval->format('%d');
                $days = $days + 1;
                $diaries = Diary::where('rentals_id', $rental->id)->get();

                $date[] = array();
                $rental_datein = $rental->rental_datein;
                for ($i=0; $i < $days; $i++) { 
                    $date[$i] = $rental_datein;
                    $rental_datein = date_create($rental_datein);
                    date_add($rental_datein, date_interval_create_from_date_string('1 days'));
                    $rental_datein = date_format($rental_datein, 'Y-m-d');
                }
                if ($diary->publish == '1') {
                    if (Auth::check()) {
                        $subscribe = Subscribe::where('writer', $diary->users->id)->where('follower', Auth::user()->id)->first();
                        if ($subscribe) {
                            return view('diaries.tripdiary_show')->with('diaries', $diaries)->with('subscribe', $subscribe)->with('days', $days)->with('date', $date);
                        }
                        else {
                            return view('diaries.subscribe')->with('diary', $diary);
                        }
                    }
                    else {
                        return view('diaries.subscribe')->with('diary', $diary);
                    }
                }
                elseif ($diary->publish == '2') {
                    $subscribe = NULL;
                    if (Auth::check()) {
                        $subscribe = Subscribe::where('writer', $diary->users->id)->where('follower', Auth::user()->id)->first();
                    }
                    return view('diaries.tripdiary_show')->with('diaries', $diaries)->with('subscribe', $subscribe)->with('days', $days)->with('date', $date);
                }
            }
            else if ($diary->rentals_id == NULL) {
                $categories = Category::all();
                if ($diary->publish == '1') {
                    if (Auth::check()) {
                        $subscribe = Subscribe::where('writer', $diary->users->id)->where('follower', Auth::user()->id)->first();
                        if ($subscribe) {
                            return view('diaries.show')->with('diary', $diary)->with('subscribe', $subscribe)->with('categories', $categories);
                        }
                        else {
                            return view('diaries.subscribe')->with('diary', $diary);
                        }
                    }
                    else {
                        return view('diaries.subscribe')->with('diary', $diary);
                    }
                }
                elseif ($diary->publish == '2') {
                    $subscribe = NULL;
                    if (Auth::check()) {
                        $subscribe = Subscribe::where('writer', $diary->users->id)->where('follower', Auth::user()->id)->first();
                    }
                    return view('diaries.show')->with('diary', $diary)->with('subscribe', $subscribe)->with('categories', $categories);
                }
            }
        }
        else {
            Session::flash('fail', "This diary is no longer available.");
            return back();
        }
    }

    public function subscribe($id, Request $request)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $subscribe = Subscribe::where('writer', $id)->where('follower', Auth::user()->id)->first();
            if ($subscribe) {
                Session::flash('success', "You already follow " . $user->user_fname . ".");
                return back();
            }
            else {
                $subscribe = new Subscribe;
                $subscribe->writer = $id;
                $subscribe->follower = Auth::user()->id;
                $subscribe->save();
                Session::flash('success', "You are now following " . $user->user_fname . ".");
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
    }

    public function unsubscribe($id, Request $request)
    {
        if (Auth::check()) {
            $user = User::find($id);
            $subscribe = Subscribe::where('writer', $id)->where('follower', Auth::user()->id)->first();
            if ($subscribe) {
                $subscribe->delete();
                Session::flash('success', "Unfollowing " . $user->user_fname . ".");
                return back();
            }
            else {
                Session::flash('success', "You already follow " . $user->user_fname . ".");
                return back();
            }
        }
        else {
            Session::flash('fail', "You need to login first.");
            return redirect()->route('login');
        }
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
        if ($diary->users->id == Auth::user()->id) {
            $categories = Category::all();
            $cats = array();
            foreach ($categories as $category) {
                $cats[$category->id] = $category->category_name;
            }

            $tags = Tag::all();
            $tag2 = array();
            foreach ($tags as $tag) {
                $tag2[$tag->id] = $tag->tag_name;
            }
            return view('diaries.edit')->with('diary', $diary)->with('tags', $tag2)->with('categories', $cats);
        }
        else {
            Session::flash('fail', "Request not found, You don't have permission to see this files!");
            return back();
        }
    }

    public function tripdiary_edit($id, $day){
        if (Auth::check()) {
            $diary_first = Diary::where('rentals_id', $id)->where('days', '0')->first();
            $diary_title = $diary_first->title;
            $rental = Rental::find($diary_first->rentals_id);
            $datetime1 = new DateTime($rental->rental_datein);
            $datetime2 = new DateTime($rental->rental_dateout);
            $interval = $datetime1->diff($datetime2);
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            $days = $days + 1;
            $diary = Diary::where('rentals_id', $id)->where('days', $day)->first();
            if ($diary_first->users->id == Auth::user()->id) {
                if ($diary == NULL && $day <= $days) {
                    $diary = new Diary;
                    if ($day == 0) {
                        $diary->title = "Diary Title";
                    }
                    $diary->days = $day;
                    $diary->users_id = Auth::user()->id;
                    $diary->categories_id = $diary_first->categories_id;
                    $diary->rentals_id = $id;
                    $diary->save();
                }
                else if ($day > $days) {
                    Session::flash('fail', "Request not found, url invalid!");
                    return back();
                }
            }
            if ($diary->users->id == Auth::user()->id) {
                if ($diary->days == '0') {
                    $categories = Category::all();
                    $cats = array();
                    foreach ($categories as $category) {
                        $cats[$category->id] = $category->category_name;
                    }

                    $tags = Tag::all();
                    $tag2 = array();
                    foreach ($tags as $tag) {
                        $tag2[$tag->id] = $tag->tag_name;
                    }
                    return view('diaries.tripdiary_edit')->with('diary_title', $diary_title)->with('diary', $diary)->with('tags', $tag2)->with('categories', $cats)->with('day', $day);
                }
                else {
                    return view('diaries.tripdiary_edit')->with('diary_title', $diary_title)->with('diary', $diary)->with('day', $day);
                }
            }
            else {
                Session::flash('fail', "Request not found, You don't have permission to see this files!");
                return back();
            }
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
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'categories_id' => 'required|integer',
            'message' => 'required'
        ));
        if (Auth::check()) {
            $diary = Diary::find($id);
            if (Auth::user()->id == $diary->users->id) {
                $diary->users_id = Auth::user()->id;
                $diary->title = $request->input('title');
                if ($request->cover_image == NULL && $request->select_cover_image != NULL) {
                    $cover_image = DiaryImage::where('image', $diary->cover_image)->first();
                    if ($cover_image == NULL) {
                        $oldfilename = $diary->cover_image;
                        $diary_image = new DiaryImage;
                        $diary_image->image = $oldfilename;
                        $diary_image->diary_id = $diary->id;
                        $diary_image->save();
                    }
                    $diary->cover_image = $request->select_cover_image;
                }
                else if ($request->cover_image != NULL) {
                    if ($diary->cover_image != NULL) {
                        $cover_image = DiaryImage::where('image', $diary->cover_image)->first();
                        if ($cover_image == NULL) {
                            $oldfilename = $diary->cover_image;
                            $diary_image = new DiaryImage;
                            $diary_image->image = $oldfilename;
                            $diary_image->diary_id = $diary->id;
                            $diary_image->save();
                        }
                    }
                    $cover_image = $request->file('cover_image');
                    $filename = time() . rand(9,99) . Auth::user()->id . '.' . $cover_image->getClientOriginalExtension();
                    $location = public_path('images/diaries/'.$filename);
                    Image::make($cover_image)->resize(1440,1080)->save($location);
                    $diary->cover_image = $filename;
                }
                $diary->categories_id = $request->input('categories_id');
                $diary->message = Purifier::clean($request->input('message'));
                $diary->publish = $request->publish;
                $diary->save();
                if (isset($request->tags)) {
                    $diary->tags()->sync($request->tags);
                }
                else{
                    $diary->tags()->sync(array());
                }
                if ($request->images) {
                    foreach ($request->images as $diaryimage) {
                        $diary_image = new DiaryImage;
                        $filename = time() . rand(9,99) . Auth::user()->id . '.' . $diaryimage->getClientOriginalExtension();
                        $location = public_path('images/diaries/'.$filename);
                        Image::make($diaryimage)->resize(1440,1080)->save($location);
                        $diary_image->image = $filename;
                        $diary_image->diary_id = $diary->id;
                        $diary_image->save();
                    }
                }
                Session::flash('success', 'This diary was successfully saved.');
                return redirect()->route('diary.single', $diary->id);
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function tripdiary_update(Request $request, $id)
    {
        if (Auth::check()) {
            $diary = Diary::find($id);
            if (Auth::user()->id == $diary->users->id) {
                if ($diary->days == '0') {
                    if ($diary->categories_id != $request->input('categories_id')) {
                        $diary->categories_id = $request->input('categories_id');
                        $diaries = Diary::where('rentals_id', $diary->rentals_id)->get();
                        foreach ($diaries as $key => $diary) {
                             $diary->categories_id = $request->input('categories_id');
                             $diary->save();
                        }
                    }
                    $diary = Diary::find($id);
                    $diary->title = $request->input('title');
                    if (isset($request->tags)) {
                        $diary->tags()->sync($request->tags);
                    }
                    else{
                        $diary->tags()->sync(array());
                    }
                    $diary->message = Purifier::clean($request->input('message'));
                    $image = DiaryImage::where('diary_id', $diary->id)->first();
                    if ($image != NULL) {
                        if ($request->cover_image) {
                            $filename = $image->image;
                            $image->delete();
                            $location = public_path('images/diaries/'.$filename);
                            File::delete($location);

                            $image = $request->cover_image;
                            $cover_image = new DiaryImage;
                            $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                            $location = public_path('images/diaries/'.$filename);
                            Image::make($image)->resize(1440,1080)->save($location);
                            $cover_image->image = $filename;
                            $cover_image->diary_id = $diary->id;
                            $cover_image->save();
                            $diary->cover_image = $filename;
                        }
                    }
                    elseif ($image == NULL) {
                        if ($request->cover_image) {
                            $image = $request->cover_image;
                            $cover_image = new DiaryImage;
                            $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                            $location = public_path('images/diaries/'.$filename);
                            Image::make($image)->resize(1440,1080)->save($location);
                            $cover_image->image = $filename;
                            $cover_image->diary_id = $diary->id;
                            $cover_image->save();
                            $diary->cover_image = $filename;
                        }
                    }
                    $diary->publish = $request->publish;
                    $diary->save();
                    Session::flash('success', 'This diary was successfully saved.');
                    return redirect()->route('tripdiary', $diary->rentals_id);
                }
                elseif ($diary->days != '0'){
                    $diary->message = Purifier::clean($request->input('message'));
                    if ($request->images) {
                        foreach ($request->images as $image) {
                            $content_image = new DiaryImage;
                            $filename = time() . rand(9,99) . Auth::user()->id . '.' . $image->getClientOriginalExtension();
                            $location = public_path('images/diaries/'.$filename);
                            Image::make($image)->resize(1440,1080)->save($location);
                            $content_image->image = $filename;
                            $content_image->diary_id = $diary->id;
                            $content_image->save();
                        }
                    }
                    $diary->save();
                    Session::flash('success', 'This diary was successfully saved.');
                    return redirect()->route('tripdiary', $diary->rentals_id);
                }
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
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
            $diary = Diary::find($id);
            if ($diary) {
                if ($diary->users->id == Auth::user()->id) {
                    $comments = Comment::where('diary_id', $diary->id)->get();
                    foreach ($comments as $comment) {
                        $comment->delete();
                    }
                    $filename = $diary->cover_image;
                    $location = public_path('images/diaries/'.$filename);
                    File::delete($location);
                    $diary->tags()->detach();
                    $diary_images = DiaryImage::where('diary_id', $diary->id)->get();
                    foreach ($diary_images as $image) {
                        $filename = $image->image;
                        $image->delete();
                        $location = public_path('images/diaries/'.$filename);
                        File::delete($location);
                    }
                    $diary->delete();
                    Session::flash('success', 'This diary is no longer available.');
                    return redirect()->route('diaries.mydiaries');
                }
            }
            else {
                Session::flash('success', 'This diary is no longer available.');
                return back();
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function tripdiary_destroy($id)
    {
        if (Auth::check()) {
            $diaries = Diary::where('rentals_id', $id)->get();
            if ($diaries) {
                $comments = Comment::where('diary_id', $diaries[0]->id)->get();
                foreach ($comments as $comment) {
                    $comment->delete();
                }
                $diaries[0]->tags()->detach();
                foreach ($diaries as $diary) {
                    $images = DiaryImage::where('diary_id', $diary->id)->get();
                    foreach ($images as $image) {
                        $filename = $image->image;
                        $image->delete();
                        $location = public_path('images/diaries/'.$filename);
                        File::delete($location);
                    }
                    $diary->delete();
                }
                Session::flash('success', 'This diary is no longer available.');
                return redirect()->route('diaries.mydiaries');
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }

    public function detroyimage($id)
    {
        if (Auth::check()) {
            $image = DiaryImage::find($id);
            $diary_id = $image->diary_id;
            $filename = $image->image;
            $image->delete();
            $location = public_path('images/diaries/'.$filename);
            File::delete($location);
            return back();
        }
        else {
            return back();
        }
    }
}
