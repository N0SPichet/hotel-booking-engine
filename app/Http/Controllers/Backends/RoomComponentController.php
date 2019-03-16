<?php

namespace App\Http\Controllers\Backends;

use App\Http\Controllers\Controller;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houserule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /*Amenities*/
    public function amenities_index()
    {
        $amenities = Houseamenity::all();
        return view('admin.components.amenities.index')->with('amenities', $amenities);
    }

    public function amenities_store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));
        $amenity = new Houseamenity;
        $amenity->name = $request->name;
        $amenity->save();
        Session::flash('success', 'New Amenity was successfully created');
        return redirect()->route('comp.amenities.index');
    }

    public function amenities_show($id)
    {
        $amenity = Houseamenity::find($id);
        if (!is_null($amenity)) {
        	return view('admin.components.amenities.show')->with('amenity', $amenity);
        }
        return redirect()->route('comp.amenities.index');
    }

    public function amenities_edit($id)
    {
        $amenity = Houseamenity::find($id);
        if (!is_null($amenity)) {
        	return view('admin.components.amenities.edit')->with('amenity', $amenity);
        }
        return redirect()->route('comp.amenities.index');
    }

    public function amenities_update(Request $request, $id)
    {
        $amenity = Houseamenity::find($id);
        $this->validate($request, array(
            'name' => 'required'
        ));
        if (!is_null($amenity)) {
	        $amenity->name = $request->name;
	        $amenity->save();
	        Session::flash('success', 'This amenity was successfully updated.');
	        return redirect()->route('comp.amenities.show', $amenity->id);
    	}
        return redirect()->route('comp.amenities.index');
    }

    public function amenities_destroy($id)
    {
        $amenity = Houseamenity::find($id);
        if (!is_null($amenity)) {
	        $amenity->houses()->detach();
	        $amenity->delete();
	        Session::flash('success', 'The amenity was successfully deleted');
	    }
        return redirect()->route('comp.amenities.index');
    }

    /*Details*/
    public function details_index()
    {
        $details = Housedetail::all();
        return view('admin.components.details.index')->with('details', $details);
    }

    public function details_store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));
        $detail = new Housedetail;
        $detail->name = $request->name;
        $detail->save();
        Session::flash('success', 'New detail was successfully created');
        return redirect()->route('comp.details.index');
    }

    public function details_show($id)
    {
        $detail = Housedetail::find($id);
        if (!is_null($detail)) {
        	return view('admin.components.details.show')->with('detail', $detail);
        }
        return redirect()->route('comp.details.index');
    }

    public function details_edit($id)
    {
        $detail = Housedetail::find($id);
        if (!is_null($detail)) {
        	return view('admin.components.details.edit')->with('detail', $detail);
        }
        return redirect()->route('comp.details.index');
    }

    public function details_update(Request $request, $id)
    {
        $detail = Housedetail::find($id);
        $this->validate($request, array(
            'name' => 'required'
        ));
        if (!is_null($detail)) {
	        $detail->name = $request->name;
	        $detail->save();
	        Session::flash('success', 'This detail was successfully updated.');
	        return redirect()->route('comp.details.show', $detail->id);
    	}
        return redirect()->route('comp.details.index');
    }

    public function details_destroy($id)
    {
        $detail = Housedetail::find($id);
        if (!is_null($detail)) {
	        $detail->houses()->detach();
	        $detail->delete();
	        Session::flash('success', 'The detail was successfully deleted');
	    }
        return redirect()->route('comp.details.index');
    }

    /*Rules*/
    public function rules_index()
    {
        $rules = Houserule::all();
        return view('admin.components.rules.index')->with('rules', $rules);
    }

    public function rules_store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required'
        ));
        $rule = new Houserule;
        $rule->name = $request->name;
        $rule->save();
        Session::flash('success', 'New rule was successfully created');
        return redirect()->route('comp.rules.index');
    }

    public function rules_show($id)
    {
        $rule = Houserule::find($id);
        if (!is_null($rule)) {
        	return view('admin.components.rules.show')->with('rule', $rule);
        }
        return redirect()->route('comp.rules.index');
    }

    public function rules_edit($id)
    {
        $rule = Houserule::find($id);
        if (!is_null($rule)) {
        	return view('admin.components.rules.edit')->with('rule', $rule);
        }
        return redirect()->route('comp.rules.index');
    }

    public function rules_update(Request $request, $id)
    {
        $rule = Houserule::find($id);
        $this->validate($request, array(
            'name' => 'required'
        ));
        if (!is_null($rule)) {
	        $rule->name = $request->name;
	        $rule->save();
	        Session::flash('success', 'This rule was successfully updated.');
	        return redirect()->route('comp.rules.show', $rule->id);
    	}
        return redirect()->route('comp.rules.index');
    }

    public function rules_destroy($id)
    {
        $rule = Houserule::find($id);
        if (!is_null($rule)) {
	        $rule->houses()->detach();
	        $rule->delete();
	        Session::flash('success', 'The rule was successfully deleted');
	    }
        return redirect()->route('comp.rules.index');
    }
}
