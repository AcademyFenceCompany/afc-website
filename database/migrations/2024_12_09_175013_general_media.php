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
        Schema::table('general_media', function (Blueprint $table) {
            $table->unsignedSmallInteger('subcategory_id')->nullable();
            $table->string('style')->nullable();
            $table->string('size_portrayed')->nullable();
            $table->foreign('subcategory_id')->references('family_category_id')->on('family_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_media', function (Blueprint $table) {
            $table->dropColumn('subcategory_id');
            $table->dropColumn('style');
            $table->dropColumn('size_portrayed');
        });
    }
};
