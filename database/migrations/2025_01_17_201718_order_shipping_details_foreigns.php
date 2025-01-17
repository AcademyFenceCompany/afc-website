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
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->unsignedBigInteger('shipping_address_id')->index()->nullable();
            $table->unsignedBigInteger('order_id')->index()->nullable();
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
            $table->dropColumn('customer_id');
            $table->dropColumn('shipping_address_id');
            $table->dropColumn('order_id');
        });
    }
};
