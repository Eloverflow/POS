<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commands', function (Blueprint $table) {
            $table->increments('id');
            $table->string('note')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('command_number')->nullable();
            $table->integer('table_id')->unsigned();
            $table->foreign('table_id')->references('id')->on('tables')->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')->nullable();
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
        Schema::drop('commands');
    }
}
