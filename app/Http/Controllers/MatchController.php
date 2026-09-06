<?php
// app/Http/Controllers/MatchController.php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Matches::query();

        // Filter by tournament
        if ($request->has('tournament_id')) {
            $query->where('tournament_id', $request->tournament_id);
        }

        // Filter by team
        if ($request->has('team_id')) {
            $query->where(function($q) use ($request) {
                $q->where('home_team_id', $request->team_id)
                  ->orWhere('away_team_id', $request->team_id);
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->has('to_date')) {
            $query->whereBetween('match_datetime', [
                $request->from_date,
                $request->to_date
            ]);
        }

        $matches = $query->with(['homeTeam', 'awayTeam', 'tournament'])
            ->orderBy('match_datetime', 'desc')
            ->paginate(20);

        return response()->json($matches);
    }

    public function upcoming()
    {
        $matches = Matches::upcoming()
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->orderBy('match_datetime', 'asc')
            ->limit(10)
            ->get();

        return response()->json($matches);
    }

    public function live()
    {
        $matches = Matches::live()
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();

        return response()->json($matches);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'nullable|exists:tournaments,id',
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'venue_name' => 'required|string|max:255',
            'venue_address' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'match_datetime' => 'required|date|after:now',
            'stage' => 'required|string|in:group_stage,quarter_final,semi_final,final,friendly',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $match = Matches::create($validator->validated());

        return response()->json($match->load(['homeTeam', 'awayTeam', 'tournament']), 201);
    }

    public function show(Matches $match)
    {
        $match->load(['homeTeam', 'awayTeam', 'tournament', 'events' => function($query) {
            $query->with(['player', 'assistPlayer', 'team'])->orderBy('minute');
        }]);

        return response()->json($match);
    }

    public function update(Request $request, Matches $match)
    {
        $validator = Validator::make($request->all(), [
            'venue_name' => 'sometimes|string|max:255',
            'venue_address' => 'nullable|string',
            'city' => 'sometimes|string|max:100',
            'state' => 'sometimes|string|max:100',
            'country' => 'sometimes|string|max:100',
            'match_datetime' => 'sometimes|date',
            'status' => 'sometimes|in:scheduled,live,finished,cancelled,postponed',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'winner' => 'nullable|in:home,away,draw',
            'match_report' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $match->update($validator->validated());

        return response()->json($match->load(['homeTeam', 'awayTeam', 'tournament']));
    }

    public function updateScore(Request $request, Matches $match)
    {
        $validator = Validator::make($request->all(), [
            'home_score' => 'required|integer|min:0',
            'away_score' => 'required|integer|min:0',
            'winner' => 'nullable|in:home,away,draw',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $match->update($validator->validated());

        return response()->json($match);
    }

    public function destroy(Matches $match)
    {
        $match->delete();

        return response()->json(['message' => 'Matches deleted successfully']);
    }

    public function getMatchesForTeam($teamId)
    {
        $team = Team::findOrFail($teamId);

        $matches = Matches::forTeam($teamId)
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->orderBy('match_datetime', 'desc')
            ->paginate(20);

        return response()->json($matches);
    }

    public function getMatchesForTournament($tournamentId)
    {
        $tournament = Tournament::findOrFail($tournamentId);

        $matches = Matches::forTournament($tournamentId)
            ->with(['homeTeam', 'awayTeam'])
            ->orderBy('match_datetime', 'asc')
            ->get()
            ->groupBy('stage');

        return response()->json($matches);
    }
}