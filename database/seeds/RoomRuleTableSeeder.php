<?php

use App\Models\Houserule;
use Illuminate\Database\Seeder;

class RoomRuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) { 
        	$rule = new Houserule;
        	$rule->name = "rule ".$i;
        	$rule->save();
        }
    }
}
