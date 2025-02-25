<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_shipping_details', function (Blueprint $table) {
            $table->unsignedSmallInteger('total_order_weight')->nullable(true)->after('tracking_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_shipping_details', function (Blueprint $table) {
            $table->dropColumn('total_order_weight');
        });
    }
};
