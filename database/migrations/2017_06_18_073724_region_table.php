<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id')->nullable();
            $table->string('name');
            $table->string('city');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('country');
            $table->integer('parent_id');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('user_regions', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('region_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
