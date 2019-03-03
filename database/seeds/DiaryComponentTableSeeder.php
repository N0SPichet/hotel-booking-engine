<?php

use App\Models\Category;
use App\Models\Subscribe;
use App\Models\Tag;
use App\User;
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

        $users = User::all();
        foreach ($users as $key => $user) {
            $subscribe = Subscribe::where('writer', $user->id)->where('follower', $user->id)->first();
            if (is_null($subscribe)) {
                $subscribe = new Subscribe;
            }
            $subscribe->writer = $user->id;
            $subscribe->follower = $user->id;
            $subscribe->save();
        }
    }
}
