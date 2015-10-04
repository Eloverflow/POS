<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('civic_number')->nullable();
            $table->string('address')->nullable();
            $table->string('address_type')->nullable();
            $table->string('postal')->nullable();
            $table->string('city')->nullable();
            $table->string('region/state')->nullable();
            $table->string('country')->nullable();
            $table->string('address2')->nullable();
            $table->string('tips')->nullable();
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
        Schema::drop('suppliers');
    }
}
