<?php
// app/Http/Controllers/ExploreController.php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\User;
use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExploreController extends Controller
{
    /**
     * Display the explore page with all data.
     */
    public function index(Request $request)
    {
        // Get search term from request
        $searchTerm = $request->get('search', '');
        
        // Get featured tournament
        $featuredTournament = $this->getFeaturedTournament();

        // Get featured player
        $featuredPlayer = $this->getFeaturedPlayer();

        // Get tournaments based on category filter
        $tournaments = $this->getTournaments($request);

        // Get featured players
        $players = $this->getFeaturedPlayers($request);

        // Get teams
        $teams = $this->getTeams($request);

        // Get search results if search term is provided
        $searchResults = null;
        if ($request->has('search') && !empty($searchTerm)) {
            $searchResults = $this->searchAll($searchTerm);
        }

        // Get category filter
        $category = $request->get('category', 'all');

        return view('explore.index', compact(
            'featuredTournament',
            'featuredPlayer',
            'tournaments',
            'players',
            'teams',
            'searchResults',
            'category',
            'searchTerm' // Add this line
        ));
    }


    /**
     * Get featured tournament.
     */
    protected function getFeaturedTournament()
    {
        // Get the most recent published or ongoing tournament
        return Tournament::whereIn('status', ['published', 'ongoing'])
            ->withCount('teams as teams_count')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get featured player.
     */
    protected function getFeaturedPlayer()
    {
        // Get player with most goals or highest rating
        $playerId = MatchEvent::where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->select('player_id', DB::raw('COUNT(*) as goals'))
            ->groupBy('player_id')
            ->orderBy('goals', 'desc')
            ->first();

        if ($playerId) {
            $user = User::with('team')->find($playerId->player_id);
            if ($user) {
                // Calculate stats
                $goals = MatchEvent::where('player_id', $user->id)
                    ->where('event_type', 'goal')
                    ->where('status', 'confirmed')
                    ->count();

                $matches = MatchEvent::where('player_id', $user->id)
                    ->where('status', 'confirmed')
                    ->distinct('match_id')
                    ->count('match_id');

                $user->goals = $goals;
                $user->matches = $matches;
                $user->avatar_url = $user->avatar ? asset('storage/' . $user->avatar) :
                    'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=200&background=0D9488&color=fff&bold=true';

                return $user;
            }
        }

        // Fallback: Get any active player
        $user = User::where('is_active', true)
            ->with('team')
            ->inRandomOrder()
            ->first();

        if ($user) {
            $user->goals = 0;
            $user->matches = 0;
            $user->avatar_url = $user->avatar ? asset('storage/' . $user->avatar) :
                'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=200&background=0D9488&color=fff&bold=true';
        }

        return $user;
    }

    /**
     * Get tournaments.
     */
    protected function getTournaments(Request $request)
    {
        $query = Tournament::where('status', '!=', 'draft')
            ->withCount('teams as teams_count')
            ->orderBy('tournament_start_date', 'asc');

        // Filter by search term
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return $query->limit(6)->get();
    }

    /**
     * Get featured players.
     */
    protected function getFeaturedPlayers(Request $request)
    {
        // Get top players based on goals
        $topPlayers = MatchEvent::where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->select('player_id', DB::raw('COUNT(*) as goals'))
            ->groupBy('player_id')
            ->orderBy('goals', 'desc')
            ->limit(6)
            ->get();

        $players = collect();

        foreach ($topPlayers as $topPlayer) {
            $user = User::with('team')->find($topPlayer->player_id);
            if ($user && $user->is_active) {
                $matches = MatchEvent::where('player_id', $user->id)
                    ->where('status', 'confirmed')
                    ->distinct('match_id')
                    ->count('match_id');

                $assists = MatchEvent::where('assist_player_id', $user->id)
                    ->where('event_type', 'goal')
                    ->where('status', 'confirmed')
                    ->count();

                $user->goals = $topPlayer->goals;
                $user->matches = $matches;
                $user->assists = $assists;
                $user->avatar_url = $user->avatar ? asset('storage/' . $user->avatar) :
                    'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=200&background=0D9488&color=fff&bold=true';
                $user->position_display = $user->position ? strtoupper($user->position) : 'N/A';
                $user->team_name = $user->team ? $user->team->name : 'Free Agent';

                $players->push($user);
            }
        }

        // If no players with goals, get any active players
        if ($players->isEmpty()) {
            $users = User::where('is_active', true)
                ->with('team')
                ->inRandomOrder()
                ->limit(6)
                ->get();

            foreach ($users as $user) {
                $user->goals = 0;
                $user->matches = 0;
                $user->assists = 0;
                $user->avatar_url = $user->avatar ? asset('storage/' . $user->avatar) :
                    'https://ui-avatars.com/api/?name=' . urlencode($user->full_name) . '&size=200&background=0D9488&color=fff&bold=true';
                $user->position_display = $user->position ? strtoupper($user->position) : 'N/A';
                $user->team_name = $user->team ? $user->team->name : 'Free Agent';
                $players->push($user);
            }
        }

        return $players;
    }

    /**
     * Get teams.
     */
    protected function getTeams(Request $request)
    {
        $query = Team::where('status', 'active')
            ->withCount('players')
            ->with([
                'players' => function ($query) {
                    $query->wherePivot('status', 'active')->limit(5);
                }
            ])
            ->orderBy('created_at', 'desc');

        // Filter by search term
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $teams = $query->limit(6)->get();

        // Add logo URL and player avatars
        foreach ($teams as $team) {
            $team->logo_url = $team->logo ? asset('storage/' . $team->logo) :
                'https://ui-avatars.com/api/?name=' . urlencode($team->name) . '&size=80&background=00595c&color=fff&bold=true';

            // Get recent form
            $team->form = $this->getTeamForm($team);

            // Get team stats
            $stats = $this->getTeamStats($team);
            $team->wins = $stats->wins;
            $team->draws = $stats->draws;
            $team->losses = $stats->losses;
        }

        return $teams;
    }

    /**
     * Get team form (last 5 results).
     */
    protected function getTeamForm($team)
    {
        $matches = Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'desc')
            ->limit(5)
            ->get();

        $form = [];
        foreach ($matches as $match) {
            if ($match->home_team_id == $team->id) {
                if ($match->home_score > $match->away_score) {
                    $form[] = 'W';
                } elseif ($match->home_score < $match->away_score) {
                    $form[] = 'L';
                } else {
                    $form[] = 'D';
                }
            } else {
                if ($match->away_score > $match->home_score) {
                    $form[] = 'W';
                } elseif ($match->away_score < $match->home_score) {
                    $form[] = 'L';
                } else {
                    $form[] = 'D';
                }
            }
        }

        return implode('-', $form) ?: 'N/A';
    }

    /**
     * Get team statistics.
     */
    protected function getTeamStats($team)
    {
        $matches = Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('status', 'completed')
            ->get();

        $wins = 0;
        $losses = 0;
        $draws = 0;

        foreach ($matches as $match) {
            if ($match->home_team_id == $team->id) {
                if ($match->home_score > $match->away_score) {
                    $wins++;
                } elseif ($match->home_score < $match->away_score) {
                    $losses++;
                } else {
                    $draws++;
                }
            } else {
                if ($match->away_score > $match->home_score) {
                    $wins++;
                } elseif ($match->away_score < $match->home_score) {
                    $losses++;
                } else {
                    $draws++;
                }
            }
        }

        return (object) ['wins' => $wins, 'draws' => $draws, 'losses' => $losses];
    }

    /**
     * Search across all entities.
     */
    protected function searchAll($term)
    {
        $results = (object) [
            'tournaments' => Tournament::where('name', 'LIKE', '%' . $term . '%')
                ->where('status', '!=', 'draft')
                ->limit(3)
                ->get(),

            'teams' => Team::where('name', 'LIKE', '%' . $term . '%')
                ->where('status', 'active')
                ->withCount('players')
                ->limit(3)
                ->get(),

            'players' => User::where(function ($query) use ($term) {
                $query->where('first_name', 'LIKE', '%' . $term . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $term . '%')
                    ->orWhere('email', 'LIKE', '%' . $term . '%');
            })
                ->where('is_active', true)
                ->limit(3)
                ->get()
        ];

        return $results;
    }

    /**
     * Get tournament details via AJAX.
     */
    public function getTournamentDetails($id)
    {
        $tournament = Tournament::withCount('teams as teams_count')
            ->findOrFail($id);

        return response()->json([
            'name' => $tournament->name,
            'description' => $tournament->description,
            'category' => $tournament->category,
            'city' => $tournament->city,
            'state' => $tournament->state,
            'start_date' => $tournament->tournament_start_date->format('M d, Y'),
            'end_date' => $tournament->tournament_end_date->format('M d, Y'),
            'teams_count' => $tournament->teams_count,
            'status' => $tournament->status,
            'registration_fee' => number_format($tournament->registration_fee, 2),
            'winner_prize' => $tournament->winner_prize ? number_format($tournament->winner_prize, 2) : null,
        ]);
    }
}