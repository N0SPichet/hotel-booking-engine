<?php

use App\Models\Category;
use App\Models\Tag;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DiaryComponentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10 ; $i++) { 
            $faker = Faker::create();
        	$cat = new Category;
        	$cat->name = $faker->text(16);
        	$cat->save();
        }

        for ($i = 1; $i <= 10 ; $i++) {
            $faker = Faker::create();
            $tag = new Tag;
            $tag->name = $faker->text(16);
            $tag->save();
        }
    }
}
