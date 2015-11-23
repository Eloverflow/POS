<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRfidRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfid_table_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('flash_card_hw_code')->references('flash_card_hw_code')->on('rfid_tables');
            $table->String('rfid_card_code');
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
        Schema::drop('rfid_table_requests');
    }
}
