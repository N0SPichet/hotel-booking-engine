<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Diary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class CommentController extends Controller
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'comment' => 'required|min:5|max:2000'
        ));
        $diary = Diary::find($request->diary_id);
        $comment = new Comment;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->diary_id = $diary->id;
        $comment->save();

        Session::flash('success', 'Comment was added');
        return redirect()->route('diaries.show', [$diary->id]);
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
        $comment = Comment::find($id);
        return view('comments.edit')->with('comment', $comment);
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
            'comment' => 'required|min:10|max:2000'
        ));
        $comment = Comment::find($id);
        $comment->comment = $request->comment;
        $comment->save();

        Session::flash('success', 'Comment updated.');
        return redirect()->route('diary.single', $comment->diary_id);
    }

    public function delete($id){
        $comment = Comment::find($id);
        return view('comments.delete')->with('comment', $comment);
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
            $comment = Comment::find($id);
            if (Auth::user()->email == $comment->email) {
                $diary_id = $comment->diary_id;
                $comment->delete();
                $diary = Diary::find($diary_id);
                if (Auth::user()->id == $diary->user_id) {
                    Session::flash('success', 'Comment deleted');
                    return redirect()->route('diary.single', $diary->id);
                }
                elseif (Auth::user()->id != $diary->user_id) {
                    Session::flash('success', 'Comment deleted');
                    return redirect()->route('diaries.show', $diary->id);
                }
            }
            else {
                Session::flash('fail', "This comment is no longer available.");
                return back();
            }
        }
        else {
            Session::flash('success', 'You need to login first!');
            return redirect()->route('login');
        }
    }
}
