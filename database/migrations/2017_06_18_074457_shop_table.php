<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id')->nullable();
            $table->string('name');
            $table->integer('proprietor_id');
            $table->integer('contact_person_id');
            $table->string('location');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->string('email');
            $table->enum('type',['wholesaler', 'Retail Saler']);
            $table->enum('industry', ['Super store', 'General store', 'Cosmetic Shops', 'Mobiler']);
            $table->enum('discount_percentage', ['wholesaler', 'retail saler ']);
            $table->double('biocos_ratting');
            $table->integer('region_id');
            $table->enum('status', ['approved', 'pending', 'rejected']);
            $table->enum('Category', ['A+', 'A', 'B', 'C', 'D']);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('deleted_by');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shop_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->integer('shop_id');
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
