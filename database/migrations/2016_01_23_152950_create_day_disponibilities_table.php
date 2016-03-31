<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayDisponibilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_disponibilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disponibility_id')->unsigned();
            $table->foreign('disponibility_id')->references('id')->on('disponibilities');
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
        Schema::drop('day_disponibilities');
    }
}
