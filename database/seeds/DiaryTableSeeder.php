<?php

use App\Models\Category;
use App\Models\Diary;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DiaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publish = ['0', '1', '2', '3'];
        for ($i = 0; $i < 30 ; $i++) { 
        	$faker = Faker::create();
        	$diary = new Diary;
        	$diary->publish = $publish[$faker->numberBetween(0, count($publish)-1)];
        	$diary->title = $faker->text(64);
        	$diary->message = $faker->paragraph;
        	$diary->user_id = User::all()->random()->id;
        	$diary->category_id = Category::all()->random()->id;
        	$diary->save();
        }
    }
}
