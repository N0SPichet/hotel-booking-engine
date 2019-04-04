<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payment_bankname', 50)->nullable();
            $table->string('payment_bankaccount', 50)->nullable();
            $table->string('payment_holder', 50)->nullable();
            $table->string('payment_transfer_slip', 50)->nullable();
            $table->enum('payment_status', ['Approved', 'Cancel', 'Out of Date', 'Waiting', 'Reject'])->nullable();
            $table->integer('payment_amount')->nullable();
            $table->string('payment_type')->default('normal_transection');
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
        Schema::dropIfExists('payments');
    }
}
