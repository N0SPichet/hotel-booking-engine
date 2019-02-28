<?php

use App\Models\Category;
use App\Models\Tag;
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
        	$cat = new Category;
        	$cat->name = "cat ".$i;
        	$cat->save();
        }

        for ($i = 1; $i <= 10 ; $i++) { 
            $tag = new Tag;
            $tag->name = "tag ".$i;
            $tag->save();
        }
    }
}
