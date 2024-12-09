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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('family_category_id', 'subcategory_id');
            $table->foreign('subcategory_id')->references('family_category_id')->on('family_categories');
            $table->unsignedSmallInteger('family_category_id')->after('item_no');
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
        //
    }
};
