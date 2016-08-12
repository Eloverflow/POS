<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('command_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('command_id')->unsigned();
            $table->foreign('command_id')->references('id')->on('commands');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->nullable();
            $table->string('size');
            $table->integer('quantity');
            $table->integer('status')->default(1);
            $table->integer('service_number')->nullable();
            $table->string('notes');
            $table->float('cost');
            $table->json('extras')->nullable();
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
        Schema::drop('command_lines');
    }
}
