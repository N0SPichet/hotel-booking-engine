<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_fname', 100)->nullable();
            $table->string('user_lname', 100)->nullable();
            $table->string('user_tel', 10)->nullable();
            $table->string('user_address', 100)->nullable();
            $table->integer('province_id')->unsigned()->nullable();
            $table->foreign('province_id')->references('id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('district_id')->unsigned()->nullable();
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('sub_district_id')->unsigned()->nullable();
            $table->foreign('sub_district_id')->references('id')->on('sub_districts')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('user_gender', ['1', '2'])->nullable();
            $table->text('user_description')->nullable();
            $table->float('user_score', 8, 2)->nullable();
            $table->string('user_image', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();

            $table->integer('user_verifications_id')->unsigned();
            $table->foreign('user_verifications_id')->references('id')->on('user_verifications')->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
