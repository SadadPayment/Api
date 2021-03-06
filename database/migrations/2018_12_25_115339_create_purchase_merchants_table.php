<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_merchants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments');

            $table->integer('agent_id')->unsigned();
            $table->foreign('agent_id')->references('id')->on('agents');

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
        Schema::dropIfExists('purchase_merchants');
    }
}
