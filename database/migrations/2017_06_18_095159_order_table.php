<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');
            $table->enum('status',['booked', 'confirmed', 'processed',
                         'ready', 'delivered', 'cleared']);
            $table->integer('visit_id');
            $table->dateTime('date_to_deliver');
            $table->integer('booked_by');
            $table->double('price');
            $table->double('discount');
            $table->enum('type', ['query','order']);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('order_products', function (Blueprint $table) {
            $table->integer('order_id');
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
        //
    }
}
