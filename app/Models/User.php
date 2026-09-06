<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'position',
        'preferred_foot',
        'bio',
        'playing_level',
        'state',
        'city',
        'avatar',
        'invite_code',
        'team_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_player')
                    ->withPivot('role', 'jersey_number', 'status', 'joined_at')
                    ->withTimestamps();
    }

    public function captainOf(): HasMany
    {
        return $this->hasMany(Team::class, 'captain_id');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar) 
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=00595c&color=fff&size=100';
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function hasTeam(): bool
    {
        return !is_null($this->team_id);
    }

    public function isCaptainOf(Team $team): bool
    {
        return $this->id === $team->captain_id;
    }
}