<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBashairsResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Bashair_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CustomerName');
            $table->string('BashaerCardStatus')->nullable();

            $table->integer('Bashair_id')->nullable()->unsigned();
            $table->foreign('Bashair_id')->references('id')->on('Bashairs');
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
        Schema::dropIfExists('Bashair_responses');
    }
}
