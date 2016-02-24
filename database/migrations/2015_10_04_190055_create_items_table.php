<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_type_id')->unsigned();
            $table->foreign('item_type_id')->references('id')->on('item_types')->nullable();
            $table->string('img_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('customField1')->nullable();
            $table->string('customField2')->nullable();
            $table->string('customField3')->nullable();
            $table->string('customField4')->nullable();
            $table->string('customField5')->nullable();
            $table->string('customField6')->nullable();
            $table->string('customField7')->nullable();
            $table->string('customField8')->nullable();
            $table->string('customField9')->nullable();
            $table->string('customField10')->nullable();
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
        Schema::drop('items');
    }
}
