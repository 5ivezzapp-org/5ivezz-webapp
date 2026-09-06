<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'home_team_id',
        'away_team_id',
        'venue_name',
        'venue_address',
        'city',
        'state',
        'country',
        'match_datetime',
        'stage',
        'status',
        'home_score',
        'away_score',
        'winner',
        'match_report',
        'is_public',
    ];

    protected $casts = [
        'match_datetime' => 'datetime',
        'home_score' => 'integer',
        'away_score' => 'integer',
        'is_public' => 'boolean',
    ];

    // Relationships
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(MatchEvent::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(MatchEvent::class)->where('event_type', 'goal');
    }

    public function assists(): HasMany
    {
        return $this->hasMany(MatchEvent::class)->where('event_type', 'assist');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(MatchEvent::class)->whereIn('event_type', ['yellow_card', 'red_card']);
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeFinished($query)
    {
        return $query->where('status', 'finished');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('match_datetime', '>=', now())
            ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('match_datetime', '<', now())
            ->where('status', 'finished');
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where('home_team_id', $teamId)
            ->orWhere('away_team_id', $teamId);
    }

    public function scopeForTournament($query, $tournamentId)
    {
        return $query->where('tournament_id', $tournamentId);
    }

    // Helper Methods
    public function isHomeTeam($teamId): bool
    {
        return $this->home_team_id === $teamId;
    }

    public function isAwayTeam($teamId): bool
    {
        return $this->away_team_id === $teamId;
    }

    public function isTeamPlaying($teamId): bool
    {
        return $this->isHomeTeam($teamId) || $this->isAwayTeam($teamId);
    }

    public function getOpponent($teamId)
    {
        if ($this->home_team_id === $teamId) {
            return $this->awayTeam;
        }
        if ($this->away_team_id === $teamId) {
            return $this->homeTeam;
        }
        return null;
    }

    public function getScoreline(): string
    {
        if ($this->home_score === null || $this->away_score === null) {
            return 'vs';
        }
        return $this->home_score . ' - ' . $this->away_score;
    }

    public function isFinished(): bool
    {
        return $this->status === 'finished';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    public function isLive(): bool
    {
        return $this->status === 'live';
    }
}