<?php

use App\Http\Controllers\Traits\GlobalFunctionTraits;
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
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class RoomTableSeeder extends Seeder
{
    use GlobalFunctionTraits;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types_id = $this->getTypeId('room');
        $publish = ['0', '1'];
        for ($i = 0; $i < 5 ; $i++) { 
            $faker = Faker::create();
            $guestarrive = new Guestarrive;
            $guestarrive->notice = 'Same Day';
            $guestarrive->checkin_from = 'Flexible';
            $guestarrive->checkin_to = '6PM';
            $guestarrive->save();

            $price = new Houseprice;
            $price->price_perperson = 2;
            $price->price = rand(800, 2000);
            $price->food_price = rand(100, 300);
            $price->welcome_offer = rand(0, 1);
            $price->weekly_discount = rand(0, 5);
            $price->monthly_discount = rand(0, 10);
            $price->save();

            $food = new Food;
            $food->breakfast = rand(0, 1);
            $food->lunch = rand(0, 1);
            $food->dinner = rand(0, 1);
            $food->save();

            $house = new House;
            $house->publish = $publish[rand(0, 1)];
            $house->house_title = $faker->text(16);
            $house->house_capacity = rand(1, 2);
            $house->house_property = 'home';
            $house->no_rooms = 1;
            $house->house_guestspace = 'Entrie';
            $house->house_bedrooms = rand(1, 2);
            $house->house_beds = rand(1, 2);
            $house->house_bathroom = rand(1, 2);
            $house->house_bathroomprivate = rand(0, 1);
            $house->house_address = 81;
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
            $house->cover_image = '1551026527712.jpg';
            $house->user_id = rand(2, 3);
            $house->housetype_id = $types_id[rand(0, count($types_id)-1)];
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

            $premessage = "Dear " . $house->user->user_fname;
            $detailmessage = "At " . date('jS F, Y H:i:s', strtotime($house->created_at)) . " you have create a room name '". $house->house_title."'";
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
