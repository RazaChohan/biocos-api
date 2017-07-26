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
            $table->enum('customer_type',['Wholesaler', 'Retail Saler', 'Distributer']);
            $table->enum('shop_type', ['Parlor', 'Doctor', 'Medical Store', 'Pan Shop', 'Super Store',
                                              'General Store', 'Cosmetics Shop', 'Tuk Shop at Fuel Station',
                                              'Mobiler', 'Homeopathic Store', 'Pansar Store', 'Super Market']);
            $table->enum('discount_percentage', ['Wholesaler', 'Retail Saler', 'Distributer']);
            $table->double('biocos_ratting');
            $table->integer('region_id');
            $table->enum('status', ['Approved', 'Pending', 'Rejected']);
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
