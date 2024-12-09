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
        Schema::create('general_media', function (Blueprint $table) {
            $table->id('general_media_id');
            $table->unsignedSmallInteger('family_category_id')->nullable();
            $table->string('purpose')->nullable($value = false);
            $table->string('image')->nullable($value = false);
            $table->string('alt_text')->nullable();
            $table->foreign('family_category_id')->references('family_category_id')->on('family_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general_media');
    }
};
