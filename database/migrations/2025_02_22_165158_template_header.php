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
        Schema::create('template_header', function (Blueprint $table) {
            $table->id("id");
            $table->unsignedBigInteger("family_category_id")->index()->null(false);
            $table->string("title")->null();
            $table->string("subtitle", 500)->null();
            $table->text("bulletin_board")->null();
            $table->string("product_image")->null();
            $table->text("product_text")->null();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('template_header');
    }
};
