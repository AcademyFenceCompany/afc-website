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
        Schema::create('order_status', function (Blueprint $table) {
            $table->id('order_status_id'); // Primary Key
            $table->unsignedBigInteger('customer_id'); // FK to customers
            $table->unsignedBigInteger('customer_order_id'); // FK to orders
            $table->enum('status', ['Called', 'Quoted', 'Processed', 'Completed', 'Cancelled']); // Status ENUM
            $table->string('processor', 255); // Order Taker
            $table->dateTime('date'); // Status change date 

            // Define Foreign Key Constraints
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            // $table->foreign('customer_order_id')->references('customer_order_id')->on('customer_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status');
    }
};
