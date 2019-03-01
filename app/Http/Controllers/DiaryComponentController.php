<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DiaryComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('crole:Admin');
    }

    /*Categories*/
    public function categories_index()
    {
        $categories = Category::all();
        return view('components.categories.index')->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function categories_store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:45'
        ));
        $category = New Category;
        $category->name = $request->name;
        $category->save();
        Session::flash('seccess', 'New Category has been created');
        return redirect()->route('comp.categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categories_show($id)
    {
        $category = Category::find($id);
        if (!is_null($category)) {
        	return view('components.categories.show')->with('category', $category);
        }
        return redirect()->route('comp.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categories_edit($id)
    {
        $category = Category::find($id);
        if (!is_null($category)) {
        	return view('components.categories.edit')->with('category', $category);
        }
        return redirect()->route('comp.categories.index');
    }

    public function categories_update(Request $request, Category $category)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));
        if (!is_null($category)) {
	        $category->name = $request->name;
	        $category->save();
	        Session::flash('success', 'This category was successfully updated.');
	        return redirect()->route('comp.categories.show', $category->id);
    	}
        return redirect()->route('comp.categories.index');
    }

    public function categories_destroy(Category $category)
    {
    	if($category->diaries()->count()) {
    		return redirect()->route('comp.categories.index');
    	}
        if($category->delete()) {
        	Session::flash('success', 'The category was successfully deleted');
            return redirect()->route('comp.categories.index');
        }
    }

    /*Tags*/
    public function tags_index()
    {
        $tags = Tag::all();

        return view('components.tags.index')->with('tags', $tags);
    }

    public function tags_store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));
        $tag = new Tag;
        $tag->name = $request->name;
        $tag->save();
        Session::flash('success', 'New tag was successfully created');
        return redirect()->route('comp.tags.index');
    }

    public function tags_show($id)
    {
        $tag = Tag::find($id);
        if (!is_null($tag)) {
        	return view('components.tags.show')->with('tag', $tag);
        }
        return redirect()->route('comp.tags.index');
    }

    public function tags_edit($id)
    {
        $tag = Tag::find($id);
        if (!is_null($tag)) {
        	return view('components.tags.edit')->with('tag', $tag);
        }
        return redirect()->route('comp.tags.index');
    }

    public function tags_update(Request $request, Tag $tag)
    {
        $this->validate($request, ['name' => 'required']);
        $tag->name = $request->name;
        $tag->save();
        Session::flash('success', 'This tag was successfully updated.');
        return redirect()->route('comp.tags.show', $tag->id);
    }

    public function tags_destroy(Tag $tag)
    {
        $tag->diaries()->detach();
        $tag->delete();
        Session::flash('success', 'The tag was successfully deleted');
        return redirect()->route('comp.tags.index');
    }
}
