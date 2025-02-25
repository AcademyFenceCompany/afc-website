<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('category_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_category_id')->index();
            $table->string('title')->nullable();
            $table->string('subtitle', 500)->nullable();
            $table->text('bulletin_board')->nullable();
            $table->string('product_image')->nullable();
            $table->text('product_text')->nullable();
            $table->text('category_tidbit_1')->nullable();
            $table->text('category_tidbit_2')->nullable();
            $table->text('category_tidbit_3')->nullable();
            $table->string('footer_subtitle', 500)->nullable();
            $table->text('footer_bulletin_board')->nullable();
            $table->string('footer_product_image')->nullable();
            $table->text('footer_product_text')->nullable();
            $table->timestamps();

            $table->foreign('family_category_id')
                  ->references('id')
                  ->on('family_categories')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_pages');
    }
};
