<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tranCurrency');
            $table->string('tranAmount');
            $table->string('PAN');
            $table->integer('payment_id')->nullable()->unsigned();
            $table->foreign('payment_id')->references('id')->on('payments');
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
        Schema::dropIfExists('purchase_users');
    }
}
