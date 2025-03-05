<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('category_pages', function (Blueprint $table) {
            $table->string('menu_type')->nullable()->after('template')->comment('main_menu, quick_menu');
            $table->integer('menu_order')->default(0)->after('menu_type');
        });
    }

    public function down()
    {
        Schema::table('category_pages', function (Blueprint $table) {
            $table->dropColumn(['menu_type', 'menu_order']);
        });
    }
};
