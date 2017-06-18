<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('product_code');
            $table->enum('category', ['accessories', 'color cosmetics',
                                      'body care cosmetics', 'face care cosmetics']);
            $table->enum('type',['soap', 'face wash', 'cream','serum']);
            $table->double('retail_price');
            $table->double('wholesale_price');
            $table->double('distributor_price');
            $table->integer('stock_available');
            $table->dateTime('started_on');
            $table->dateTime('discontinued_on');
            $table->string('description');
            $table->integer('minimum_order_unit');
            $table->integer('minimum_ws_quantity');
            $table->integer('minimum_rs_quantity');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
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
