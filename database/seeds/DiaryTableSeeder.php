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
        for ($i = 0; $i < 25 ; $i++) { 
        	$faker = Faker::create();
        	$diary = new Diary;
        	$diary->publish = $faker->numberBetween(0, 2);
        	$diary->title = $faker->text(100);
        	$diary->message = $faker->paragraph;
        	$diary->user_id = User::all()->random()->id;
        	$diary->category_id = Category::all()->random()->id;
        	$diary->save();
        }
    }
}
