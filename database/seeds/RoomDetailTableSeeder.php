<?php

use App\Models\Housedetail;
use Illuminate\Database\Seeder;

class RoomDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10 ; $i++) { 
        	$detail = new Housedetail;
        	$detail->name = "detail ".$i;
        	$detail->save();
        }
    }
}
