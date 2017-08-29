<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserRegions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /***
         *  Add date column in user_regions table
         */
        Schema::table('user_regions', function (Blueprint $table) {
            $table->increments('id')->before('user_id');
            $table->time('execution_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_regions', function (Blueprint $table) {
            $table->dropColumn(['id', 'execution_time']);
        });
    }
}
