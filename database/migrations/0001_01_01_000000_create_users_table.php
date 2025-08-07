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
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password', 255);
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone_number', 15)->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->string('avatar')->nullable();
            $table->integer('birth_year')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('school')->nullable();
            $table->string('city')->nullable();
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
            $table->boolean('banned')->default(0);
            $table->string('google2fa_secret')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('discord_id')->nullable();
            $table->string('github_id')->nullable();
            $table->timestamp('email_verified_at')->nullable(); // Thời gian xác thực email
            $table->string('verification_token')->nullable()->unique(); // Mã token xác thực email
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
