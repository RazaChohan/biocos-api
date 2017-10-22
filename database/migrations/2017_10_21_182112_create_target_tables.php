<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTargetTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Create Target points table
        Schema::create('target_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('points');
        });
        //Create user_points table
        Schema::create('user_points', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('points');
            $table->dateTime('date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('target_points');
        Schema::drop('user_points');
    }
}
