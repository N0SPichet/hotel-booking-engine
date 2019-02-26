<?php

use App\Models\Houseamenity;
use Illuminate\Database\Seeder;

class RoomAmenityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) { 
        	$amenity = new Houseamenity;
        	$amenity->name = "amenity ".$i;
        	$amenity->save();
        }
    }
}
