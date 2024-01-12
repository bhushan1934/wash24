<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_no')->unique();
            $table->string('password')->nullable(); // Nullable because password might not be set initially for OTP-based auth
            $table->string('otp')->nullable(); // To store OTP
            $table->timestamp('otp_expires_at')->nullable(); // OTP expiry time
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
