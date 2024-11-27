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
        Schema::create('product_associations', function (Blueprint $table) {
            $table->id('product_associations_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('associated_product');
            $table->string('association_header')->nullable();
            $table->foreign('product_id')->references('product_id')->on('products');
            $table->foreign('associated_product')->references('product_id')->on('products');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_associations');
    }
};
