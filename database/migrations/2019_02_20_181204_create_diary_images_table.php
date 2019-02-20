<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiaryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diary_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 100)->nullable();
            $table->timestamps();

            $table->integer('diary_id')->unsigned();
            $table->foreign('diary_id')->references('id')->on('diaries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diary_images');
    }
}
