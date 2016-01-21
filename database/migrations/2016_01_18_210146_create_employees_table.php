<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('streetAddress');
            $table->string('phone');
            $table->string('city');
            $table->string('state');
            $table->string('pc');
            $table->string('nas');
            $table->integer('employeeTitle')->unsigned();
            $table->foreign('employeeTitle')->references('id')->on('employee_titles');
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->references('id')->on('users');
            $table->decimal('salary');
            $table->date('birthDate');
            $table->date('hireDate');
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
        Schema::drop('employees');
    }
}
