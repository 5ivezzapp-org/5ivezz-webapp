<?php
// app/Models/Team.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'description',
        'location',
        'city',
        'state',
        'country',
        'captain_id',
        'organizer_id',
        'status',
        'invite_code',
        'wins',
        'draws',
        'losses',
        'total_matches',
        'max_players',
    ];

    protected $casts = [
        'wins' => 'integer',
        'draws' => 'integer',
        'losses' => 'integer',
        'total_matches' => 'integer',
        'max_players' => 'integer',
    ];

    // Boot method to generate slug and invite code
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($team) {
            $team->slug = Str::slug($team->name) . '-' . Str::random(5);
            $team->invite_code = strtoupper(Str::random(8));
        });
    }

    // Relationships
    public function captain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_player')
            ->withPivot('role', 'jersey_number', 'status', 'joined_at')
            ->withTimestamps();
    }

    // Accessors
    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=00595c&color=fff&size=100';
    }

    public function getCoverImageUrlAttribute(): string
    {
        return $this->cover_image
            ? asset('storage/' . $this->cover_image)
            : asset('images/default-cover.jpg');
    }

    public function getRecordAttribute(): array
    {
        return [
            'wins' => $this->wins,
            'draws' => $this->draws,
            'losses' => $this->losses,
            'total' => $this->total_matches,
            'win_rate' => $this->total_matches > 0
                ? round(($this->wins / $this->total_matches) * 100, 1)
                : 0,
        ];
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->status === 'active';
    }



    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'tournament_team')
            ->withPivot(['status', 'group', 'points', 'registered_at', 'approved_at'])
            ->withTimestamps();
    }

    /**
     * Players with active status only.
     */
    public function activePlayers()
    {
        return $this->belongsToMany(User::class, 'team_player')
            ->wherePivot('status', 'active')
            ->withPivot('role', 'jersey_number', 'status', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Pending join requests.
     */
    public function joinRequests()
    {
        return $this->belongsToMany(User::class, 'team_player')
            ->wherePivot('status', 'pending')
            ->withPivot('role', 'status', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Check if a user has a pending request.
     */
    public function hasPendingRequest(User $user): bool
    {
        return $this->players()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'pending')
            ->exists();
    }

    /**
     * Check if a user is an active member.
     */
    public function hasPlayer(User $user): bool
    {
        return $this->players()
            ->where('user_id', $user->id)
            ->wherePivot('status', 'active')
            ->exists();
    }

    /**
     * Check if a user is the captain.
     */
    public function isCaptain(User $user): bool
    {
        return $this->captain_id === $user->id;
    }

    /**
     * Check if team can accept more players.
     */
    public function canAddPlayer(): bool
    {
        return $this->activePlayers()->count() < $this->max_players;
    }
}