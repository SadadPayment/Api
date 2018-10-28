<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateE15ResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e15_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('e15_id')->unsigned();
            $table->foreign('e15_id')->references('id')->on('e15s');
            $table->integer('payment_response_id')->unsigned();
            $table->foreign('payment_response_id')->references('id')->on('payments');
            //	UnitName	ServiceName	TotalAmount	ReferenceId	PayerName
            $table->string('UnitName')->nullable;
            $table->string('ServiceName')->nullable;
            $table->string('TotalAmount')->nullable;
            $table->string('ReferenceId')->nullable;
            $table->string('PayerName')->nullable;
            $table->string('expiry')->nullable;
            $table->string('status')->nullable;
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
        Schema::dropIfExists('e15_responses');
    }
}
