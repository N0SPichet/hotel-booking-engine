<?php

use App\Models\Housetype;
use Illuminate\Database\Seeder;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) { 
        	$type = new Housetype;
        	$type->name = "type ".$i;
        	$type->save();
        }
    }
}
