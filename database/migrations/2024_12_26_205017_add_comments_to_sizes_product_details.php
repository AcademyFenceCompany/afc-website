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
        Schema::table('product_details', function (Blueprint $table) {
            $table->string('size1')->comment("Length x Width | Post Caps: Cap Opening")->change();
            $table->string('size2')->comment("Welded Wire: Mesh Size | Post Caps: Nominal Post Size")->change();
            $table->string('size3')->comment("Welded Wire: Gauge Thickness")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_details', function (Blueprint $table) {
            //
        });
    }
};
