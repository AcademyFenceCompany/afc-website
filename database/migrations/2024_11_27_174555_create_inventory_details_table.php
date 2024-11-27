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
        Schema::create('inventory_details', function (Blueprint $table) {
            $table->id('inventory_details_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('in_stock_hq');
            $table->integer('in_stock_warehouse');
            $table->integer('inventory_ordered');
            $table->date('inventory_expected_date')->nullable();
            $table->foreign('product_id')->references('product_id')->on('products');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_details');
    }
};
