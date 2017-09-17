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
            $table->integer('agency_id')->nullable();
            $table->integer('customer_id');
            $table->enum('status',['Booked', 'Confirmed', 'Processed',
                         'Ready', 'Delivered', 'Cleared','Rejected','Cancelled']);
            $table->integer('visit_id');
            $table->dateTime('date_to_deliver');
            $table->integer('booked_by');
            $table->double('price');
            $table->double('discount');
            $table->enum('type', ['Query','Order']);
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
