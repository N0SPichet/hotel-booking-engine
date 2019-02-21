<?php

use App\Models\Housespace;
use Illuminate\Database\Seeder;

class RoomSpaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10 ; $i++) { 
        	$space = new Housespace;
        	$space->name = "space ".$i;
        	$space->save();
        }
    }
}
