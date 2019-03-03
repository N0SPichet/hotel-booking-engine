<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousepricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houseprices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price_perperson')->nullable();
            $table->integer('price')->nullable();
            $table->integer('food_price')->nullable();
            $table->integer('welcome_offer')->nullable();
            $table->integer('weekly_discount')->default('0');
            $table->integer('monthly_discount')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houseprices');
    }
}
