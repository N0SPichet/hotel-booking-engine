<?php

use App\Models\Houseamenity;
use App\Models\Housedetail;
use App\Models\Houserule;
use App\Models\Housespace;
use App\Models\Housetype;
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
        	$amenity = new Houseamenity;
        	$amenity->name = "amenity ".$i;
        	$amenity->save();
        }

        /*Details*/
        for ($i = 1; $i <= 10 ; $i++) { 
        	$detail = new Housedetail;
        	$detail->name = "detail ".$i;
        	$detail->save();
        }

        /*Rules*/
        for ($i = 1; $i <= 10; $i++) { 
        	$rule = new Houserule;
        	$rule->name = "rule ".$i;
        	$rule->save();
        }

        /*Spaces*/
        for ($i = 1; $i <= 10 ; $i++) { 
        	$space = new Housespace;
        	$space->name = "space ".$i;
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
