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
        Schema::create('order_shipping_details', function (Blueprint $table) {
            $table->id('shipping_details_id'); // Primary Key
            $table->unsignedBigInteger('customer_id'); // FK to customers
            $table->unsignedBigInteger('customer_address_id'); // FK to addresses
            $table->unsignedBigInteger('customer_order_id'); // FK to orders
            $table->string('carrier', 255); // Shipping carrier
            $table->string('status', 255)->nullable(); // Shipping status
            $table->string('tracking_no', 255)->nullable(); // Tracking number
            $table->decimal('order_weight', 7, 2)->nullable(); // Order weight
            $table->decimal('shipping_cost', 8, 2); // Shipping cost
            $table->string('address_contact', 255)->nullable(); // Contact for shipping address

            // Define Foreign Key Constraints
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_address_id')->references('customer_address_id')->on('customer_addresses')->onDelete('cascade');
            $table->foreign('customer_order_id')->references('customer_order_id')->on('customer_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_shipping_details');
    }
};
