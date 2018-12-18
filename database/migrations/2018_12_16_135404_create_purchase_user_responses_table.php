<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseUserResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_user_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('issuerTranFee');
            $table->string('fromAccount');
            $table->integer('payment_response_id')->unsigned();
            $table->foreign('payment_response_id')->references('id')->on('payment_responses');
            $table->integer('purchase_user_id')->unsigned();
            $table->foreign('purchase_user_id')->references('id')->on('purchase_users');
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
        Schema::dropIfExists('purchase_user_responses');

    }
}
