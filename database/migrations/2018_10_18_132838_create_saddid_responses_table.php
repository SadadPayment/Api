<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaddidResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saddid_responses', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('ServiceName');
//            $table->string('ServiceDetails');
//
//            $table->integer('saddid_id')->nullable()->unsigned();
//            $table->foreign('saddid_id')->references('id')->on('Saddids');
//            $table->integer('payment_response_id')->unsigned();
//            $table->foreign('payment_response_id')->references('id')->on('payment_responses');
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
        Schema::dropIfExists('saddid_responses');
    }
}
