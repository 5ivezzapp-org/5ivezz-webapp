<?php
// app/Http/Controllers/Organizer/TournamentController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
}