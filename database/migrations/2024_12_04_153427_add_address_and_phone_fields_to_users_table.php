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
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone')->nullable()->after('email');
        $table->string('street_address')->nullable()->after('phone');
        $table->string('city')->nullable()->after('street_address');
        $table->string('state')->nullable()->after('city');
        $table->string('zip')->nullable()->after('state');
        $table->string('additional_phone')->nullable()->after('zip');
        $table->string('billing_email')->nullable()->after('additional_phone');
        $table->text('delivery_address')->nullable()->after('billing_email');
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone',
            'street_address',
            'city',
            'state',
            'zip',
            'additional_phone',
            'billing_email',
            'delivery_address',
        ]);
    });
}

};
