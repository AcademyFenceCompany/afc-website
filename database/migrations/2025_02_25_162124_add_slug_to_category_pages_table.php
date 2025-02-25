<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_pages', function (Blueprint $table) {
            $table->string('slug')->after('family_category_id')->nullable();
        });

        // Generate slugs for existing records
        DB::table('category_pages')
            ->join('family_categories', 'category_pages.family_category_id', '=', 'family_categories.family_category_id')
            ->select('category_pages.id', 'family_categories.family_category_name')
            ->get()
            ->each(function ($page) {
                DB::table('category_pages')
                    ->where('id', $page->id)
                    ->update(['slug' => Str::slug($page->family_category_name)]);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_pages', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
