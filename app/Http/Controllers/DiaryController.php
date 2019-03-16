<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Diary;
use App\Models\DiaryImage;
use App\Models\Rental;
use App\Models\Subscribe;
use App\Models\Tag;
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
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $publish = ['1', '2'];
        $diaries = Diary::whereIn('publish', $publish)->orderBy('id', 'desc')->paginate(8);
        return view('diaries.index')->with('diaries', $diaries);
    }

    public function mydiaries($userId)
    {
        if (Auth::user()->id == $userId) {
            $diaries = Diary::where('user_id', $userId)->where(function($query) {
                $query->whereNull('days')->orWhere('days', '0');
            })->orderBy('id', 'desc')->paginate(10);
            return view('diaries.mydiary')->with('diaries', $diaries);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function tripdiary($rentalId, $userId){
        $rental = Rental::find($rentalId);
        if (!is_null($rental)) {
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

                $diaries = Diary::where('rental_id', $rentalId)->get();
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
                        $diary->user_id = $rental->user_id;
                        $diary->category_id = '1';
                        $diary->rental_id = $rental->id;
                        $diary->save();
                    }
                    $subscribe = Subscribe::where('writer', $diary->user_id)->where('follower', $diary->user_id)->first();
                    if (is_null($subscribe)) {
                        $subscribe = new Subscribe;
                    }
                    $subscribe->writer = $diary->user_id;
                    $subscribe->follower = $diary->user_id;
                    $subscribe->save();
                }
                $diaries = Diary::where('rental_id', $rentalId)->get();
                return view('diaries.tripdiary_single')->with('diaries', $diaries)->with('rental', $rental)->with('days', $days)->with('date', $date);
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
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
            'category_id' => 'required',
            'message' => 'required'
        ));
        $diary = new Diary;
        $diary->user_id = Auth::user()->id;
        $diary->title = $request->title;
        if ($request->cover_image) {
            $cover_image = $request->file('cover_image');
            $filename = time() . rand(9,99) . Auth::user()->id . '.' . $cover_image->getClientOriginalExtension();
            $location = public_path('images/diaries/'.$filename);
            Image::make($cover_image)->resize(1440,1080)->save($location);
            $diary->cover_image = $filename;
        }
        $diary->category_id = $request->category_id;
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
        $subscribe = Subscribe::where('writer', $diary->user_id)->where('follower', Auth::user()->id)->first();
        if (is_null($subscribe)) {
            $subscribe = new Subscribe;
        }
        $subscribe->writer = $diary->user_id;
        $subscribe->follower = $diary->user_id;
        $subscribe->save();
        $diary->tags()->sync($request->tags, false);
        Session::flash('success', 'This diary was succussfully save!');
        return redirect()->route('diaries.single', $diary->id);
    }

    public function single($diaryId)
    {
        $diary = Diary::find($diaryId);
        if (!is_null($diary)) {
            if (Auth::user()->id == $diary->user_id && $diary->rental_id == null) {
                return view('diaries.single')->with('diary', $diary);
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        else {
            Session::flash('fail', "This diary is no longer available.");
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($diaryId)
    {
        $diary = Diary::where('id', $diaryId)->where(function ($query) {
            $query->where('publish', '1')->orWhere('publish', '2');
        })->first();
        if (!is_null($diary)) {
            if ($diary->rental_id != null) {
                $rental = Rental::find($diary->rental_id);
                $datetime1 = new DateTime($rental->rental_datein);
                $datetime2 = new DateTime($rental->rental_dateout);
                $interval = $datetime1->diff($datetime2);
                $years = $interval->format('%y');
                $months = $interval->format('%m');
                $days = $interval->format('%d');
                $days = $days + 1;
                $diaries = Diary::where('rental_id', $rental->id)->get();

                $date[] = array();
                $rental_datein = $rental->rental_datein;
                for ($i=0; $i < $days; $i++) { 
                    $date[$i] = $rental_datein;
                    $rental_datein = date_create($rental_datein);
                    date_add($rental_datein, date_interval_create_from_date_string('1 days'));
                    $rental_datein = date_format($rental_datein, 'Y-m-d');
                }
                if ($diary->publish == '2') {
                    if (Auth::check()) {
                        if (!Auth::user()->subscribe($diary->id)) {
                            return view('diaries.tripdiary_show')->with('diaries', $diaries)->with('days', $days)->with('date', $date);
                        }
                    }
                    return view('diaries.subscribe')->with('diary', $diary);
                }
                if ($diary->publish == '1') {
                    return view('diaries.tripdiary_show')->with('diaries', $diaries)->with('days', $days)->with('date', $date);
                }
            }
            else {
                $categories = Category::all();
                if ($diary->publish == '2') {
                    if (Auth::check()) {
                        if (!is_null(Auth::user()->subscribe($diary->id))) {
                            return view('diaries.show')->with('diary', $diary)->with('categories', $categories);
                        }
                    }
                    return view('diaries.subscribe')->with('diary', $diary);
                }
                if ($diary->publish == '1') {
                    return view('diaries.show')->with('diary', $diary)->with('categories', $categories);
                }
            }
        }
        Session::flash('fail', "This diary is no longer available.");
        return back();
    }

    public function subscribe($userId, Request $request)
    {
        $user = User::find($userId);
        $subscribe = Subscribe::where('writer', $userId)->where('follower', Auth::user()->id)->first();
        if ($subscribe) {
            Session::flash('success', "You already follow " . $user->user_fname . ".");
            return redirect()->route('diaries.show', $request->diary_id);
        }
        else {
            $subscribe = new Subscribe;
            $subscribe->writer = $userId;
            $subscribe->follower = Auth::user()->id;
            $subscribe->save();
            Session::flash('success', "You are now following " . $user->user_fname . ".");
            return redirect()->route('diaries.show', $request->diary_id);
        }
    }

    public function unsubscribe($userId, Request $request)
    {
        $user = User::find($userId);
        $subscribe = Subscribe::where('writer', $userId)->where('follower', Auth::user()->id)->first();
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($diaryId)
    {
        $diary = Diary::find($diaryId);
        if (Auth::user()->id == $diary->user_id) {
            $categories = Category::all();
            $tags = Tag::all();
            return view('diaries.edit')->with('diary', $diary)->with('tags', $tags)->with('categories', $categories);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function tripdiary_edit($rentalId, $userId, $day){
        if (Auth::user()->id == $userId) {
            $diary_first = Diary::where('rental_id', $rentalId)->where('days', '0')->first();
            $diary_title = $diary_first->title;
            $rental = Rental::find($diary_first->rental_id);
            $datetime1 = new DateTime($rental->rental_datein);
            $datetime2 = new DateTime($rental->rental_dateout);
            $interval = $datetime1->diff($datetime2);
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            $days = $days + 1;
            $diary = Diary::where('rental_id', $rentalId)->where('days', $day)->first();
            if ($diary == null && $day <= $days) {
                $diary = new Diary;
                if ($day == 0) {
                    $diary->title = "Diary Title";
                }
                $diary->days = $day;
                $diary->user_id = Auth::user()->id;
                $diary->category_id = $diary_first->category_id;
                $diary->rental_id = $rentalId;
                $diary->save();
            }
            if ($day > $days) {
                Session::flash('fail', 'This diary is no longer available.');
                            return back();
            }
            if ($diary->days == '0') {
                $categories = Category::all();
                $tags = Tag::all();
                return view('diaries.tripdiary_edit')->with('diary_title', $diary_title)->with('diary', $diary)->with('tags', $tags)->with('categories', $categories)->with('day', $day);
            }
            else {
                return view('diaries.tripdiary_edit')->with('diary_title', $diary_title)->with('diary', $diary)->with('day', $day);
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $diaryId)
    {
        //validate the data
        $this->validate($request, array(
            'title' => 'required|max:255',
            'category_id' => 'required|integer',
            'message' => 'required'
        ));
        $diary = Diary::find($diaryId);
        if (Auth::user()->id == $diary->user_id) {
            $diary->user_id = Auth::user()->id;
            $diary->title = $request->input('title');
            if ($request->cover_image == null && $request->select_cover_image != null) {
                $cover_image = DiaryImage::where('image', $diary->cover_image)->first();
                if ($cover_image == null) {
                    $oldfilename = $diary->cover_image;
                    $diary_image = new DiaryImage;
                    $diary_image->image = $oldfilename;
                    $diary_image->diary_id = $diary->id;
                    $diary_image->save();
                }
                $diary->cover_image = $request->select_cover_image;
            }
            else if ($request->cover_image != null) {
                if ($diary->cover_image != null) {
                    $cover_image = DiaryImage::where('image', $diary->cover_image)->first();
                    if ($cover_image == null) {
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
            $diary->category_id = $request->input('category_id');
            $diary->message = Purifier::clean($request->input('message'));
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
            return redirect()->route('diaries.single', $diary->id);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function tripdiary_update(Request $request, $diaryId)
    {
        $diary = Diary::find($diaryId);
        if (Auth::user()->id == $diary->user_id) {
            if (!is_null($diary)) {
                if ($diary->days == '0') {
                    if ($diary->category_id != $request->input('category_id')) {
                        $diary->category_id = $request->input('category_id');
                        $diaries = Diary::where('rental_id', $diary->rental_id)->get();
                        foreach ($diaries as $key => $diary) {
                             $diary->category_id = $request->input('category_id');
                             $diary->save();
                        }
                    }
                    $diary = Diary::find($diaryId);
                    $diary->title = $request->input('title');
                    if (isset($request->tags)) {
                        $diary->tags()->sync($request->tags);
                    }
                    else{
                        $diary->tags()->sync(array());
                    }
                    $diary->message = Purifier::clean($request->input('message'));
                    $image = DiaryImage::where('diary_id', $diary->id)->first();
                    if (!is_null($image)) {
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
                    else {
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
                    $diary->save();
                    Session::flash('success', 'This diary was successfully saved.');
                    return redirect()->route('diaries.tripdiary', [$diary->rental_id, $diary->user_id]);
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
                    return redirect()->route('diaries.tripdiary', [$diary->rental_id, $diary->user_id]);
                }
            }
            Session::flash('fail', 'This diary is no longer available.');
            return back();
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($diaryId)
    {
        $diary = Diary::find($diaryId);
        if (!is_null($diary)) {
            if (Auth::user()->id == $diary->user_id) {
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
                if (back()->getTargetUrl() == route('dashboard.index', Auth::user()->id)) {
                    return redirect()->route('dashboard.index', Auth::user()->id);
                }
                return redirect()->route('diaries.mydiaries', Auth::user()->id);
            }
            Session::flash('fail', 'Unauthorized access.');
            return back();
        }
        Session::flash('success', 'This diary is no longer available.');
        return back();
    }

    public function tripdiary_destroy($rentalId)
    {
        $diaries = Diary::where('rental_id', $rentalId)->get();
        if (!is_null($diaries)) {
            if (Auth::user()->id == $diaries[0]->user_id) {
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
                if (back()->getTargetUrl() == route('dashboard.index', Auth::user()->id)) {
                    return redirect()->route('dashboard.index', Auth::user()->id);
                }
                return redirect()->route('diaries.mydiaries', Auth::user()->id);
            }
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function detroyimage($imageId)
    {
        $image = DiaryImage::find($imageId);
        if (Auth::user()->id == $image->diary->user_id) {
            $diaryId = $image->diary_id;
            $filename = $image->image;
            $image->delete();
            $location = public_path('images/diaries/'.$filename);
            File::delete($location);
            Session::flash('success', 'Image deleted.');
            return back();
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function temp_delete($diaryId)
    {
        $diary = Diary::find($diaryId);
        if (Auth::user()->id == $diary->user_id) {
            $diary->publish = '3';
            $diary->save();
            if (back()->getTargetUrl() == route('dashboard.diaries.index')) {
                return redirect()->route('dashboard.diaries.index');
            }
            if ($diary->days == '0') {
                return redirect()->route('diaries.tripdiary', [$diary->rental_id, $diary->user_id]);
            }
            return redirect()->route('diaries.single', $diary->id);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }

    public function restore($diaryId)
    {
        $diary = Diary::find($diaryId);
        if (Auth::user()->id == $diary->user_id) {
            $diary->publish = '0';
            $diary->save();
            if (back()->getTargetUrl() == route('dashboard.diaries.index')) {
                return redirect()->route('dashboard.diaries.index');
            }
            if ($diary->days == '0') {
                return redirect()->route('diaries.tripdiary', [$diary->rental_id, $diary->user_id]);
            }
            return redirect()->route('diaries.single', $diary->id);
        }
        Session::flash('fail', 'Unauthorized access.');
        return back();
    }
}
