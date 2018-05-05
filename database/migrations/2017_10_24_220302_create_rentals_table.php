<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host_decision', 50)->nullable();
            $table->date('rental_datein')->nullable();
            $table->date('rental_dateout')->nullable();
            $table->integer('rental_guest')->nullable();
            $table->integer('no_type_single')->nullable();
            $table->integer('type_single_price')->nullable();
            $table->integer('no_type_deluxe_single')->nullable();
            $table->integer('type_deluxe_single_price')->nullable();
            $table->integer('no_type_double_room')->nullable();
            $table->integer('type_double_room_price')->nullable();
            $table->integer('no_rooms')->nullable();
            $table->integer('inc_food')->default(0);
            $table->integer('discount')->default(0);
            $table->integer('checkin_status')->default(0);
            $table->string('checkincode', 50)->nullable();
            $table->integer('rental_checkroom')->default(0);
            $table->timestamps();

            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('houses_id')->unsigned();
            $table->foreign('houses_id')->references('id')->on('houses')->onDelete('cascade');

            $table->integer('payments_id')->unsigned();
            $table->foreign('payments_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
