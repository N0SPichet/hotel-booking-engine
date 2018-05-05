<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('map_name', 100)->nullable();
            $table->float('map_lat', 20, 18)->nullable();
            $table->float('map_lng', 20, 18)->nullable();
            $table->timestamps();
            $table->integer('houses_id')->unsigned()->nullable();
            $table->foreign('houses_id')->references('id')->on('houses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maps');
    }
}
