<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBashairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //37 Page Ass Fuck *_^
    public function up()
    {
        Schema::create('Bashairs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ReferenceType');
            $table->string('ReferenceValue');

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
        Schema::dropIfExists('Bashairs');
    }
}
