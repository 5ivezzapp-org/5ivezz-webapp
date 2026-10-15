<?php
// app/Http/Controllers/Player/TeamController.php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\Tournament;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TeamController extends Controller
{
    /**
     * Display list of teams.
     */
    public function index()
    {
        $teams = Team::where('status', 'active')
            ->withCount('players')
            ->orderBy('name')
            ->paginate(12);

        return view('player.teams.index', compact('teams'));
    }

/**
 * Display team details with all real data.
 */
public function show(Team $team)
{
    $team->load([
        'players' => function ($query) {
            $query->wherePivot('status', 'active')
                ->orderBy('pivot_role', 'desc')
                ->orderBy('first_name');
        },
        'captain'
    ]);

    // Get all active players
    $players = $team->players;

    // Set avatar URLs on each player (fallback to UI Avatars)
    foreach ($players as $player) {
        $player->avatar_url = $player->avatar
            ? asset('storage/' . $player->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($player->full_name)
              . '&size=80&background=0D9488&color=fff&bold=true';
    }

    // Auth-aware flags
    $isMember  = Auth::check() && $team->hasPlayer(Auth::user());
    $isCaptain = Auth::check() && $team->isCaptain(Auth::user());

    // Get team role for current user
    $userRole = null;
    if (Auth::check() && $isMember) {
        $teamPlayer = $team->players()->where('user_id', Auth::id())->first();
        $userRole = $teamPlayer ? $teamPlayer->pivot->role : null;
    }

    // Has the current user already requested to join?
    $hasPendingRequest = Auth::check()
        && !$isMember
        && $team->hasPendingRequest(Auth::user());

    // Join requests (only loaded for captain)
    $joinRequests = $isCaptain
        ? $team->joinRequests()
            ->orderBy('team_player.created_at', 'desc')
            ->get()
        : collect();

    // Set avatar URLs on each requester too
    foreach ($joinRequests as $requester) {
        $requester->avatar_url = $requester->avatar
            ? asset('storage/' . $requester->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($requester->full_name)
              . '&size=80&background=0D9488&color=fff&bold=true';
    }

    // Stats and related data
    $teamStats          = $this->getTeamStats($team);
    $upcomingMatches    = $this->getUpcomingMatches($team);
    $recentMatches      = $this->getRecentMatches($team);
    $currentTournament  = $this->getCurrentTournament($team);
    $tournamentHistory  = $this->getTournamentHistory($team);
    $topScorers         = $this->getTopScorers($team);

    $achievements = Achievement::where('team_id', $team->id)
        ->where('status', 'active')
        ->orderBy('achieved_date', 'desc')
        ->limit(5)
        ->get();

    $playerCount = $players->count();

    // Team logo URL with fallback
    $team->logo_url = $team->logo
        ? asset('storage/' . $team->logo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($team->name)
          . '&size=80&background=00595c&color=fff&bold=true';

    return view('player.teams.show', compact(
        'team',
        'players',
        'isMember',
        'isCaptain',
        'userRole',
        'hasPendingRequest',
        'joinRequests',
        'teamStats',
        'upcomingMatches',
        'recentMatches',
        'currentTournament',
        'tournamentHistory',
        'topScorers',
        'achievements',
        'playerCount'
    ));
}
    /**
     * Show team creation form.
     */
    public function create()
    {
        $states = json_decode(file_get_contents(resource_path('data/nigeria-states.json')), true);
        return view('player.teams.create', compact('states'));
    }

    /**
     * Store a new team.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'max_players' => 'nullable|integer|min:5|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle logo upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('teams/logos', 'public');
        }

        // Handle cover image upload
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('teams/covers', 'public');
        }

        $team = Team::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
            'location' => $request->location ?? null,
            'city' => $request->city ?? null,
            'state' => $request->state ?? null,
            'country' => $request->country ?? 'Nigeria',
            'captain_id' => $user->id,
            'logo' => $logoPath,
            'cover_image' => $coverPath,
            'max_players' => $request->max_players ?? 25,
            'status' => 'active',
        ]);

        // Add the creator as a player and captain
        $team->players()->attach($user->id, [
            'role' => 'captain',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // Update user's current team
        $user->update(['team_id' => $team->id]);

        return redirect()->route('player.teams.show', $team)
            ->with('success', 'Team created successfully!');
    }

    /**
     * Show team edit form.
     */
    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        return view('player.teams.edit', compact('team'));
    }

    /**
     * Update team.
     */
    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'max_players' => 'nullable|integer|min:5|max:50',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($team->logo) {
                Storage::disk('public')->delete($team->logo);
            }
            $team->logo = $request->file('logo')->store('teams/logos', 'public');
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($team->cover_image) {
                Storage::disk('public')->delete($team->cover_image);
            }
            $team->cover_image = $request->file('cover_image')->store('teams/covers', 'public');
        }

        $team->update($validator->validated());

        return redirect()->route('player.teams.show', $team)
            ->with('success', 'Team updated successfully!');
    }

    /**
     * Join a team using invite code.
     */
    public function join(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'invite_code' => 'required|string|exists:teams,invite_code',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $team = Team::where('invite_code', $request->invite_code)->first();

        if (!$team) {
            return redirect()->back()->withErrors([
                'invite_code' => 'Invalid invite code.',
            ]);
        }

        if ($team->hasPlayer($user)) {
            return redirect()->back()->withErrors([
                'invite_code' => 'You are already a member of this team.',
            ]);
        }

        if (!$team->canAddPlayer()) {
            return redirect()->back()->withErrors([
                'invite_code' => 'This team has reached its maximum player limit.',
            ]);
        }

        $team->players()->attach($user->id, [
            'role' => 'player',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $user->update(['team_id' => $team->id]);

        return redirect()->route('player.teams.show', $team)
            ->with('success', 'You have joined the team successfully!');
    }

    /**
     * Leave a team.
     */
    public function leave(Team $team)
    {
        $user = Auth::user();

        if (!$team->hasPlayer($user)) {
            abort(403);
        }

        // Check if user is captain
        if ($team->isCaptain($user)) {
            return redirect()->back()->withErrors([
                'error' => 'You cannot leave the team as the captain. Transfer captaincy first or delete the team.',
            ]);
        }

        $team->players()->detach($user->id);
        $user->update(['team_id' => null]);

        return redirect()->route('player.teams.index')
            ->with('success', 'You have left the team.');
    }

    /**
     * Get team statistics.
     */
    protected function getTeamStats(Team $team)
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
        $goalsFor = 0;
        $goalsAgainst = 0;

        foreach ($matches as $match) {
            if ($match->home_team_id == $team->id) {
                $goalsFor += $match->home_score ?? 0;
                $goalsAgainst += $match->away_score ?? 0;
                if ($match->home_score > $match->away_score) {
                    $wins++;
                } elseif ($match->home_score < $match->away_score) {
                    $losses++;
                } else {
                    $draws++;
                }
            } else {
                $goalsFor += $match->away_score ?? 0;
                $goalsAgainst += $match->home_score ?? 0;
                if ($match->away_score > $match->home_score) {
                    $wins++;
                } elseif ($match->away_score < $match->home_score) {
                    $losses++;
                } else {
                    $draws++;
                }
            }
        }

        $totalMatches = $matches->count();

        return (object) [
            'wins' => $wins,
            'losses' => $losses,
            'draws' => $draws,
            'total' => $totalMatches,
            'goals_for' => $goalsFor,
            'goals_against' => $goalsAgainst,
            'goal_difference' => $goalsFor - $goalsAgainst,
            'win_percentage' => $totalMatches > 0 ? round(($wins / $totalMatches) * 100) : 0,
        ];
    }

    /**
     * Get upcoming matches.
     */
    protected function getUpcomingMatches(Team $team)
    {
        return Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('status', 'scheduled')
            ->where('match_datetime', '>=', Carbon::now())
            ->orderBy('match_datetime', 'asc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();
    }

    /**
     * Get recent matches.
     */
    protected function getRecentMatches(Team $team)
    {
        return Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'desc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();
    }

    /**
     * Get current tournament.
     */
    protected function getCurrentTournament(Team $team)
    {
        // Find active tournament where team is participating
        $tournamentMatch = Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->whereNotNull('tournament_id')
            ->where('match_datetime', '>=', Carbon::now())
            ->orderBy('match_datetime', 'asc')
            ->first();

        if ($tournamentMatch && $tournamentMatch->tournament) {
            return $tournamentMatch->tournament;
        }

        // Check if team has any tournament matches
        $tournamentMatch = Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->whereNotNull('tournament_id')
            ->where('status', '!=', 'cancelled')
            ->orderBy('match_datetime', 'desc')
            ->first();

        if ($tournamentMatch && $tournamentMatch->tournament) {
            return $tournamentMatch->tournament;
        }

        return null;
    }

    /**
     * Get tournament history.
     */
    protected function getTournamentHistory(Team $team)
    {
        $tournamentIds = Matches::where(function ($query) use ($team) {
            $query->where('home_team_id', $team->id)
                ->orWhere('away_team_id', $team->id);
        })
            ->whereNotNull('tournament_id')
            ->distinct('tournament_id')
            ->pluck('tournament_id');

        return Tournament::whereIn('id', $tournamentIds)
            ->where('status', 'completed')
            ->orderBy('tournament_end_date', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get top scorers.
     */
    protected function getTopScorers(Team $team)
    {
        // Get player IDs from team
        $playerIds = $team->players()->pluck('user_id')->toArray();

        // Count goals per player
        $goals = MatchEvent::whereIn('player_id', $playerIds)
            ->where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->selectRaw('player_id, COUNT(*) as goals')
            ->groupBy('player_id')
            ->orderBy('goals', 'desc')
            ->limit(5)
            ->with('player')
            ->get();

        return $goals;
    }

    /**
     * Request to join a team (pending captain approval).
     */
    public function requestJoin(Team $team)
    {
        $user = Auth::user();

        // Already a member?
        if ($team->hasPlayer($user)) {
            return back()->with('info', 'You are already a member of this team.');
        }

        // Already requested?
        if ($team->hasPendingRequest($user)) {
            return back()->with('info', 'Your join request is already pending approval.');
        }

        // Team is full?
        if (!$team->canAddPlayer()) {
            return back()->withErrors(['error' => 'This team has reached its maximum player limit.']);
        }

        // If user is already in another team, remove them from it first? Optional.
        // For now, just block:
        if ($user->team_id && $user->team_id !== $team->id) {
            return back()->withErrors(['error' => 'You are already part of another team. Leave it first.']);
        }

        $team->players()->attach($user->id, [
            'role' => 'player',
            'status' => 'pending',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Join request sent! The captain will review it shortly.');
    }

    /**
     * Approve a pending join request (captain only).
     */
    public function approveRequest(Team $team, User $user)
    {
        $authUser = Auth::user();

        if (!$team->isCaptain($authUser)) {
            abort(403, 'Only the captain can approve requests.');
        }

        // Confirm the request exists and is pending
        $pivot = $team->players()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->pivot->status !== 'pending') {
            return back()->withErrors(['error' => 'No pending request found for this user.']);
        }

        // Team full check
        if (!$team->canAddPlayer()) {
            return back()->withErrors(['error' => 'Team is full. Cannot approve more players.']);
        }

        // Approve
        $team->players()->updateExistingPivot($user->id, [
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // Set the user's team_id
        $user->update(['team_id' => $team->id]);

        return back()->with('success', $user->first_name . ' has been added to the team.');
    }

    /**
     * Reject a pending join request (captain only).
     */
    public function rejectRequest(Team $team, User $user)
    {
        $authUser = Auth::user();

        if (!$team->isCaptain($authUser)) {
            abort(403, 'Only the captain can reject requests.');
        }

        $pivot = $team->players()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->pivot->status !== 'pending') {
            return back()->withErrors(['error' => 'No pending request found for this user.']);
        }

        // Detach the record (rejected users can request again if you want;
        // to permanently block, add a 'rejected' status instead)
        $team->players()->detach($user->id);

        return back()->with('success', $user->first_name . "'s request has been rejected.");
    }
}