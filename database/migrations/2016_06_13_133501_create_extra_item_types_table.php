<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_item_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('extra_id')->unsigned();
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->integer('item_type_id')->unsigned();
            $table->foreign('item_type_id')->references('id')->on('item_types')->onDelete('cascade');
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
        Schema::drop('extra_item_types');
    }
}
