<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->integer('agency_id')->nullable();
            $table->integer('region_id');
            $table->dateTime('date');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('reason');
            $table->time('time');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->enum('status', ['Pending', 'Completed', 'Postponed']);
            $table->dateTime('completed_on');
            $table->string('employee_location');
            $table->enum('visit_type', ['Visit', 'On Phone', 'On Email', 'Skype']);
            $table->string('comment');
            $table->integer('order');
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
