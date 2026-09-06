<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\Organizer\AuthController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\Player\TeamController;
use App\Http\Controllers\Player\DashboardController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MatchEventController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/tournaments', function () {
    return view('tournaments.index');
})->name('tournaments.index');

Route::get('/tournaments/create', function () {
    return view('tournaments.create');
})->name('tournaments.create');

Route::get('teams', [App\Http\Controllers\Player\TeamController::class, 'index'])->name('teams.index');
Route::get('teams/{team}', [App\Http\Controllers\Player\TeamController::class, 'show'])->name('player.teams.show');
Route::get('/players', function () {
    return view('players.index');
})->name('players.index');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/wallet', function () {
    return view('wallet.index');
})->name('wallet');

// Explore page routes
Route::get('/explore', [ExploreController::class, 'index'])->name('explore.index');
Route::get('/explore/tournament/{id}', [ExploreController::class, 'getTournamentDetails'])->name('explore.tournament.details');


Route::resource('tournaments', TournamentController::class);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Tournament CRUD routes
    
    
    // Additional actions
    Route::post('tournaments/{tournament}/publish', [TournamentController::class, 'publish'])
        ->name('tournaments.publish');
    
});

// Public tournament view (optional)
Route::get('tournaments/{tournament}', [TournamentController::class, 'show'])
    ->name('tournaments.show');


/*
|--------------------------------------------------------------------------
| Organizer Routes
|--------------------------------------------------------------------------
*/
Route::prefix('organizer')->name('organizer.')->group(function () {
    
    // Guest routes (not logged in)
    Route::middleware('organizer.guest')->group(function () {
        // Registration
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
        
        // Login
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        
        // Password Reset
        Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
        Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    });
    
    // Authenticated routes
    Route::middleware('organizer.auth')->group(function () {
        // Dashboard
        Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        
        // Profile
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
        Route::post('profile/logo', [AuthController::class, 'updateLogo'])->name('profile.logo');
        
        // Tournament Management
        Route::resource('tournaments', TournamentController::class);
        
        // Logout
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| Player Routes
|--------------------------------------------------------------------------
*/
Route::prefix('player')->name('player.')->group(function () {
    
    // Guest routes (not logged in)
    Route::middleware('guest')->group(function () {
        Route::get('register', [App\Http\Controllers\Player\AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [App\Http\Controllers\Player\AuthController::class, 'register']);
        Route::get('login', [App\Http\Controllers\Player\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [App\Http\Controllers\Player\AuthController::class, 'login']);
    });
    
    // Authenticated routes
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('dashboard', [App\Http\Controllers\Player\AuthController::class, 'dashboard'])->name('dashboard');
        
        // Profile
        Route::get('profile', [App\Http\Controllers\Player\AuthController::class, 'profile'])->name('profile');
        Route::put('profile', [App\Http\Controllers\Player\AuthController::class, 'updateProfile'])->name('profile.update');
        Route::put('profile/password', [App\Http\Controllers\Player\AuthController::class, 'updatePassword'])->name('profile.password');
        Route::post('profile/avatar', [App\Http\Controllers\Player\AuthController::class, 'uploadAvatar'])->name('profile.avatar');
        
        // Teams
        Route::get('teams', [App\Http\Controllers\Player\TeamController::class, 'index'])->name('teams.index');
        Route::get('teams/create', [App\Http\Controllers\Player\TeamController::class, 'create'])->name('teams.create');
        Route::post('teams', [App\Http\Controllers\Player\TeamController::class, 'store'])->name('teams.store');
        
        Route::get('teams/{team}/edit', [App\Http\Controllers\Player\TeamController::class, 'edit'])->name('teams.edit');
        Route::put('teams/{team}', [App\Http\Controllers\Player\TeamController::class, 'update'])->name('teams.update');
        Route::post('teams/join', [App\Http\Controllers\Player\TeamController::class, 'join'])->name('teams.join');
        Route::delete('teams/{team}/leave', [App\Http\Controllers\Player\TeamController::class, 'leave'])->name('teams.leave');
        
        // Logout
        Route::post('logout', [App\Http\Controllers\Player\AuthController::class, 'logout'])->name('logout');
    });
});

// Public team routes (no auth required)
// Route::get('teams/{team}', [App\Http\Controllers\Player\TeamController::class, 'show'])->name('public.team.show');

// api.php or web.php

// Match Routes
Route::prefix('matches')->group(function () {
    Route::get('/', [MatchController::class, 'index']);
    Route::get('/upcoming', [MatchController::class, 'upcoming']);
    Route::get('/live', [MatchController::class, 'live']);
    Route::post('/', [MatchController::class, 'store']);
    Route::get('/{match}', [MatchController::class, 'show']);
    Route::put('/{match}', [MatchController::class, 'update']);
    Route::patch('/{match}/score', [MatchController::class, 'updateScore']);
    Route::delete('/{match}', [MatchController::class, 'destroy']);
    Route::get('/team/{teamId}', [MatchController::class, 'getMatchesForTeam']);
    Route::get('/tournament/{tournamentId}', [MatchController::class, 'getMatchesForTournament']);
});

// Match Event Routes
Route::prefix('match-events')->group(function () {
    Route::get('/', [MatchEventController::class, 'index']);
    Route::post('/', [MatchEventController::class, 'store']);
    Route::get('/{event}', [MatchEventController::class, 'show']);
    Route::put('/{event}', [MatchEventController::class, 'update']);
    Route::delete('/{event}', [MatchEventController::class, 'destroy']);
    Route::get('/match/{matchId}', [MatchEventController::class, 'getMatchEvents']);
    Route::get('/player/{playerId}/stats', [MatchEventController::class, 'getPlayerStats']);
});

// Achievement Routes
Route::prefix('achievements')->group(function () {
    Route::get('/', [AchievementController::class, 'index']);
    Route::post('/', [AchievementController::class, 'store']);
    Route::get('/{achievement}', [AchievementController::class, 'show']);
    Route::put('/{achievement}', [AchievementController::class, 'update']);
    Route::delete('/{achievement}', [AchievementController::class, 'destroy']);
    Route::get('/player/{playerId}', [AchievementController::class, 'getPlayerAchievements']);
    Route::get('/player/{playerId}/summary', [AchievementController::class, 'getPlayerAchievementsSummary']);
    Route::post('/player/{playerId}/check', [AchievementController::class, 'checkAndCreateAchievements']);
});