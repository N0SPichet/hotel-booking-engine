<?php

use App\Http\Controllers\Traits\GlobalFunctionTraits;
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
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class ApartmentTableSeeder extends Seeder
{
    use GlobalFunctionTraits;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_id = $this->getTypeId('apartment');
        $publish = ['0', '1'];
        for ($i = 0; $i < 5 ; $i++) { 
            $faker = Faker::create();
            $guestarrive = new Guestarrive;
            $guestarrive->notice = 'Same Day';
            $guestarrive->checkin_from = '8AM';
            $guestarrive->checkin_to = 'Flexible';
            $guestarrive->save();

            $price = new Apartmentprice;
            $price->type_single = rand(5, 10);
            $price->single_price = rand(800, 1200);
            $price->type_deluxe_single = rand(5, 10);
            $price->deluxe_single_price = rand(1000, 1600);
            $price->type_double_room = rand(5, 10);
            $price->double_price = rand(1600, 2400);
            $price->discount = rand(0, 10);
            $price->welcome_offer = rand(0, 1);
            $price->save();

            $food = new Food;
            $food->breakfast = rand(0, 1);
            $food->lunch = rand(0, 1);
            $food->dinner = rand(0, 1);
            $food->save();

            $house = new House;
            if ($i == 1) {
                $house->publish = '1';
            }
            else {
                $house->publish = $publish[rand(0, count($publish)-1)];
            }
            $house->house_title = $faker->text(16);
            $house->house_capacity = rand(1, 2);
            $house->house_property = 'Hotel';
            $house->house_guestspace = 'Entrie';
            $house->house_bedrooms = rand(1, 2);
            $house->house_beds = rand(1, 2);
            $house->house_bathroom = rand(1, 2);
            $house->house_bathroomprivate = rand(0, 1);
            $house->house_address = 82;
            $house->house_postcode = 82150;
            $faker = Faker::create();
            $house->house_description = '<p>'.$faker->text(256).'</p>';
            $faker = Faker::create();
            $house->about_your_place = '<p>'.$faker->text(128).'</p>';
            $faker = Faker::create();
            $house->guest_can_access = '<p>'.$faker->text(128).'</p>';
            $faker = Faker::create();
            $house->optional_note = '<p>'.$faker->text(64).'</p>';
            $faker = Faker::create();
            $house->about_neighborhood = '<p>'.$faker->text(128).'</p>';
            $house->cover_image = '1551026687762.jpg';
            $house->user_id = rand(1, 3);
            $house->housetype_id = $types_id[rand(0, count($types_id)-1)];
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

            $premessage = "Dear " . $house->user->user_fname;
            $detailmessage = "At " . date('jS F, Y H:i:s', strtotime($house->created_at)) . " you have create an apartment name '". $house->house_title."'";
            $endmessage = "";

            $data = array(
                'email' => $house->user->email,
                'subject' => "LTT - Your property are ready to deploy",
                'bodyMessage' => $premessage,
                'detailmessage' => $detailmessage,
                'endmessage' => $endmessage,
                'house' => $house
            );

            Mail::send('emails.room_create', $data, function($message) use ($data){
                $message->from('noreply@ltt.com');
                $message->to($data['email']);
                $message->subject($data['subject']);
            });
        }
    }
}
