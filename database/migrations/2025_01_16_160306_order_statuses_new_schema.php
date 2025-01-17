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
        Schema::dropIfExists('order_statuses');

        // Create the new table with the updated schema
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id('status_id');
            $table->unsignedBigInteger('order_id')->nullable(); // FOREIGN
            $table->unsignedBigInteger('original_order_id')->nullable()->index();
            $table->string('status')->nullable();
            $table->unsignedSmallInteger('processor_id')->nullable();
            $table->unsignedSmallInteger('original_processor_id')->nullable()->index();
            $table->dateTime('status_date')->nullable();
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
