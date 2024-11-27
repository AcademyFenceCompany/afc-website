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
        Schema::create('shipping_details', function (Blueprint $table) {
            $table->id('shipping_details_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('weight', 7, 2)->nullable();
            $table->decimal('shipping_length', 7, 2)->nullable();
            $table->decimal('shipping_width', 7, 2)->nullable();
            $table->decimal('shipping_height', 7, 2)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('shipping_details');
    }
};
