<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('verify', ['1', '0'])->default('0');
            $table->string('title', 50)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('lastname', 100)->nullable();
            $table->string('id_card', 100)->nullable();
            $table->string('census_registration', 100)->nullable();
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
        Schema::dropIfExists('user_verifications');
    }
}
