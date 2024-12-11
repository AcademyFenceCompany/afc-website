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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->unsignedBigInteger('original_customer_id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('company')->nullable();
            $table->string('phone', 25)->nullable(false);
            $table->string('phone_ext', 10)->nullable();
            $table->string('alt_phone', 25)->nullable();
            $table->string('alt_phone_ext', 10)->nullable();
            $table->string('fax', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
