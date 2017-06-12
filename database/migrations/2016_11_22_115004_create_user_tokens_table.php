<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tokens', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('token');
            $table->enum('status', ['active','unactive']);
            $table->timestamp('issue_date');
            $table->timestamp('expiry');
            $table->string('device');
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
        Schema::dropIfExists('user_tokens');
    }
}

