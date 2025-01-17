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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->unsignedBigInteger('original_order_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedBigInteger('original_product_id')->index()->nullable();
            $table->integer('product_quantity')->nullable();
            $table->decimal('product_price_at_time_of_purchase', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
