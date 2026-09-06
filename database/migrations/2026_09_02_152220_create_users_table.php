<?php
// database/migrations/2026_09_02_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('position')->nullable();
            $table->string('preferred_foot')->nullable();
            $table->text('bio')->nullable();
            $table->string('playing_level')->default('amateur');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('avatar')->nullable();
            $table->string('invite_code')->nullable();
            $table->foreignId('team_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->index(['email', 'team_id']);
            $table->index('playing_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};