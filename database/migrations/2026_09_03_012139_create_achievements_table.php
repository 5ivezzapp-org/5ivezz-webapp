<?php
// database/migrations/2024_01_01_000003_create_achievements_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('team_id')->nullable()->constrained('teams')->onDelete('set null');
            $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('match_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type'); // individual, team, tournament
            $table->string('category'); // winner, golden_boot, best_player, most_assists, fair_play, etc.
            $table->string('icon')->default('trophy');
            $table->datetime('achieved_date');
            $table->string('status')->default('active'); // active, archived
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('achievements');
    }
};