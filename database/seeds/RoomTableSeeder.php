<?php

use App\Models\Food;
use App\Models\Guestarrive;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houseprice;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Map;
use Illuminate\Database\Seeder;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$guestarrive = new Guestarrive;
    	$guestarrive->notice = 'Same Day';
    	$guestarrive->checkin_from = 'Flexible';
    	$guestarrive->checkin_to = '6PM';
    	$guestarrive->save();

    	$price = new Houseprice;
    	$price->price_perperson = 2;
    	$price->price = 1000;
    	$price->food_price = 200;
    	$price->welcome_offer = 0;
    	$price->weekly_discount = 0;
    	$price->monthly_discount = 0;
    	$price->save();

    	$food = new Food;
    	$food->breakfast = 1;
    	$food->lunch = 1;
    	$food->dinner = 0;
    	$food->save();

        $house = new House;
        $house->publish = '1';
        $house->house_title = 'Test title';
        $house->house_capacity = 1;
        $house->house_property = 'home';
        $house->no_rooms = 1;
        $house->house_guestspace = 'Entrie';
        $house->house_bedrooms = 2;
        $house->house_beds = 2;
        $house->house_bathroom = 2;
        $house->house_bathroomprivate = 1;
        $house->house_address = 81;
        $house->house_postcode = 82150;
        $house->house_description = '<p>Test description</p>';
        $house->about_your_place = '<p>Test about</p>';
        $house->guest_can_access = '<p>Test access</p>';
        $house->optional_note = '<p>Test note</p>';
        $house->about_neighborhood = '<p>Test neighborhood</p>';
        $house->cover_image = '1551026527712.jpg';
        $house->users_id = 2;
        $house->housetypes_id = 1;
        $house->sub_district_id = 3348;
        $house->district_id = 434;
        $house->province_id = 33;
        $house->guestarrives_id = $guestarrive->id;
        $house->houseprices_id = $price->id;
        $house->foods_id = $food->id;
        $house->save();

        $amenities_id = array();
        $amenities = Houseamenity::all()->random(3);
        foreach ($amenities as $key => $amenity) {
            array_push($amenities_id, $amenity->id);
        }
        $spaces_id = array();
        $spaces = Housespace::all()->random(3);
        foreach ($spaces as $key => $space) {
            array_push($spaces_id, $space->id);
        }
        $rules_id = array();
        $rules = Houserule::all()->random(3);
        foreach ($rules as $key => $rule) {
            array_push($rules_id, $rule->id);
        }
        $details_id = array();
        $details = Housedetail::all()->random(3);
        foreach ($details as $key => $detail) {
            array_push($details_id, $detail->id);
        }
        $house->houseamenities()->sync($amenities_id, false);
        $house->housespaces()->sync($spaces_id, false);
        $house->houserules()->sync($rules_id, false);
        $house->housedetails()->sync($details_id, false);

        $map = new Map;
        $map->map_lat = '7.898107099308214500';
        $map->map_lng = '98.348451820068360000';
        $map->houses_id = $house->id;
        $map->save();

        $image = new HouseImage;
        $image->name = '1551026527712.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026528452.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026528552.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026528672.jpg';
        $image->house_id = $house->id;
        $image->save();
    }
}
