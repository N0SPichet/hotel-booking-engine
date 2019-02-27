<?php

use App\Models\Apartmentprice;
use App\Models\Food;
use App\Models\Guestarrive;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Map;
use Illuminate\Database\Seeder;

class ApartmentTableSeeder extends Seeder
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
    	$guestarrive->checkin_from = '8AM';
    	$guestarrive->checkin_to = 'Flexible';
    	$guestarrive->save();

    	$price = new Apartmentprice;
    	$price->type_single = 10;
    	$price->single_price = 700;
    	$price->type_deluxe_single = 8;
    	$price->deluxe_single_price = 1000;
    	$price->type_double_room = 12;
    	$price->double_price = 1400;
    	$price->discount = 0;
    	$price->welcome_offer = 0;
    	$price->save();

    	$food = new Food;
    	$food->breakfast = 0;
        $food->lunch = 0;
        $food->dinner = 0;
    	$food->save();

        $house = new House;
        $house->publish = '1';
        $house->house_title = 'Test apartment';
        $house->house_capacity = 2;
        $house->house_property = 'Hotel';
        $house->house_guestspace = 'Entrie';
        $house->house_bedrooms = 1;
        $house->house_beds = 2;
        $house->house_bathroom = 1;
        $house->house_bathroomprivate = 1;
        $house->house_address = 82;
        $house->house_postcode = 82150;
        $house->house_description = '<p>Test description</p>';
        $house->about_your_place = '<p>Test about</p>';
        $house->guest_can_access = '<p>Test access</p>';
        $house->optional_note = '<p>Test note</p>';
        $house->about_neighborhood = '<p>Test neighborhood</p>';
        $house->cover_image = '1551026687762.jpg';
        $house->users_id = 2;
        $house->housetypes_id = 2;
        $house->sub_district_id = 3348;
        $house->district_id = 434;
        $house->province_id = 33;
        $house->guestarrives_id = $guestarrive->id;
        $house->apartmentprices_id = $price->id;
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
        $map->map_lat = '7.897171916761951000';
        $map->map_lng = '98.346434798889160000';
        $map->houses_id = $house->id;
        $map->save();

        $image = new HouseImage;
        $image->name = '1551026687762.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026688142.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026688272.jpg';
        $image->house_id = $house->id;
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026688212.jpg';
        $image->house_id = $house->id;
        $image->save();

        $image = new HouseImage;
        $image->name = '1551026689372.jpg';
        $image->house_id = $house->id;
        $image->room_type = '1';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026689692.jpg';
        $image->house_id = $house->id;
        $image->room_type = '1';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026690912.jpg';
        $image->house_id = $house->id;
        $image->room_type = '1';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026690202.jpg';
        $image->house_id = $house->id;
        $image->room_type = '1';
        $image->save();

        $image = new HouseImage;
        $image->name = '1551026690812.jpg';
        $image->house_id = $house->id;
        $image->room_type = '2';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026691812.jpg';
        $image->house_id = $house->id;
        $image->room_type = '2';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026691442.jpg';
        $image->house_id = $house->id;
        $image->room_type = '2';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026692612.jpg';
        $image->house_id = $house->id;
        $image->room_type = '2';
        $image->save();

        $image = new HouseImage;
        $image->name = '1551026692612.jpg';
        $image->house_id = $house->id;
        $image->room_type = '3';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026692632.jpg';
        $image->house_id = $house->id;
        $image->room_type = '3';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026693572.jpg';
        $image->house_id = $house->id;
        $image->room_type = '3';
        $image->save();
        $image = new HouseImage;
        $image->name = '1551026693102.jpg';
        $image->house_id = $house->id;
        $image->room_type = '3';
        $image->save();
    }
}
