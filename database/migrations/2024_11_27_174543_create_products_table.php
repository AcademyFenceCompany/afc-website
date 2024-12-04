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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->unsignedBigInteger('original_product_id');
            $table->string('product_name', length: 100);
            $table->string('item_no', length: 50);
            $table->decimal('price_per_unit', total: 8, places: 2);
            $table->boolean('shippable');
            $table->unsignedSmallInteger('family_category_id')->unsigned();
            $table->foreign('family_category_id')->references('family_category_id')->on('family_categories');
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
