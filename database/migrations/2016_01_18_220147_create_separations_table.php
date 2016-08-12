<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeparationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('separations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('noFloor');
            $table->integer('xPos');
            $table->integer('yPos');
            $table->integer('w');
            $table->integer('h');
            $table->string('angle');
            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans');
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
        Schema::drop('separations');
    }
}
