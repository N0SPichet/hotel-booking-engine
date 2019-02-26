<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseHousedetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_housedetail', function (Blueprint $table) {
            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->integer('housedetail_id')->unsigned();
            $table->foreign('housedetail_id')->references('id')->on('housedetails')->onDelete('cascade');
            
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
        Schema::dropIfExists('house_housedetail');
    }
}
