<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
    }
}
