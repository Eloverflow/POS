<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->json('taxes');
            $table->json('note_suggestions_command');
            $table->json('note_suggestions_command_line');
            $table->boolean('use_time_24');
            $table->string('language');
            $table->string('timezone');
            $table->boolean('daylight');
            $table->string('ipaddress');
            $table->boolean('use_email');
            $table->integer('plan_id')->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
        Schema::drop('settings');
    }
}
