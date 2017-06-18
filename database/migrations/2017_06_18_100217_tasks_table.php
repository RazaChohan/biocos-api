<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('agency_id')->nullable();
                $table->integer('assignee_id');
                $table->string('description');
                $table->dateTime('date');
                $table->integer('order_id');
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
