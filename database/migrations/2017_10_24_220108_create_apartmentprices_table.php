<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentpricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartmentprices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_single')->nullable();
            $table->integer('single_price')->nullable();
            $table->integer('type_deluxe_single')->nullable();
            $table->integer('deluxe_single_price')->nullable();
            $table->integer('type_double_room')->nullable();
            $table->integer('double_price')->nullable();
            $table->integer('discount')->default('0');
            $table->integer('welcome_offer')->default('0');
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
        Schema::dropIfExists('apartmentprices');
    }
}
