<?php
// database/migrations/2026_09_02_000001_create_teams_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->foreignId('captain_id')->nullable();
            $table->foreignId('organizer_id')->nullable()->constrained('organizers')->nullOnDelete();
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->string('invite_code')->unique();
            $table->integer('wins')->default(0);
            $table->integer('draws')->default(0);
            $table->integer('losses')->default(0);
            $table->integer('total_matches')->default(0);
            $table->integer('max_players')->default(25);
            $table->timestamps();

            $table->index(['city', 'state']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};