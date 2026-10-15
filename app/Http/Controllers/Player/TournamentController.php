<?php
// app/Http/Controllers/Player/TournamentController.php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Team;
use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TournamentController extends Controller
{
    /**
     * Browse all published tournaments.
     * Public — accessible to guests and logged-in users.
     */
    public function index(Request $request)
    {
        $query = Tournament::whereIn('status', ['published', 'ongoing'])
            ->withCount(['approvedTeams as teams_count'])
            ->with('organizer');

        // Filter by search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('city', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('state', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by state
        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tournaments = $query->orderBy('tournament_start_date', 'asc')->paginate(12);

        // Set cover image URL
        $tournaments->getCollection()->transform(function ($t) {
            $t->cover_image_url = $t->cover_image
                ? asset('storage/' . $t->cover_image)
                : 'https://images.unsplash.com/photo-1459865264687-595d652de67e?w=600&h=400&fit=crop';
            return $t;
        });

        return view('player.tournaments.index', compact('tournaments'));
    }

    /**
     * Show a tournament detail page.
     * Public — accessible to guests and logged-in users.
     * Registration availability is computed per-viewer.
     */
    public function show(Tournament $tournament)
    {
        // Only allow viewing published/ongoing/completed tournaments
        if ($tournament->status === 'draft' || $tournament->status === 'cancelled') {
            abort(404);
        }

        $tournament->load('organizer');

        // Approved teams
        $approvedTeams = $tournament->approvedTeams()->withCount('players')->get();
        $teamsCount = $approvedTeams->count();

        // Cover image
        $tournament->cover_image_url = $tournament->cover_image
            ? asset('storage/' . $tournament->cover_image)
            : 'https://images.unsplash.com/photo-1459865264687-595d652de67e?w=1200&h=500&fit=crop';

        // Upcoming matches
        $upcomingMatches = Matches::where('tournament_id', $tournament->id)
            ->where('status', 'scheduled')
            ->where('match_datetime', '>=', Carbon::now())
            ->orderBy('match_datetime', 'asc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam'])
            ->get();

        // Recent results
        $recentMatches = Matches::where('tournament_id', $tournament->id)
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'desc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam'])
            ->get();

        // ============================================================
        // Guest-safe registration state
        // ============================================================
        $user = Auth::user();               // may be null
        $userTeam = null;
        $registration = null;
        $canRegister = false;
        $registrationBlockers = [];

        if ($user) {
            $userTeam = $user->team;

            if ($userTeam) {
                // Is this team already registered?
                $registration = $tournament->teams()
                    ->where('team_id', $userTeam->id)
                    ->first();

                // Only captains can register
                $isCaptain = $userTeam->captain_id === $user->id;
                if (!$isCaptain) {
                    $registrationBlockers[] = 'Only the team captain can register the team.';
                }

                // Tournament must be published
                if ($tournament->status !== 'published') {
                    $registrationBlockers[] = 'Tournament is not open for registration.';
                }

                // Registration window must be open
                if (!$tournament->isRegistrationOpen()) {
                    $registrationBlockers[] = 'Registration window is closed.';
                }

                // Max teams check
                if ($tournament->approvedTeams()->count() >= $tournament->max_teams) {
                    $registrationBlockers[] = 'Tournament has reached its maximum team limit.';
                }

                // Roster size checks
                $playerCount = $userTeam->players()->count();
                if ($playerCount < $tournament->min_players_per_team) {
                    $registrationBlockers[] = "Your team needs at least {$tournament->min_players_per_team} players.";
                }
                if ($playerCount > $tournament->max_players_per_team) {
                    $registrationBlockers[] = "Your team exceeds the max of {$tournament->max_players_per_team} players.";
                }

                $canRegister = empty($registrationBlockers) && !$registration;
            }
        }

        return view('player.tournaments.show', compact(
            'tournament',
            'approvedTeams',
            'teamsCount',
            'upcomingMatches',
            'recentMatches',
            'registration',
            'canRegister',
            'registrationBlockers',
            'userTeam'
        ));
    }

    /**
     * Register the player's team for a tournament.
     * Requires auth + user must have a team + be the captain.
     */
    public function register(Request $request, Tournament $tournament)
    {
        $user = Auth::user();
        $userTeam = $user->team;

        // Must have a team
        if (!$userTeam) {
            return redirect()->route('player.teams.index')
                ->withErrors(['error' => 'You need to be part of a team before you can register for a tournament.']);
        }

        // Must be the team captain
        if ($userTeam->captain_id !== $user->id) {
            return back()->withErrors(['error' => 'Only the team captain can register the team.']);
        }

        // Tournament must be published
        if ($tournament->status !== 'published') {
            return back()->withErrors(['error' => 'This tournament is not open for registration.']);
        }

        // Registration window must be open
        if (!$tournament->isRegistrationOpen()) {
            return back()->withErrors(['error' => 'Registration window is closed.']);
        }

        // Max teams check
        if ($tournament->approvedTeams()->count() >= $tournament->max_teams) {
            return back()->withErrors(['error' => 'Tournament has reached its maximum team limit.']);
        }

        // Already registered?
        $existing = $tournament->teams()->where('team_id', $userTeam->id)->first();
        if ($existing) {
            return back()->withErrors(['error' => 'Your team is already registered for this tournament.']);
        }

        // Roster size checks
        $playerCount = $userTeam->players()->count();
        if ($playerCount < $tournament->min_players_per_team) {
            return back()->withErrors([
                'error' => "Your team has {$playerCount} players. Minimum required is {$tournament->min_players_per_team}."
            ]);
        }
        if ($playerCount > $tournament->max_players_per_team) {
            return back()->withErrors([
                'error' => "Your team has {$playerCount} players. Maximum allowed is {$tournament->max_players_per_team}."
            ]);
        }

        // Attach registration as pending (organizer approves)
        $tournament->teams()->attach($userTeam->id, [
            'registered_by' => $user->id,
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        return redirect()->route('player.tournaments.show', $tournament)
            ->with('success', 'Your team has been registered! Waiting for organizer approval.');
    }

    /**
     * Withdraw the team from the tournament.
     * Requires auth + user must be the captain of the registered team.
     */
    public function withdraw(Tournament $tournament)
    {
        $user = Auth::user();
        $userTeam = $user->team;

        if (!$userTeam || $userTeam->captain_id !== $user->id) {
            return back()->withErrors(['error' => 'Only the team captain can withdraw.']);
        }

        $registration = $tournament->teams()->where('team_id', $userTeam->id)->first();

        if (!$registration) {
            return back()->withErrors(['error' => 'Your team is not registered for this tournament.']);
        }

        if ($registration->pivot->status === 'approved' && $tournament->status === 'ongoing') {
            return back()->withErrors(['error' => 'Cannot withdraw after tournament has started.']);
        }

        $tournament->teams()->detach($userTeam->id);

        return redirect()->route('player.tournaments.show', $tournament)
            ->with('success', 'Your team has been withdrawn from the tournament.');
    }
}