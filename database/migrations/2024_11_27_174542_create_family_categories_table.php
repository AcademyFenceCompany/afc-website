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
        Schema::create('family_categories', function (Blueprint $table) {
            $table->unsignedSmallInteger('family_category_id')->autoIncrement();
            $table->string('family_category_name');
            $table->unsignedSmallInteger('parent_category_id')->nullable()->unsigned();
        });

        Schema::table('family_categories', function (Blueprint $table) {
            $table->foreign('parent_category_id')->references('family_category_id')->on('family_categories');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family_category');
    }
};
