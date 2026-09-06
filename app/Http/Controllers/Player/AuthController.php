<?php
// app/Http/Controllers/Player/AuthController.php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\Matches;
use App\Models\MatchEvent;
use App\Models\Achievement;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Show player registration form.
     */
    public function showRegistrationForm()
    {
        return view('player.auth.register');
    }

    /**
     * Show player login form.
     */
    public function showLoginForm()
    {
        return view('player.auth.login');
    }

    /**
     * Handle player registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'position' => 'nullable|string|max:100',
            'preferred_foot' => 'nullable|in:right,left,both',
            'bio' => 'nullable|string|max:500',
            'playing_level' => 'nullable|in:casual,amateur,semi-pro,professional',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'invite_code' => 'nullable|string|exists:teams,invite_code',
        ]);

        // Handle avatar upload
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('player/avatars', 'public');
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'position' => $validated['position'] ?? null,
            'preferred_foot' => $validated['preferred_foot'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'playing_level' => $validated['playing_level'] ?? 'amateur',
            'state' => $validated['state'] ?? null,
            'city' => $validated['city'] ?? null,
            'avatar' => $avatarPath,
            'invite_code' => $validated['invite_code'] ?? null,
            'is_active' => true,
        ]);

        // If invite code provided, join the team
        if (!empty($validated['invite_code'])) {
            $team = Team::where('invite_code', $validated['invite_code'])->first();
            if ($team) {
                $user->team_id = $team->id;
                $user->save();
                
                // Add player to team
                $team->players()->attach($user->id, [
                    'role' => 'player',
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
            }
        }

        Auth::login($user);

        return redirect()->route('player.dashboard')
            ->with('success', 'Welcome to 5ivezz! Your football journey starts now.');
    }

    /**
     * Handle player login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        if (Auth::attempt($credentials, $request->remember ?? false)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account has been deactivated.',
                ]);
            }

            return redirect()->intended(route('player.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle player logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('player.login');
    }

    /**
     * Show player dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $team = $user->team;
        $stats = $this->getPlayerStats($user);
        $matches = $this->getPlayerMatches($user);
        $achievements = $this->getPlayerAchievements($user);
        $tournaments = $this->getPlayerTournaments($user);
        $nextMatch = $this->getNextMatch($user, $team);

        return view('player.dashboard', compact(
            'user', 
            'team', 
            'stats', 
            'matches', 
            'achievements', 
            'tournaments',
            'nextMatch'
        ));
    }

    /**
     * Show player profile with all data.
     */
    public function profile()
    {
        $user = Auth::user()->load('team');
        
        // Get player stats
        $stats = $this->getPlayerStats($user);
        
        // Get recent matches
        $recentMatches = $this->getRecentMatches($user);
        
        // Get team role
        $teamRole = null;
        if ($user->team) {
            $teamPlayer = $user->team->players()->where('user_id', $user->id)->first();
            $teamRole = $teamPlayer ? $teamPlayer->pivot->role : null;
        }
        
        // Get achievements count
        $achievementsCount = Achievement::where('player_id', $user->id)
            ->where('status', 'active')
            ->count();
        
        return view('player.profile', compact(
            'user', 
            'stats', 
            'recentMatches', 
            'teamRole',
            'achievementsCount'
        ));
    }

    /**
     * Update player profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'position' => 'nullable|string|max:100',
            'preferred_foot' => 'nullable|in:right,left,both',
            'bio' => 'nullable|string|max:500',
            'playing_level' => 'nullable|in:casual,amateur,semi-pro,professional',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($validator->validated());

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update player password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    /**
     * Upload avatar.
     */
    public function uploadAvatar(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('player/avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Avatar updated successfully!');
    }

    /**
     * Get player statistics with real data.
     */
    protected function getPlayerStats(User $user)
    {
        // Get all match events where player participated (goals)
        $goals = MatchEvent::where('player_id', $user->id)
            ->where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->count();

        // Get assists
        $assists = MatchEvent::where('assist_player_id', $user->id)
            ->where('event_type', 'goal')
            ->where('status', 'confirmed')
            ->count();

        // Get matches played - from match events
        $matchesPlayed = MatchEvent::where('player_id', $user->id)
            ->where('status', 'confirmed')
            ->distinct('match_id')
            ->count('match_id');

        // Get man of the match awards
        $manOfMatch = Achievement::where('player_id', $user->id)
            ->where('type', 'man_of_the_match')
            ->where('status', 'active')
            ->count();

        return [
            'matches' => $matchesPlayed ?: 0,
            'goals' => $goals ?: 0,
            'assists' => $assists ?: 0,
            'man_of_match' => $manOfMatch ?: 0,
        ];
    }

    /**
     * Get player's upcoming and recent matches.
     */
    protected function getPlayerMatches(User $user)
    {
        if (!$user->team_id) {
            return (object) [
                'upcoming' => collect(),
                'recent' => collect(),
                'hasMatches' => false
            ];
        }

        $teamId = $user->team_id;

        // Get upcoming matches (scheduled)
        $upcoming = Matches::where(function ($query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId);
            })
            ->where('status', 'scheduled')
            ->where('match_datetime', '>=', Carbon::now())
            ->orderBy('match_datetime', 'asc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();

        // Get recent matches (completed)
        $recent = Matches::where(function ($query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                    ->orWhere('away_team_id', $teamId);
            })
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'desc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->get();

        return (object) [
            'upcoming' => $upcoming,
            'recent' => $recent,
            'hasMatches' => $upcoming->isNotEmpty() || $recent->isNotEmpty()
        ];
    }

    /**
     * Get player's recent matches for profile.
     */
    protected function getRecentMatches(User $user)
    {
        if (!$user->team_id) {
            return collect();
        }

        return Matches::where(function($query) use ($user) {
                $query->where('home_team_id', $user->team_id)
                    ->orWhere('away_team_id', $user->team_id);
            })
            ->where('status', 'completed')
            ->orderBy('match_datetime', 'desc')
            ->limit(5)
            ->with(['homeTeam', 'awayTeam'])
            ->get();
    }

    /**
     * Get player's achievements.
     */
    protected function getPlayerAchievements(User $user)
    {
        $achievements = Achievement::where('player_id', $user->id)
            ->where('status', 'active')
            ->orderBy('achieved_date', 'desc')
            ->limit(3)
            ->with(['team', 'tournament', 'match'])
            ->get();

        return (object) [
            'items' => $achievements,
            'count' => $achievements->count(),
            'hasAchievements' => $achievements->isNotEmpty()
        ];
    }

    /**
     * Get tournaments the player has participated in.
     */
    protected function getPlayerTournaments(User $user)
    {
        if (!$user->team_id) {
            return (object) [
                'items' => collect(),
                'hasTournaments' => false
            ];
        }

        // Get tournaments where player's team has participated
        $tournamentIds = Matches::where(function ($query) use ($user) {
                $query->where('home_team_id', $user->team_id)
                    ->orWhere('away_team_id', $user->team_id);
            })
            ->whereNotNull('tournament_id')
            ->distinct('tournament_id')
            ->pluck('tournament_id');

        $tournaments = Tournament::whereIn('id', $tournamentIds)
            ->where('status', '!=', 'draft')
            ->orderBy('tournament_start_date', 'desc')
            ->limit(3)
            ->get();

        // If no matches yet, show active tournaments
        if ($tournaments->isEmpty()) {
            $tournaments = Tournament::where('status', 'published')
                ->orWhere('status', 'ongoing')
                ->orderBy('tournament_start_date', 'asc')
                ->limit(3)
                ->get();
        }

        return (object) [
            'items' => $tournaments,
            'hasTournaments' => $tournaments->isNotEmpty()
        ];
    }

    /**
     * Get next match for the player's team.
     */
    protected function getNextMatch(User $user, $team)
    {
        if (!$team) {
            return null;
        }

        return Matches::where(function ($query) use ($team) {
                $query->where('home_team_id', $team->id)
                    ->orWhere('away_team_id', $team->id);
            })
            ->where('status', 'scheduled')
            ->where('match_datetime', '>=', Carbon::now())
            ->orderBy('match_datetime', 'asc')
            ->with(['homeTeam', 'awayTeam', 'tournament'])
            ->first();
    }
}