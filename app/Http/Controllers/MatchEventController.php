<?php
// app/Http/Controllers/MatchEventController.php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\User;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatchEventController extends Controller
{
    public function index(Request $request)
    {
        $query = MatchEvent::query()->with(['match', 'player', 'assistPlayer', 'team']);

        // Filter by match
        if ($request->has('match_id')) {
            $query->where('match_id', $request->match_id);
        }

        // Filter by player
        if ($request->has('player_id')) {
            $query->where('player_id', $request->player_id);
        }

        // Filter by team
        if ($request->has('team_id')) {
            $query->where('team_id', $request->team_id);
        }

        // Filter by event type
        if ($request->has('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        $events = $query->orderBy('minute', 'asc')->paginate(50);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'match_id' => 'required|exists:matches,id',
            'team_id' => 'required|exists:teams,id',
            'player_id' => 'required|exists:players,id',
            'assist_player_id' => 'nullable|exists:players,id|different:player_id',
            'event_type' => 'required|string|in:goal,assist,yellow_card,red_card,substitution,penalty_missed,own_goal',
            'minute' => 'required|integer|min:0|max:120',
            'second' => 'nullable|integer|min:0|max:59',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $match = Matches::find($request->match_id);
        
        // Check if match is live
        if (!$match->isLive()) {
            return response()->json([
                'error' => 'Events can only be added to live matches'
            ], 400);
        }

        $event = MatchEvent::create($validator->validated());

        return response()->json($event->load(['match', 'player', 'assistPlayer', 'team']), 201);
    }

    public function show(MatchEvent $event)
    {
        $event->load(['match', 'player', 'assistPlayer', 'team']);
        return response()->json($event);
    }

    public function update(Request $request, MatchEvent $event)
    {
        $validator = Validator::make($request->all(), [
            'assist_player_id' => 'nullable|exists:players,id|different:player_id',
            'event_type' => 'sometimes|string|in:goal,assist,yellow_card,red_card,substitution,penalty_missed,own_goal',
            'minute' => 'sometimes|integer|min:0|max:120',
            'second' => 'nullable|integer|min:0|max:59',
            'description' => 'nullable|string',
            'status' => 'sometimes|string|in:confirmed,pending,disputed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event->update($validator->validated());

        return response()->json($event->load(['match', 'player', 'assistPlayer', 'team']));
    }

    public function destroy(MatchEvent $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function getMatchEvents($matchId)
    {
        $match = Matches::findOrFail($matchId);

        $events = MatchEvent::where('match_id', $matchId)
            ->with(['player', 'assistPlayer', 'team'])
            ->orderBy('minute', 'asc')
            ->get()
            ->groupBy('team_id');

        return response()->json([
            'match' => $match,
            'events' => $events
        ]);
    }

    public function getPlayerStats($playerId)
    {
        $player = User::findOrFail($playerId);

        $goals = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'goal')
            ->count();

        $assists = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'assist')
            ->count();

        $yellowCards = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'yellow_card')
            ->count();

        $redCards = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'red_card')
            ->count();

        return response()->json([
            'player' => $player,
            'stats' => [
                'goals' => $goals,
                'assists' => $assists,
                'yellow_cards' => $yellowCards,
                'red_cards' => $redCards,
            ]
        ]);
    }
}