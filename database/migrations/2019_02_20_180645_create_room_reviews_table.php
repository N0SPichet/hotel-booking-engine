<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('clean')->default(0)->nullable();
            $table->integer('amenity')->default(0)->nullable();
            $table->integer('service')->default(0)->nullable();
            $table->integer('host')->default(0)->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

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
        Schema::dropIfExists('room_reviews');
    }
}
