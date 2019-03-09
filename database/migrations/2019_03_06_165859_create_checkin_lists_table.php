<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckinListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkin_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('checkin_name');
            $table->string('checkin_lastname');
            $table->string('checkin_personal_id');
            $table->string('checkin_tel');
            $table->timestamps();
            $table->integer('rental_id')->unsigned();
            $table->foreign('rental_id')->references('id')->on('rentals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkin_lists');
    }
}
