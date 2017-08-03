<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('order_id');
        });
        Schema::create('product_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_images');
        Schema::drop('product_images');
    }
}
