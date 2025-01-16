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
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->string('order_origin')->nullable();
            $table->unsignedBigInteger('original_customer_order_id')->index()->nullable()->after('customer_order_id');
            $table->decimal('tax_amount', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('order_origin');
            $table->dropColumn('original_customer_order_id');
            $table->decimal('tax_amount', 8, 2)->nullable(false)->change();
        });
    }
};
