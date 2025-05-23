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
            $table->dropColumn("address_type");
            $table->boolean("shipping_flag")->comment("This address can be used for shipping");
            $table->boolean("billing_flag")->comment("This address can be used for billing");
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
            $table->dropColumn("address_type");
            $table->dropColumn("shipping_flag");
            $table->dropColumn("billing_flag");
        });
    }
};
