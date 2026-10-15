<?php
// app/Models/Organizer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this import
use DB;
class Organizer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'organizer';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password',
        'company_name',
        'state',
        'city',
        'cac_document',
        'company_logo',
        'terms_accepted',
        'verification_status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'terms_accepted' => 'boolean',
    ];

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    // Helper methods
    public function isVerified(): bool
    {
        return $this->verification_status === 'verified';
    }

    public function isPending(): bool
    {
        return $this->verification_status === 'pending';
    }

    public function isRejected(): bool
    {
        return $this->verification_status === 'rejected';
    }

    public function hasVerifiedEmail(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    // Remove the return type or use the full namespace
    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }



    /**
     * Aggregate profile stats for the organizer profile page.
     */
    public function profileStats(): array
    {
        $tournamentIds = $this->tournaments()->pluck('id');

        return [
            'total_tournaments' => $this->tournaments()->count(),
            'published_tournaments' => $this->tournaments()->where('status', 'published')->count(),
            'ongoing_tournaments' => $this->tournaments()->where('status', 'ongoing')->count(),
            'completed_tournaments' => $this->tournaments()->where('status', 'completed')->count(),
            'draft_tournaments' => $this->tournaments()->where('status', 'draft')->count(),
            'total_teams' => DB::table('tournament_team')
                ->whereIn('tournament_id', $tournamentIds)
                ->where('status', 'approved')
                ->distinct('team_id')
                ->count('team_id'),
            'total_players' => User::whereHas('team', function ($q) use ($tournamentIds) {
                $q->whereIn('teams.id', function ($sub) use ($tournamentIds) {
                    $sub->select('team_id')
                        ->from('tournament_team')
                        ->whereIn('tournament_id', $tournamentIds)
                        ->where('status', 'approved');
                });
            })->count(),
            'pending_requests' => DB::table('tournament_team')
                ->whereIn('tournament_id', $tournamentIds)
                ->where('status', 'pending')
                ->count(),
            'total_matches' => \App\Models\Matches::whereIn('tournament_id', $tournamentIds)->count(),
            'completed_matches' => \App\Models\Matches::whereIn('tournament_id', $tournamentIds)
                ->where('status', 'completed')->count(),
        ];
    }

}