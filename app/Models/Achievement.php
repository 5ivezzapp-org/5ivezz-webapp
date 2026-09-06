<?php
// app/Models/Achievement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'team_id',
        'tournament_id',
        'match_id',
        'title',
        'description',
        'type',
        'category',
        'icon',
        'achieved_date',
        'status',
        'points',
    ];

    protected $casts = [
        'achieved_date' => 'datetime',
        'points' => 'integer',
    ];

    // Relationships
    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(Matches::class);
    }

    // Scopes
    public function scopeIndividual($query)
    {
        return $query->where('type', 'individual');
    }

    public function scopeTeam($query)
    {
        return $query->where('type', 'team');
    }

    public function scopeTournament($query)
    {
        return $query->where('type', 'tournament');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForPlayer($query, $playerId)
    {
        return $query->where('player_id', $playerId);
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopeForTournament($query, $tournamentId)
    {
        return $query->where('tournament_id', $tournamentId);
    }

    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Helper Methods
    public function getIconClass(): string
    {
        return match($this->icon) {
            'trophy' => '🏆',
            'gold' => '🥇',
            'silver' => '🥈',
            'bronze' => '🥉',
            'star' => '⭐',
            'medal' => '🎖️',
            'fire' => '🔥',
            'crown' => '👑',
            default => '🏅',
        };
    }

    public function isWinner(): bool
    {
        return $this->category === 'winner';
    }

    public function isGoldenBoot(): bool
    {
        return $this->category === 'golden_boot';
    }

    public function isBestPlayer(): bool
    {
        return $this->category === 'best_player';
    }
}