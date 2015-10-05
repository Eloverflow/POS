<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemFieldListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_field_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('customs_fields_names')->nullable();
            $table->string('customs_field1')->nullable();
            $table->string('customs_field2')->nullable();
            $table->string('customs_field3')->nullable();
            $table->string('customs_field4')->nullable();
            $table->string('customs_field5')->nullable();
            $table->string('customs_field6')->nullable();
            $table->string('customs_field7')->nullable();
            $table->string('customs_field8')->nullable();
            $table->string('customs_field9')->nullable();
            $table->string('customs_field10')->nullable();
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
        Schema::drop('item_field_lists');
    }
}
