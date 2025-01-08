<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ams_users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->enum('level', ['Staff', 'Admin', 'God']);
            $table->boolean('enabled')->default(true);
            $table->timestamp('created')->useCurrent();
            $table->timestamp('lastlog')->nullable();
            $table->string('ip_filter')->nullable();
            $table->boolean('New')->default(true);
            $table->rememberToken();
            $table->index(['username', 'level']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('ams_users');
    }
};