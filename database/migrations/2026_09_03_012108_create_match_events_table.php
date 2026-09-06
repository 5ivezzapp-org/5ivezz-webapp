<?php
// database/migrations/2024_01_01_000002_create_match_events_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained()->onDelete('cascade');
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assist_player_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('event_type'); // goal, assist, yellow_card, red_card, substitution, penalty_missed, own_goal
            $table->integer('minute');
            $table->integer('second')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('confirmed'); // confirmed, pending, disputed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('match_events');
    }
};