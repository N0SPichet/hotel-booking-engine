<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddresscitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresscities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('city_name');
            $table->timestamps();
            $table->integer('addressstate_id')->unsigned();
            $table->foreign('addressstate_id')->references('id')->on('addressstates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresscities');
    }
}
