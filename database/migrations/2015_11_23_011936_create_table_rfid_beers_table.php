<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRfidBeersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfid_table_beers', function (Blueprint $table) {
            $table->increments('id');
            $table->String('flash_card_hw_code')->references('flash_card_hw_code')->on('rfid_tables')->nullable();
            $table->String('img_url');
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
        Schema::drop('rfid_table_beers');
    }
}
