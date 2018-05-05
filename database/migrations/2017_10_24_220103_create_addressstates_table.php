<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addressstates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('state_name');
            $table->timestamps();
            $table->integer('addresscountry_id')->unsigned();
            $table->foreign('addresscountry_id')->references('id')->on('addresscountries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addressstates');
    }
}
