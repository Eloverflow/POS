<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    /**
     *Lead to a type beer, or drink for example
     * � v�rifier
     *
     * Model name based on field type
    */
    public function up()
    {
        Schema::create('item_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_names')->nullable();
            $table->string('size_names')->nullable();
            $table->json('quantity_reducer')->nullable();
            $table->string('type');
            $table->string('slug')->unique();
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
        Schema::drop('item_types');
    }
}
