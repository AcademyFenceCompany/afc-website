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
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->id('customer_order_id'); // Primary Key
            $table->unsignedBigInteger('customer_id'); // Foreign Key
            $table->unsignedBigInteger('original_customer_id')->index(); // Nullable Foreign Key
            $table->date('start_date'); // Order Start Date
            $table->date('completion_date')->nullable(); // Nullable Completion Date
            $table->unsignedBigInteger('billing_address_id')->nullable(); // Billing Address FK
            $table->unsignedBigInteger('shipping_address_id')->nullable(); // Shipping Address FK
            $table->enum('payment_method', ['cash', 'credit_card', 'paypal']); // Payment Methods
            $table->decimal('subtotal', 8, 2); // Subtotal
            $table->decimal('taxes', 8, 2); // Taxes
            $table->decimal('discount_amount', 8, 2)->nullable(); // Discount
            $table->decimal('total', 8, 2); // Total
            $table->enum('order_origin', ['AFC Stock', 'AFC Make', 'AFC Acquire', 'Drop Ship']); // Order Origin
            $table->boolean('shipping_req_flag')->default(0); // This order is being shipped flag

            // // Define Foreign Key Constraints
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('billing_address_id')->references('customer_address_id')->on('customer_addresses')->onDelete('set null');
            $table->foreign('shipping_address_id')->references('customer_address_id')->on('customer_addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_orders');
    }
};
