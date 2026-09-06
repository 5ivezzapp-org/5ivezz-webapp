<?php
// app/Models/MatchEvent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'team_id',
        'player_id',
        'assist_player_id',
        'event_type',
        'minute',
        'second',
        'description',
        'status',
    ];

    protected $casts = [
        'minute' => 'integer',
        'second' => 'integer',
    ];

    // Relationships
    public function match(): BelongsTo
    {
        return $this->belongsTo(Matches::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assistPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assist_player_id');
    }

    // Scopes
    public function scopeGoals($query)
    {
        return $query->where('event_type', 'goal');
    }

    public function scopeAssists($query)
    {
        return $query->where('event_type', 'assist');
    }

    public function scopeCards($query)
    {
        return $query->whereIn('event_type', ['yellow_card', 'red_card']);
    }

    public function scopeYellowCards($query)
    {
        return $query->where('event_type', 'yellow_card');
    }

    public function scopeRedCards($query)
    {
        return $query->where('event_type', 'red_card');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeForPlayer($query, $playerId)
    {
        return $query->where('player_id', $playerId);
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    // Helper Methods
    public function isGoal(): bool
    {
        return $this->event_type === 'goal';
    }

    public function isAssist(): bool
    {
        return $this->event_type === 'assist';
    }

    public function isCard(): bool
    {
        return in_array($this->event_type, ['yellow_card', 'red_card']);
    }

    public function isYellowCard(): bool
    {
        return $this->event_type === 'yellow_card';
    }

    public function isRedCard(): bool
    {
        return $this->event_type === 'red_card';
    }

    public function getEventIcon(): string
    {
        return match($this->event_type) {
            'goal' => '⚽',
            'assist' => '🅰️',
            'yellow_card' => '🟨',
            'red_card' => '🟥',
            'substitution' => '🔄',
            'penalty_missed' => '❌',
            'own_goal' => '😅',
            default => '📊',
        };
    }
}