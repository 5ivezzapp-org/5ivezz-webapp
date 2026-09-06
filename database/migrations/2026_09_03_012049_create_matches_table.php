<?php
// database/migrations/2024_01_01_000001_create_matches_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');
            $table->string('venue_name');
            $table->string('venue_address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('Nigeria');
            $table->datetime('match_datetime');
            $table->string('stage')->default('group_stage'); // group_stage, quarter_final, semi_final, final, friendly
            $table->string('status')->default('scheduled'); // scheduled, live, finished, cancelled, postponed
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->string('winner')->nullable(); // home, away, draw
            $table->text('match_report')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
};