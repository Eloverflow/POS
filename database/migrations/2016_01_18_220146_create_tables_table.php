<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tblNumber');
            $table->integer('noFloor');
            $table->integer('xPos');
            $table->integer('yPos');
            $table->string('angle');
            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans');

            $table->boolean('status');
            $table->integer('associated_employee_id')->nullable();/*
            $table->integer('associated_employee_id')->unsigned();
            $table->foreign('associated_employee_id')->references('id')->on('employees')->nullable();*/
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
        Schema::drop('tables');
    }
}
