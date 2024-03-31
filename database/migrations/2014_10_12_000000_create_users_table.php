<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone_code');
            $table->string('phone')->unique();
            $table->string('image')->nullable();
            $table->integer('otp')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->text('address')->nullable();
            $table->text('rider_note')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
