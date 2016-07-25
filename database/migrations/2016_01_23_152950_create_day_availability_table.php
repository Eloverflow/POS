<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_availability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('availability_id')->unsigned();
            $table->foreign('availability_id')->references('id')->on('availability');
            $table->integer('day_number')->unsigned();
            $table->time('startTime');
            $table->time('endTime');
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
        Schema::drop('day_availability');
    }
}
