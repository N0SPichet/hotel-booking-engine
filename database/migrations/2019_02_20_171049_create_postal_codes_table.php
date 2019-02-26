<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostalCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code');
            $table->integer('sub_district_id')->unsigned();
            $table->foreign('sub_district_id')->references('id')->on('sub_districts')
                            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('district_id')->unsigned();
            $table->foreign('district_id')->references('id')->on('districts')
                            ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('province_id')->unsigned();
            $table->foreign('province_id')->references('id')->on('provinces')
                            ->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('postal_codes');
    }
}
