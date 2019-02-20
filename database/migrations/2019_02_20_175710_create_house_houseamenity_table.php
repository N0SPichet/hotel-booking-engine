<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseHouseamenityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_houseamenity', function (Blueprint $table) {
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->integer('houseamenity_id')->unsigned();
            $table->foreign('houseamenity_id')->references('id')->on('houseamenities')->onDelete('cascade');
            
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
        Schema::dropIfExists('house_houseamenity');
    }
}
