<?php

use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RoomComponentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	/*Amenities*/
        for ($i = 1; $i <= 20; $i++) {
            $faker = Faker::create();
        	$amenity = new Houseamenity;
        	$amenity->name = $faker->text(16);
        	$amenity->save();
        }

        /*Details*/
        for ($i = 1; $i <= 10 ; $i++) {
            $faker = Faker::create();
        	$detail = new Housedetail;
        	$detail->name = $faker->text(16);
        	$detail->save();
        }

        /*Rules*/
        for ($i = 1; $i <= 10; $i++) {
            $faker = Faker::create();
        	$rule = new Houserule;
        	$rule->name = $faker->text(16);
        	$rule->save();
        }

        /*Spaces*/
        for ($i = 1; $i <= 10 ; $i++) { 
            $faker = Faker::create();
        	$space = new Housespace;
        	$space->name = $faker->text(16);
        	$space->save();
        }

        /*Types*/
        for ($i = 1; $i <= 5; $i++) { 
            $type = new Housetype;
            $type->name = "type ".$i;
            if ($i == 2 || $i == 3) {
                $type->name = "type ".$i." apartment";
            }
            $type->save();
        }
    }
}
