<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRfidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfid_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->String('flash_card_hw_code');
            $table->String('items_id')->references('id')->on('items')->nullable();
            $table->String('name')->nullable();
            $table->String('description')->nullable();
            $table->String('slug')->nullable();
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
        Schema::drop('rfid_tables');
    }
}
