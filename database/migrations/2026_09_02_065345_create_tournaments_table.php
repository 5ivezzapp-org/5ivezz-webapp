<?php
// database/migrations/2026_09_02_000000_create_tournaments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            
            // Change this from user_id to organizer_id
            $table->foreignId('organizer_id')
                  ->constrained('organizers')  // Specify the organizers table
                  ->onDelete('cascade');

            // Tournament Information
            $table->string('name');
            $table->string('cover_image')->nullable();
            $table->text('description');
            $table->string('category');
            $table->string('type');
            $table->string('edition')->nullable();

            // Organizer Information
            $table->string('organization_name');
            $table->string('phone_number');
            $table->string('email_address');
            $table->string('website_social')->nullable();

            // Date & Location
            $table->date('registration_opens');
            $table->date('registration_closes');
            $table->date('tournament_start_date');
            $table->date('tournament_end_date');
            $table->string('venue_name');
            $table->string('venue_address');
            $table->string('city');
            $table->string('state');
            $table->string('country');

            // Competition Format
            $table->string('tournament_format');
            $table->integer('number_of_teams');
            $table->integer('max_players_per_team');
            $table->integer('min_players_per_team');

            // Team Registration
            $table->string('registration_method');
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->integer('max_teams');
            $table->date('team_registration_deadline');
            $table->text('team_eligibility')->nullable();
            $table->boolean('requires_manager_details')->default(true);
            $table->boolean('requires_player_roster')->default(true);

            // Tournament Rules
            $table->text('tournament_rules')->nullable();
            $table->text('match_rules')->nullable();

            // Prize & Awards
            $table->decimal('winner_prize', 10, 2)->nullable();
            $table->decimal('runner_up_prize', 10, 2)->nullable();
            $table->decimal('third_place_prize', 10, 2)->nullable();
            $table->text('additional_prize_details')->nullable();

            // Status
            $table->enum('status', ['draft', 'published', 'ongoing', 'completed', 'cancelled'])->default('draft');

            $table->timestamps();

            // Indexes - update to use organizer_id
            $table->index(['organizer_id', 'status']);
            $table->index(['tournament_start_date', 'tournament_end_date']);
            $table->index('category');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};