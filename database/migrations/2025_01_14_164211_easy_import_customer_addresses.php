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
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->string('address_1')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state')->nullable()->change();
            $table->string('zipcode', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_addresses', function (Blueprint $table) {
            $table->string('address_1')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state')->nullable(false)->change();
            $table->string('zipcode', 10)->nullable(false)->change();
        });
    }
};
