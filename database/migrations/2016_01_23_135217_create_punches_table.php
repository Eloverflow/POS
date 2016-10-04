<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePunchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punches', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('startTime');
            $table->dateTime('endTime')->nullable();
            $table->integer('work_title_id')->unsigned();
            $table->foreign('work_title_id')->references('id')->on('work_titles');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::drop('punches');
    }
}
