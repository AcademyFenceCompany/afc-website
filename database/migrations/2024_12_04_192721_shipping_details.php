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
        Schema::table('shipping_details', function (Blueprint $table) {
            $table->boolean('free_shipping')->nullable($value = true);
            $table->boolean('special_shipping')->nullable($value = true);
            $table->unsignedSmallInteger('amount_per_box')->nullable($value = true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_details', function (Blueprint $table) {
            $table->dropColumn('free_shipping');
            $table->dropColumn('special_shipping');
            $table->dropColumn('amount_per_box');
        });
    }
};
