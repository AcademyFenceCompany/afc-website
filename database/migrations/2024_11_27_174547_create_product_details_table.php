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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id('product_details_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('original_product_id');
            $table->string('size1')->nullable();
            $table->string('size2')->nullable();
            $table->string('size3')->nullable();
            $table->string('style')->nullable();
            $table->string('speciality')->nullable();
            $table->string('material')->nullable();
            $table->string('spacing')->nullable();
            $table->string('color')->nullable();
            $table->string('coating')->nullable();
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
        Schema::dropIfExists('product_details');
    }
};
