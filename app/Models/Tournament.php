<?php
// app/Models/Tournament.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'name',
        'cover_image',
        'description',
        'category',
        'type',
        'edition',
        'organization_name',
        'phone_number',
        'email_address',
        'website_social',
        'registration_opens',
        'registration_closes',
        'tournament_start_date',
        'tournament_end_date',
        'venue_name',
        'venue_address',
        'city',
        'state',
        'country',
        'tournament_format',
        'number_of_teams',
        'max_players_per_team',
        'min_players_per_team',
        'registration_method',
        'registration_fee',
        'max_teams',
        'team_registration_deadline',
        'team_eligibility',
        'requires_manager_details',
        'requires_player_roster',
        'tournament_rules',
        'match_rules',
        'winner_prize',
        'runner_up_prize',
        'third_place_prize',
        'additional_prize_details',
        'status',
    ];

    protected $casts = [
        'registration_opens' => 'date',
        'registration_closes' => 'date',
        'tournament_start_date' => 'date',
        'tournament_end_date' => 'date',
        'team_registration_deadline' => 'date',
        'registration_fee' => 'decimal:2',
        'winner_prize' => 'decimal:2',
        'runner_up_prize' => 'decimal:2',
        'third_place_prize' => 'decimal:2',
        'requires_manager_details' => 'boolean',
        'requires_player_roster' => 'boolean',
    ];

    /**
     * Get all matches in this tournament.
     */
    public function matches(): HasMany
    {
        return $this->hasMany(Matches::class);
    }

    /**
     * Get all teams that have participated in this tournament (through matches).
     */
    public function participatingTeams()
    {
        return Team::whereIn('id', function ($query) {
            $query->select('home_team_id')
                ->from('matches')
                ->where('tournament_id', $this->id)
                ->union(
                    $query->newQuery()->select('away_team_id')
                        ->from('matches')
                        ->where('tournament_id', $this->id)
                );
        })->distinct();
    }

    /**
     * Get the count of teams in this tournament.
     */
    public function getTeamsCountAttribute()
    {
        return $this->participatingTeams()->count();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByOrganizer($query, $organizerId)
    {
        return $query->where('organizer_id', $organizerId);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tournament_start_date', '>=', now());
    }


    // Helper methods
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isRegistrationOpen(): bool
    {
        $now = now();
        return $now >= $this->registration_opens && $now <= $this->registration_closes;
    }

    /**
     * Get the status badge color for the tournament.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'draft' => 'bg-gray-100 text-gray-800',
            'published' => 'bg-blue-100 text-blue-800',
            'ongoing' => 'bg-green-100 text-green-800',
            'completed' => 'bg-purple-100 text-purple-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status display text.
     */
    public function getStatusDisplayText(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'published' => 'Registration Open',
            'ongoing' => 'Live Now',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }


    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    /**
     * Teams registered in this tournament.
     */
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'tournament_team')
            ->withPivot([
                'status', 'group', 'points', 'goals_for', 'goals_against',
                'matches_played', 'wins', 'draws', 'losses',
                'registered_by', 'registered_at', 'approved_at', 'notes'
            ])
            ->withTimestamps();
    }

    /**
     * Only approved teams.
     */
    public function approvedTeams(): BelongsToMany
    {
        return $this->teams()->wherePivot('status', 'approved');
    }

    /**
     * Only pending teams.
     */
    public function pendingTeams(): BelongsToMany
    {
        return $this->teams()->wherePivot('status', 'pending');
    }

    public function scopeOngoing($query)
    {
        return $query->where('tournament_start_date', '<=', now())
                    ->where('tournament_end_date', '>=', now());
    }

    public function canAcceptRegistrations(): bool
    {
        return $this->isPublished() 
            && $this->isRegistrationOpen() 
            && $this->approvedTeams()->count() < $this->max_teams;
    }

    public function teamsCount(): int
    {
        return $this->approvedTeams()->count();
    }


}