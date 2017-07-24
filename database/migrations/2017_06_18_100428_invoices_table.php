<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id')->nullable();
            $table->integer('order_id');
            $table->double('amount');
            $table->double('discounted_percentage');
            $table->enum('status', ['Pending', 'Cleared']);
            $table->double('debit_amount');
            $table->double('credit_amount');
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
