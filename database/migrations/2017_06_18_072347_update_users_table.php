<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['Root', 'Super Admin', 'Admin', 'Manager',
                                              'Sub Admin','Employee'])
                ->nullable();
            $table->string('username');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->integer('parent_id');
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
