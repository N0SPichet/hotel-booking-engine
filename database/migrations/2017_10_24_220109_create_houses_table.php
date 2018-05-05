<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publish')->nullable();
            $table->string('house_title', 100)->nullable();
            $table->integer('house_capacity')->nullable();
            $table->string('house_property', 50)->nullable();
            $table->integer('no_rooms')->nullable();
            $table->string('house_guestspace', 50)->nullable();
            $table->integer('house_bedrooms')->nullable();
            $table->integer('house_beds')->nullable();
            $table->integer('house_bathroom')->nullable();
            $table->integer('house_bathroomprivate')->nullable();
            $table->string('house_address', 200)->nullable();
            $table->integer('house_postcode')->nullable();
            $table->text('house_description')->nullable();
            $table->text('about_your_place')->nullable();
            $table->text('guest_can_access')->nullable();
            $table->text('optional_note')->nullable();
            $table->text('optional_rules')->nullable();
            $table->text('about_neighborhood')->nullable();
            $table->string('cover_image', 100)->nullable();
            $table->timestamps();

            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('housetypes_id')->unsigned();
            $table->foreign('housetypes_id')->references('id')->on('housetypes')->onDelete('cascade');
            
            $table->integer('addresscities_id')->unsigned();
            $table->foreign('addresscities_id')->references('id')->on('addresscities')->onDelete('cascade');
            
            $table->integer('addressstates_id')->unsigned();
            $table->foreign('addressstates_id')->references('id')->on('addressstates')->onDelete('cascade');
            
            $table->integer('addresscountries_id')->unsigned();
            $table->foreign('addresscountries_id')->references('id')->on('addresscountries')->onDelete('cascade');
            
            $table->integer('guestarrives_id')->unsigned();
            $table->foreign('guestarrives_id')->references('id')->on('guestarrives')->onDelete('cascade');
            
            $table->integer('houseprices_id')->unsigned()->nullable();
            $table->foreign('houseprices_id')->references('id')->on('houseprices')->onDelete('cascade');
            
            $table->integer('foods_id')->unsigned()->nullable();
            $table->foreign('foods_id')->references('id')->on('foods')->onDelete('cascade');
            
            $table->integer('apartmentprices_id')->unsigned()->nullable();
            $table->foreign('apartmentprices_id')->references('id')->on('apartmentprices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
