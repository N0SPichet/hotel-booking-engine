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
            $table->enum('publish', ['0', '1', '2', '3'])->default(0);
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

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('housetype_id')->unsigned();
            $table->foreign('housetype_id')->references('id')->on('housetypes')->onDelete('cascade');
            
            $table->integer('sub_district_id')->unsigned();
            $table->foreign('sub_district_id')->references('id')->on('sub_districts')
                            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')
                            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')
                ->onUpdate('cascade')->onDelete('cascade');
            
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
