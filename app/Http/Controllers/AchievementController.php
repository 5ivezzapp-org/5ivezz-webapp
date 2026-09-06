<?php
// app/Http/Controllers/AchievementController.php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\User;
use App\Models\MatchEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::query()->with(['player', 'team', 'tournament', 'match']);

        // Filter by player
        if ($request->has('player_id')) {
            $query->where('player_id', $request->player_id);
        }

        // Filter by team
        if ($request->has('team_id')) {
            $query->where('team_id', $request->team_id);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $achievements = $query->orderBy('achieved_date', 'desc')->paginate(20);

        return response()->json($achievements);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required|exists:players,id',
            'team_id' => 'nullable|exists:teams,id',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'match_id' => 'nullable|exists:matches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:individual,team,tournament',
            'category' => 'required|string|in:winner,golden_boot,best_player,most_assists,fair_play,top_scorer,most_valuable_player,custom',
            'icon' => 'nullable|string|max:50',
            'achieved_date' => 'required|date',
            'points' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $achievement = Achievement::create($validator->validated());

        return response()->json($achievement->load(['player', 'team', 'tournament', 'match']), 201);
    }

    public function show(Achievement $achievement)
    {
        $achievement->load(['player', 'team', 'tournament', 'match']);
        return response()->json($achievement);
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|string|in:individual,team,tournament',
            'category' => 'sometimes|string|in:winner,golden_boot,best_player,most_assists,fair_play,top_scorer,most_valuable_player,custom',
            'icon' => 'nullable|string|max:50',
            'achieved_date' => 'sometimes|date',
            'status' => 'sometimes|string|in:active,archived',
            'points' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $achievement->update($validator->validated());

        return response()->json($achievement->load(['player', 'team', 'tournament', 'match']));
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return response()->json(['message' => 'Achievement deleted successfully']);
    }

    public function getPlayerAchievements($playerId)
    {
        $player = User::findOrFail($playerId);

        $achievements = Achievement::forPlayer($playerId)
            ->active()
            ->with(['team', 'tournament'])
            ->orderBy('achieved_date', 'desc')
            ->get()
            ->groupBy('type');

        return response()->json([
            'player' => $player,
            'achievements' => $achievements
        ]);
    }

    public function getPlayerAchievementsSummary($playerId)
    {
        $player = User::findOrFail($playerId);

        $total = Achievement::forPlayer($playerId)->active()->count();
        $individual = Achievement::forPlayer($playerId)->individual()->active()->count();
        $team = Achievement::forPlayer($playerId)->team()->active()->count();
        $tournament = Achievement::forPlayer($playerId)->tournament()->active()->count();

        $categories = Achievement::forPlayer($playerId)
            ->active()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->get();

        return response()->json([
            'player' => $player,
            'summary' => [
                'total' => $total,
                'individual' => $individual,
                'team' => $team,
                'tournament' => $tournament,
                'categories' => $categories
            ]
        ]);
    }

    // Automated achievement creation helper
    public function checkAndCreateAchievements($playerId)
    {
        $player = User::findOrFail($playerId);

        $createdAchievements = [];

        // Check for 10 goals achievement
        $goals = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'goal')
            ->count();

        if ($goals >= 10) {
            $exists = Achievement::where('player_id', $playerId)
                ->where('category', 'top_scorer')
                ->where('title', '10 Goals Milestone')
                ->exists();

            if (!$exists) {
                $achievement = Achievement::create([
                    'player_id' => $playerId,
                    'title' => '10 Goals Milestone',
                    'description' => "Scored {$goals} goals in competitive matches",
                    'type' => 'individual',
                    'category' => 'top_scorer',
                    'icon' => 'fire',
                    'achieved_date' => now(),
                    'points' => 50,
                ]);
                $createdAchievements[] = $achievement;
            }
        }

        // Check for 50 matches played
        $matches = MatchEvent::where('player_id', $playerId)
            ->distinct('match_id')
            ->count('match_id');

        if ($matches >= 50) {
            $exists = Achievement::where('player_id', $playerId)
                ->where('category', 'custom')
                ->where('title', '50 Matches Milestone')
                ->exists();

            if (!$exists) {
                $achievement = Achievement::create([
                    'player_id' => $playerId,
                    'title' => '50 Matches Milestone',
                    'description' => "Played {$matches} competitive matches",
                    'type' => 'individual',
                    'category' => 'custom',
                    'icon' => 'star',
                    'achieved_date' => now(),
                    'points' => 25,
                ]);
                $createdAchievements[] = $achievement;
            }
        }

        // Check for 5 assists
        $assists = MatchEvent::where('player_id', $playerId)
            ->where('event_type', 'assist')
            ->count();

        if ($assists >= 5) {
            $exists = Achievement::where('player_id', $playerId)
                ->where('category', 'most_assists')
                ->where('title', '5 Assists Milestone')
                ->exists();

            if (!$exists) {
                $achievement = Achievement::create([
                    'player_id' => $playerId,
                    'title' => '5 Assists Milestone',
                    'description' => "Provided {$assists} assists in competitive matches",
                    'type' => 'individual',
                    'category' => 'most_assists',
                    'icon' => 'medal',
                    'achieved_date' => now(),
                    'points' => 30,
                ]);
                $createdAchievements[] = $achievement;
            }
        }

        return response()->json([
            'message' => 'Achievement check completed',
            'created' => $createdAchievements
        ]);
    }
}