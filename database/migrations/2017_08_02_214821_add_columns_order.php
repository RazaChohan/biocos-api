<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->time('delivery_time')->after('type')->nullable();
            $table->string('remarks')->after('delivery_time')->nullable();
            $table->double('latitude')->after('remarks')->nullable();
            $table->double('longitude')->after('latitude')->nullable();
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
            $table->dropColumn(['delivery_time', 'discount','remarks', 'latitude',
                                'longitude'])->nullable();
        });
    }
}
