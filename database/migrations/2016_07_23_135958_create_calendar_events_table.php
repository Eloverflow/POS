<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->boolean("isAllDay");
            $table->enum('type', ['event', 'unavailability']);
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->integer('moment_type_id')->unsigned()->nullable();
            $table->foreign('moment_type_id')->references('id')->on('moment_types');
            $table->integer('employee_id')->unsigned()->nullable();
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
        Schema::drop('calendar_events');
    }
}
