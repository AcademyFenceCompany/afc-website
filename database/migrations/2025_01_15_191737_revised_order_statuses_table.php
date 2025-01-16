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
        Schema::dropIfExists('order_status');

        // Create the new table with the updated schema
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->bigIncrements('order_statuses_id'); // Primary Key AI
            $table->unsignedBigInteger('original_customer_id')->index()->nullable();
            $table->unsignedBigInteger('customer_id')->nullable(); // Foreign Key
            $table->unsignedBigInteger('original_customer_order_id')->index()->nullable(); // Foreign Key
            $table->unsignedBigInteger('customer_order_id')->nullable(); // Foreign Key
            $table->dateTime('call_date')->nullable();
            $table->dateTime('quote_date')->nullable();
            $table->dateTime('sold_date')->nullable();
            $table->dateTime('customer_confirmed_date')->nullable();
            $table->dateTime('shipped_confirmed_date')->nullable();
            $table->string('processor', 255)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_statuses');
    }
};
