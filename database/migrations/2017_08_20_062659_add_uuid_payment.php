<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUuidPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /***
         *  Add payment and uuid column in orders table
         */
        Schema::table('orders', function (Blueprint $table) {
            $table->double('payment')->after('discount')->nullable();
            $table->string('uuid')->after('id');
        });
        /***
         * Add uuid column in shops table
         */
        Schema::table('shops', function (Blueprint $table) {
            $table->string('uuid')->after('id');
        });
        /***
         * Add uuid column in regions table
         */
        Schema::table('regions', function (Blueprint $table) {
            $table->string('uuid')->after('id');
        });
        /***
         * Create Payment Received table
         */
        Schema::create('payment_received', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->boolean('is_success')->default(false);
            $table->string('remarks');
            $table->enum('payment_type', ['Promise', 'Cheque', 'Cash']);
            $table->double('amount');
            $table->date('promise_cheque_date')->nullable();
            $table->enum('cheque_type', ['Bearer Cheque', 'Order Cheque', 'Crossed Cheque',
                                                'Account Payee Cheque', 'Company Crossed Cheque',
                                                'Stale Cheque', 'Post Dated Cheque', 'Anti Dated Cheque'])
                  ->nullable();
            $table->string('cheque_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment', 'uuid']);
        });
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['uuid']);
        });
        Schema::table('regions', function (Blueprint $table) {
            $table->dropColumn(['uuid']);
        });
        Schema::drop('payment_received');
    }
}
