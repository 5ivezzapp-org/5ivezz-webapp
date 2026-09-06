<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\User;
use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display the home page with all data.
     */
    public function index()
    {
        // Get featured player with stats
        $featuredPlayer = $this->getFeaturedPlayer();
        
        // Get featured tournament
        $featuredTournament = $this->getFeaturedTournament();
        
        // Get active tournaments
        $activeTournaments = $this->getActiveTournaments();
        
        // Get total stats for the platform
        $platformStats = $this->getPlatformStats();
        
        return view('welcome', compact(
            'featuredPlayer',
            'featuredTournament',
            'activeTournaments',
            'platformStats'
        ));
    }

    /**
     * Get featured player with real stats.
     */
    protected function getFeaturedPlayer()
    {
        // Try to get the top performing player
        $topPlayer = MatchEvent::where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->select('player_id', DB::raw('COUNT(*) as goals'))
            ->groupBy('player_id')
            ->orderBy('goals', 'desc')
            ->first();

        if ($topPlayer) {
            $user = User::with('team')->find($topPlayer->player_id);
            if ($user && $user->is_active) {
                // Get matches played
                $matches = MatchEvent::where('player_id', $user->id)
                    ->where('status', 'confirmed')
                    ->distinct('match_id')
                    ->count('match_id');
                
                // Get assists
                $assists = MatchEvent::where('assist_player_id', $user->id)
                    ->where('event_type', 'goal')
                    ->where('status', 'confirmed')
                    ->count();
                
                // Get position
                $position = $user->position ? strtoupper($user->position) : 'Player';
                $teamName = $user->team ? $user->team->name : 'Free Agent';
                
                return (object) [
                    'name' => $user->full_name,
                    'position' => $position,
                    'team' => $teamName,
                    'matches' => $matches,
                    'goals' => $topPlayer->goals,
                    'assists' => $assists,
                    'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : 
                        'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=80&background=0D9488&color=fff&bold=true'
                ];
            }
        }

        // Fallback: Get any active user
        $user = User::where('is_active', true)
            ->with('team')
            ->inRandomOrder()
            ->first();

        if ($user) {
            return (object) [
                'name' => $user->full_name,
                'position' => $user->position ? strtoupper($user->position) : 'Player',
                'team' => $user->team ? $user->team->name : 'Free Agent',
                'matches' => 0,
                'goals' => 0,
                'assists' => 0,
                'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : 
                    'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=80&background=0D9488&color=fff&bold=true'
            ];
        }

        // Ultimate fallback with dummy data
        return (object) [
            'name' => 'John Doe',
            'position' => 'Forward',
            'team' => 'Genesis FC',
            'matches' => 18,
            'goals' => 12,
            'assists' => 7,
            'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&size=80&background=0D9488&color=fff&bold=true'
        ];
    }

    /**
     * Get featured tournament.
     */
    protected function getFeaturedTournament()
    {
        // Get the most recent published or ongoing tournament
        $tournament = Tournament::whereIn('status', ['published', 'ongoing'])
            ->orderBy('created_at', 'desc')
            ->first();

        if ($tournament) {
            // Get teams count
            $teamsCount = $this->getTournamentTeamsCount($tournament);
            
            return (object) [
                'name' => $tournament->name,
                'status' => $tournament->status,
                'teams_count' => $teamsCount,
                'city' => $tournament->city,
                'state' => $tournament->state,
                'registration_fee' => $tournament->registration_fee,
                'winner_prize' => $tournament->winner_prize,
                'cover_image' => $tournament->cover_image ? asset('storage/' . $tournament->cover_image) : null
            ];
        }

        return null;
    }

    /**
     * Get active tournaments for display.
     */
    protected function getActiveTournaments()
    {
        // Get tournaments that are published or ongoing
        $tournaments = Tournament::whereIn('status', ['published', 'ongoing'])
            ->orderBy('tournament_start_date', 'asc')
            ->limit(6)
            ->get();

        $result = [];
        
        foreach ($tournaments as $tournament) {
            $teamsCount = $this->getTournamentTeamsCount($tournament);
            $maxTeams = $tournament->max_teams ?? 16;
            
            // Calculate status display
            $statusDisplay = $this->getTournamentStatusDisplay($tournament);
            
            $result[] = (object) [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'city' => $tournament->city,
                'state' => $tournament->state,
                'status' => $tournament->status,
                'status_display' => $statusDisplay['label'],
                'status_class' => $statusDisplay['class'],
                'teams_count' => $teamsCount,
                'max_teams' => $maxTeams,
                'winner_prize' => $tournament->winner_prize,
                'registration_fee' => $tournament->registration_fee,
                'cover_image' => $tournament->cover_image ? asset('storage/' . $tournament->cover_image) : null,
                'start_date' => $tournament->tournament_start_date,
                'end_date' => $tournament->tournament_end_date,
            ];
        }

        // Return collection even if empty
        return collect($result);
    }

    /**
     * Get the count of teams in a tournament.
     */
    protected function getTournamentTeamsCount($tournament)
    {
        // Get unique team IDs from matches
        $homeTeams = Matches::where('tournament_id', $tournament->id)
            ->distinct('home_team_id')
            ->pluck('home_team_id');
            
        $awayTeams = Matches::where('tournament_id', $tournament->id)
            ->distinct('away_team_id')
            ->pluck('away_team_id');
        
        $allTeamIds = $homeTeams->merge($awayTeams)->unique();
        
        return $allTeamIds->count();
    }

    /**
     * Get tournament status display information.
     */
    protected function getTournamentStatusDisplay($tournament)
    {
        $now = Carbon::now();
        
        if ($tournament->status === 'ongoing') {
            return ['label' => 'Live Now', 'class' => 'bg-secondary/90 backdrop-blur text-on-secondary'];
        }
        
        if ($tournament->status === 'published') {
            if ($tournament->registration_opens <= $now && $tournament->registration_closes >= $now) {
                return ['label' => 'Registering', 'class' => 'bg-primary/90 backdrop-blur text-on-primary'];
            }
            return ['label' => 'Upcoming', 'class' => 'bg-surface/90 backdrop-blur text-on-surface border border-outline-variant/30'];
        }
        
        if ($tournament->status === 'completed') {
            return ['label' => 'Completed', 'class' => 'bg-surface/90 backdrop-blur text-on-surface border border-outline-variant/30'];
        }
        
        return ['label' => ucfirst($tournament->status), 'class' => 'bg-surface/90 backdrop-blur text-on-surface border border-outline-variant/30'];
    }

    /**
     * Get platform statistics.
     */
    protected function getPlatformStats()
    {
        $totalPlayers = User::where('is_active', true)->count();
        $totalTeams = Team::where('status', 'active')->count();
        $totalTournaments = Tournament::whereIn('status', ['published', 'ongoing', 'completed'])->count();
        $totalMatches = Matches::where('status', 'completed')->count();
        
        // Calculate total goals
        $totalGoals = MatchEvent::where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->count();

        return (object) [
            'players' => $totalPlayers,
            'teams' => $totalTeams,
            'tournaments' => $totalTournaments,
            'matches' => $totalMatches,
            'goals' => $totalGoals,
        ];
    }
}