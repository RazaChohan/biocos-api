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
            $table->integer('agency_id')->nullable();
            $table->string('name');
            $table->string('product_code');
            $table->enum('category', ['Accessories', 'Color Cosmetics',
                                      'Body Care Cosmetics', 'Face Care Cosmetics']);
            $table->enum('type',['Soap', 'Face Wash', 'Cream','Serum']);
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
