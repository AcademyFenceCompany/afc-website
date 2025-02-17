<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAllOriginalProductIdNullable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable()->change();
        });

        Schema::table('product_media', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable()->change();
        });

        Schema::table('product_details', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable()->change();
        });

        Schema::table('shipping_details', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable(false)->change();
        });

        Schema::table('product_media', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable(false)->change();
        });

        Schema::table('product_details', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable(false)->change();
        });

        Schema::table('shipping_details', function (Blueprint $table) {
            $table->bigInteger('original_product_id')->nullable(false)->change();
        });
    }
}