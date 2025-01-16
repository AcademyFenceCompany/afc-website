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
        // NOTE: after running migration, payment_method, and order_origin didnt show up in db
        // most likely bc of that Doctrine DBAL weakness when dealing with ENUM types.
        // Next customer_order migration will create these columns. Not changing code for laravel ease' sake.
        Schema::table('customer_orders', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('completion_date');
            $table->dropColumn('shipping_req_flag');
            $table->dropColumn('payment_method');
            $table->dropColumn('order_origin');

            $table->unsignedBigInteger('billing_address_id')->nullable()->change(); // Billing Address FK
            $table->unsignedBigInteger('shipping_address_id')->nullable()->change(); // Shipping Address FK
            $table->unsignedBigInteger('original_customer_id')->nullable()->change(); // Shipping Address FK
            $table->string('payment_method')->change()->nullable(); // Payment Methods - on frontend, limit selections to dropdown, instead of enum
            $table->decimal('subtotal', 8, 2)->nullable()->change(); // Subtotal
            $table->renameColumn('taxes', 'tax_amount')->nullable()->change(); // Taxes
            $table->decimal('discount_amount', 8, 2)->nullable()->change(); // Discount
            $table->decimal('total', 8, 2)->nullable()->change(); // Total
            $table->string('order_origin')->change()->nullable(); // Order Origin - on frontend, limit selections to dropdown, instead of enum
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
