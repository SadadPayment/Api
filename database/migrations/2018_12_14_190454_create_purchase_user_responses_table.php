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

            $table->integer('purchase_users_id')->nullable()->unsigned();
            $table->foreign('purchase_users_id')->references('id')->on('purchase_users');
            $table->integer('payment_response_id')->unsigned();
            $table->foreign('payment_response_id')->references('id')->on('payment_responses');

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
