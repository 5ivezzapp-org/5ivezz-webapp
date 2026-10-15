<?php
// app/Http/Controllers/Organizer/TournamentController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Team;
class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::byOrganizer(Auth::guard('organizer')->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('organizer.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $organizer = Auth::guard('organizer')->user();
        $states = json_decode(file_get_contents(resource_path('data/nigeria-states.json')), true);

        return view('organizer.tournaments.create', compact('organizer', 'states'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateTournament($request);

        $tournament = new Tournament($validated);
        $tournament->organizer_id = Auth::guard('organizer')->id();  // Changed from user_id

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('tournament-covers', 'public');
            $tournament->cover_image = $path;
        }

        $tournament->save();

        return redirect()->route('organizer.tournaments.show', $tournament)
            ->with('success', 'Tournament created successfully!');
    }

    public function show(Tournament $tournament)
    {
        // Ensure the tournament belongs to the authenticated organizer
        if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        return view('organizer.tournaments.show', compact('tournament'));
    }

    public function edit(Tournament $tournament)
    {
        if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        return view('organizer.tournaments.edit', compact('tournament'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $validated = $this->validateTournament($request, $tournament->id);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($tournament->cover_image) {
                Storage::disk('public')->delete($tournament->cover_image);
            }
            $path = $request->file('cover_image')->store('tournament-covers', 'public');
            $tournament->cover_image = $path;
        }

        $tournament->update($validated);

        return redirect()->route('organizer.tournaments.show', $tournament)
            ->with('success', 'Tournament updated successfully!');
    }

    public function destroy(Tournament $tournament)
    {
        if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        if ($tournament->cover_image) {
            Storage::disk('public')->delete($tournament->cover_image);
        }

        $tournament->delete();

        return redirect()->route('organizer.tournaments.index')
            ->with('success', 'Tournament deleted successfully!');
    }

    public function publish(Tournament $tournament)
    {
        if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
            abort(403);
        }

        $tournament->update(['status' => 'published']);

        return back()->with('success', 'Tournament published successfully!');
    }

    protected function validateTournament(Request $request, ?int $tournamentId = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:tournaments,name' . ($tournamentId ? ',' . $tournamentId : ''),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'required|string',
            'category' => 'required|string|in:youth,adult,pro-am,senior,women,mixed',
            'type' => 'required|string|in:u-10,u-12,u-14,u-16,u-18,u-21,open',
            'edition' => 'nullable|string|max:255',
            'organization_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email_address' => 'required|email|max:255',
            'website_social' => 'nullable|string|max:255',
            'registration_opens' => 'required|date',
            'registration_closes' => 'required|date|after:registration_opens',
            'tournament_start_date' => 'required|date|after_or_equal:registration_closes',
            'tournament_end_date' => 'required|date|after:tournament_start_date',
            'venue_name' => 'required|string|max:255',
            'venue_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'tournament_format' => 'required|string|in:league,round-robin,knockout,group-knockout,league-playoffs,friendly,custom',
            'number_of_teams' => 'required|integer|min:2|max:100',
            'max_players_per_team' => 'required|integer|min:1|max:50',
            'min_players_per_team' => 'required|integer|min:1|max:50|lte:max_players_per_team',
            'registration_method' => 'required|string|in:free,paid,invitation',
            'registration_fee' => 'nullable|numeric|min:0',
            'max_teams' => 'required|integer|min:1|max:500',
            'team_registration_deadline' => 'required|date|after_or_equal:registration_opens|before_or_equal:registration_closes',
            'team_eligibility' => 'nullable|string',
            'requires_manager_details' => 'boolean',
            'requires_player_roster' => 'boolean',
            'tournament_rules' => 'nullable|string',
            'match_rules' => 'nullable|string',
            'winner_prize' => 'nullable|numeric|min:0',
            'runner_up_prize' => 'nullable|numeric|min:0',
            'third_place_prize' => 'nullable|numeric|min:0',
            'additional_prize_details' => 'nullable|string',
            'status' => 'nullable|in:draft,published',
        ];

        return $request->validate($rules);
    }

/**
 * Show a team's registration details for review.
 */
public function reviewTeam(Tournament $tournament, Team $team)
{
    // Ownership check
    if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
        abort(403);
    }

    // Confirm the team actually has a registration (any status)
    $registration = $tournament->teams()
        ->where('team_id', $team->id)
        ->first();

    if (!$registration) {
        abort(404, 'No registration found for this team.');
    }

    // Load team + all active players
    $team->load([
        'players' => function ($q) {
            $q->wherePivot('status', 'active')
              ->orderBy('pivot_role', 'desc')
              ->orderBy('first_name');
        },
        'captain'
    ]);

    // Add avatar URLs
    foreach ($team->players as $player) {
        $player->avatar_url = $player->avatar
            ? asset('storage/' . $player->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($player->full_name)
              . '&size=80&background=0D9488&color=fff&bold=true';
    }

    $team->logo_url = $team->logo
        ? asset('storage/' . $team->logo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($team->name)
          . '&size=80&background=00595c&color=fff&bold=true';

    // Check if the team meets tournament criteria
    $playerCount = $team->players->count();

    $checks = [
        'min_players' => [
            'label' => "Minimum {$tournament->min_players_per_team} players",
            'passed' => $playerCount >= $tournament->min_players_per_team,
            'detail' => "{$playerCount} registered",
        ],
        'max_players' => [
            'label' => "Maximum {$tournament->max_players_per_team} players",
            'passed' => $playerCount <= $tournament->max_players_per_team,
            'detail' => "{$playerCount} registered",
        ],
        'registration_open' => [
            'label' => 'Within registration window',
            'passed' => $tournament->isRegistrationOpen(),
            'detail' => $tournament->registration_opens->format('M d') . ' – ' . $tournament->registration_closes->format('M d, Y'),
        ],
        'team_slot' => [
            'label' => 'Team slot available',
            'passed' => $tournament->approvedTeams()->count() < $tournament->max_teams,
            'detail' => $tournament->approvedTeams()->count() . '/' . $tournament->max_teams . ' approved',
        ],
    ];

    $allChecksPassed = collect($checks)->every(fn($c) => $c['passed']);

    return view('organizer.tournaments.review-team', compact(
        'tournament',
        'team',
        'registration',
        'checks',
        'allChecksPassed',
        'playerCount'
    ));
}

/**
 * Approve a pending registration from the review page.
 */
public function approveRegistration(Request $request, Tournament $tournament, Team $team)
{
    if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'note' => 'nullable|string|max:1000',
    ]);

    $registration = $tournament->teams()->where('team_id', $team->id)->first();
    if (!$registration) {
        return back()->withErrors(['error' => 'Registration not found.']);
    }

    if ($registration->pivot->status === 'approved') {
        return back()->with('info', 'This team is already approved.');
    }

    if ($tournament->approvedTeams()->count() >= $tournament->max_teams) {
        return back()->withErrors(['error' => 'Tournament has reached its maximum team limit.']);
    }

    $tournament->teams()->updateExistingPivot($team->id, [
        'status' => 'approved',
        'approved_at' => now(),
        'notes' => $validated['note'] ?? null,
    ]);

    return redirect()
        ->route('organizer.tournaments.show', $tournament)
        ->with('success', $team->name . ' has been approved for ' . $tournament->name . '.');
}

/**
 * Reject a pending registration from the review page.
 */
public function rejectRegistration(Request $request, Tournament $tournament, Team $team)
{
    if ($tournament->organizer_id !== Auth::guard('organizer')->id()) {
        abort(403);
    }

    $validated = $request->validate([
        'note' => 'nullable|string|max:1000',
    ]);

    $registration = $tournament->teams()->where('team_id', $team->id)->first();
    if (!$registration) {
        return back()->withErrors(['error' => 'Registration not found.']);
    }

    $tournament->teams()->updateExistingPivot($team->id, [
        'status' => 'rejected',
        'notes' => $validated['note'] ?? null,
    ]);

    return redirect()
        ->route('organizer.tournaments.show', $tournament)
        ->with('success', $team->name . "'s registration has been rejected.");
}
}