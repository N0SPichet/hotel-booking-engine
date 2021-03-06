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
            $table->enum('host_decision', ['waiting', 'accept', 'reject'])->default('waiting');
            $table->date('rental_datein');
            $table->date('rental_dateout');
            
            $table->integer('rental_guest')->nullable();
            $table->integer('no_type_single')->nullable();
            $table->integer('type_single_price')->nullable();
            $table->integer('no_type_deluxe_single')->nullable();
            $table->integer('type_deluxe_single_price')->nullable();
            $table->integer('no_type_double_room')->nullable();
            $table->integer('type_double_room_price')->nullable();
            $table->integer('no_rooms')->nullable();
            $table->integer('room_price')->nullable();
            $table->enum('select_food', ['0', '1'])->default('0');
            $table->integer('discount')->default(0);
            $table->enum('checkin_status', ['0', '1'])->default('0');
            $table->string('checkincode', 50)->nullable();
            $table->integer('rental_checkroom')->default(0);
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('house_id')->unsigned();
            $table->foreign('house_id')->references('id')->on('houses')->onDelete('cascade');

            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
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
