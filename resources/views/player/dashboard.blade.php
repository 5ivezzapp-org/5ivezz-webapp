{{-- resources/views/player/dashboard.blade.php --}}
@extends('layouts.guest')

@section('title', '5ivezz Player Command Center')

@section('content')
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .safe-padding {
            padding-bottom: 120px;
        }

        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 {
            animation-delay: 0.1s;
        }
        .delay-2 {
            animation-delay: 0.2s;
        }
        .delay-3 {
            animation-delay: 0.3s;
        }
        .delay-4 {
            animation-delay: 0.4s;
        }
        .delay-5 {
            animation-delay: 0.5s;
        }

        .magnetic-btn:active {
            transform: scale(0.98);
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }
        .stat-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .empty-state-icon {
            font-size: 48px;
            opacity: 0.4;
        }

        .match-card {
            transition: all 0.2s ease;
        }
        .match-card:hover {
            background: #f8f9fa;
        }
    </style>

    <!-- Main Content Canvas -->
    <main class="max-w-[1200px] mx-auto px-md md:px-lg lg:px-xl pt-xl safe-padding">
        <!-- 1. Header -->
        <header class="flex justify-between items-center mb-lg fade-in-up">
            <div>
                @php
                    $hour = date('H');
                    $greeting = 'afternoon';
                    if ($hour < 12) $greeting = 'morning';
                    else if ($hour < 17) $greeting = 'afternoon';
                    else $greeting = 'evening';
                @endphp
                <p class="font-body-md text-body-md text-on-surface-variant">Good {{ $greeting }},</p>
                <div class="flex items-center gap-xs">
                    <h1 class="font-headline-lg text-headline-lg text-on-surface tracking-tight">{{ $user->first_name }}</h1>
                    <span class="material-symbols-outlined text-primary"
                        style="font-variation-settings: 'FILL' 1;">verified</span>
                </div>
            </div>
            <div
                class="w-12 h-12 rounded-full bg-surface-container-highest overflow-hidden border border-outline-variant/30">
                <img class="w-full h-full object-cover" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $user->full_name }}" />
            </div>
        </header>

        <!-- 2. Player Identity Strip -->
        <section
            class="mb-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-md border-b border-surface-container-highest pb-lg fade-in-up delay-1">
            <div class="flex items-center gap-sm">
                <span class="material-symbols-outlined text-on-surface-variant">sports_soccer</span>
                <p class="font-body-lg text-body-lg text-on-surface-variant">
                    {{ $user->full_name }}
                    <span class="mx-xs text-outline-variant">|</span>
                    <strong class="text-on-surface">{{ strtoupper($user->position ?? 'N/A') }}</strong>
                    <span class="mx-xs text-outline-variant">·</span>
                    {{ $team ? $team->name : 'No Team' }}
                    <span class="mx-xs text-outline-variant">·</span>
                    {{ $user->city ?? 'Location not set' }}
                </p>
            </div>
            <a href="{{ route('player.profile') }}"
                class="magnetic-btn bg-surface-container-lowest text-on-surface border border-outline-variant/50 hover:bg-surface-container-low transition-colors px-md py-xs rounded-full font-label-md text-label-md flex items-center gap-xs w-fit">
                View Football Profile
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </section>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 fade-in-up delay-1">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl">
            <!-- Left Column / Main Flow -->
            <div class="lg:col-span-8 flex flex-col gap-2xl">
                <!-- 3. Next Match (Hero) -->
                @if($nextMatch)
                    <section
                        class="relative rounded-2xl overflow-hidden bg-on-surface text-surface-container-lowest shadow-[0_4px_24px_rgba(0,0,0,0.1)] fade-in-up delay-2 group">
                        <div class="absolute inset-0 opacity-20 pointer-events-none mix-blend-overlay"
                            style="background-image: url('https://images.unsplash.com/photo-1459865264687-595d652de67e?w=1200&h=400&fit=crop'); background-size: cover; background-position: center;">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-on-surface/90 to-transparent pointer-events-none">
                        </div>
                        <div class="relative z-10 p-lg md:p-xl flex flex-col h-full justify-between min-h-[320px]">
                            <div class="flex justify-between items-start">
                                <div
                                    class="bg-primary/20 backdrop-blur-sm border border-primary/30 text-primary-fixed px-sm py-base rounded-full font-label-sm text-label-sm flex items-center gap-xs uppercase tracking-wider">
                                    <span class="w-2 h-2 rounded-full bg-primary-fixed animate-pulse"></span>
                                    Next Match
                                </div>
                                <p class="font-label-md text-label-md text-outline-variant text-right">
                                    {{ $nextMatch->match_datetime->format('M d, H:i') }}<br />
                                    {{ $nextMatch->venue_name ?? 'Venue TBD' }}
                                </p>
                            </div>
                            <div class="mt-xl">
                                @if($nextMatch->tournament)
                                    <p class="font-label-sm text-label-sm text-primary-fixed mb-xs uppercase tracking-widest">
                                        {{ $nextMatch->tournament->name }}
                                    </p>
                                @endif
                                <h2 class="font-display-lg text-display-lg leading-tight mb-lg max-w-[80%]">
                                    {{ $nextMatch->homeTeam->name }}<br />
                                    <span class="text-outline-variant text-3xl mx-sm">VS</span>
                                    {{ $nextMatch->awayTeam->name }}
                                </h2>
                                <a href="{{ route('player.teams.show', $team) }}"
                                    class="magnetic-btn bg-primary text-on-primary hover:bg-primary/90 transition-colors px-lg py-sm rounded-full font-label-md text-label-md flex items-center gap-sm w-fit">
                                    View Match Details
                                    <span class="material-symbols-outlined">arrow_outward</span>
                                </a>
                            </div>
                        </div>
                    </section>
                @else
                    <section
                        class="relative rounded-2xl overflow-hidden bg-on-surface text-surface-container-lowest shadow-[0_4px_24px_rgba(0,0,0,0.1)] fade-in-up delay-2 group">
                        <div class="absolute inset-0 opacity-20 pointer-events-none mix-blend-overlay"
                            style="background-image: url('https://images.unsplash.com/photo-1459865264687-595d652de67e?w=1200&h=400&fit=crop'); background-size: cover; background-position: center;">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-on-surface/90 to-transparent pointer-events-none">
                        </div>
                        <div class="relative z-10 p-lg md:p-xl flex flex-col h-full justify-between min-h-[320px]">
                            <div class="flex justify-between items-start">
                                <div
                                    class="bg-primary/20 backdrop-blur-sm border border-primary/30 text-primary-fixed px-sm py-base rounded-full font-label-sm text-label-sm flex items-center gap-xs uppercase tracking-wider">
                                    <span class="w-2 h-2 rounded-full bg-primary-fixed animate-pulse"></span>
                                    Next Match
                                </div>
                            </div>
                            <div class="mt-xl">
                                <h2 class="font-display-lg text-display-lg leading-tight mb-lg">
                                    @if(!$team)
                                        Join a team to<br />
                                        <span class="text-outline-variant">start competing!</span>
                                    @else
                                        No upcoming matches<br />
                                        <span class="text-outline-variant text-3xl">Stay tuned for fixtures</span>
                                    @endif
                                </h2>
                                <a href="{{ $team ? route('player.teams.show', $team) : route('player.teams.index') }}"
                                    class="magnetic-btn bg-primary text-on-primary hover:bg-primary/90 transition-colors px-lg py-sm rounded-full font-label-md text-label-md flex items-center gap-sm w-fit">
                                    {{ $team ? 'View Team' : 'Find a Team' }}
                                    <span class="material-symbols-outlined">arrow_outward</span>
                                </a>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- 4. Your Record -->
                <section class="fade-in-up delay-3">
                    <div class="flex items-center justify-between mb-md">
                        <h3 class="font-headline-md text-headline-md text-on-surface">Your Record</h3>
                        <div class="flex items-center gap-xs text-primary bg-primary/10 px-sm py-base rounded-full">
                            <span class="material-symbols-outlined text-[16px]"
                                style="font-variation-settings: 'FILL' 1;">verified_user</span>
                            <span class="font-label-sm text-label-sm">Verified Record</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-md">
                        <div class="stat-card rounded-xl p-md flex flex-col relative overflow-hidden">
                            <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Matches</p>
                            <p class="font-display-lg text-display-lg text-on-surface">{{ $stats['matches'] ?? 0 }}</p>
                        </div>
                        <div class="stat-card rounded-xl p-md flex flex-col relative overflow-hidden">
                            <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Goals</p>
                            <p class="font-display-lg text-display-lg text-on-surface">{{ $stats['goals'] ?? 0 }}</p>
                        </div>
                        <div class="stat-card rounded-xl p-md flex flex-col relative overflow-hidden">
                            <p class="font-label-md text-label-md text-on-surface-variant mb-xs">Assists</p>
                            <p class="font-display-lg text-display-lg text-on-surface">{{ $stats['assists'] ?? 0 }}</p>
                        </div>
                    </div>
                    @if(($stats['matches'] ?? 0) == 0)
                        <div class="text-center py-4 text-on-surface-variant">
                            <p class="text-sm">No match records yet. Start playing to build your stats!</p>
                        </div>
                    @endif
                </section>

                <!-- 5. Upcoming & Recent Matches -->
                <section class="fade-in-up delay-4">
                    <div class="flex items-center justify-between mb-md">
                        <h3 class="font-headline-md text-headline-md text-on-surface">Matches</h3>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Upcoming · Recent</span>
                    </div>

                    @if($matches->hasMatches)
                        <!-- Upcoming Matches -->
                        @if($matches->upcoming->isNotEmpty())
                            <div class="mb-4">
                                <p class="font-label-sm text-label-sm text-primary mb-2">Upcoming</p>
                                @foreach($matches->upcoming as $match)
                                    <div class="match-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 mb-2 shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4 flex-1">
                                                <div class="text-sm font-medium text-on-surface">
                                                    {{ $match->homeTeam->name }}
                                                </div>
                                                <span class="text-on-surface-variant text-xs">VS</span>
                                                <div class="text-sm font-medium text-on-surface">
                                                    {{ $match->awayTeam->name }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-on-surface-variant">
                                                    {{ $match->match_datetime->format('M d, H:i') }}
                                                </p>
                                                <p class="text-xs text-primary">
                                                    {{ $match->stage ?? 'Group Stage' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Recent Matches -->
                        @if($matches->recent->isNotEmpty())
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant mb-2">Recent</p>
                                @foreach($matches->recent as $match)
                                    <div class="match-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 mb-2 shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-4 flex-1">
                                                <div class="text-sm font-medium text-on-surface">
                                                    {{ $match->homeTeam->name }}
                                                </div>
                                                <span class="font-bold text-on-surface">
                                                    {{ $match->home_score ?? 0 }} - {{ $match->away_score ?? 0 }}
                                                </span>
                                                <div class="text-sm font-medium text-on-surface">
                                                    {{ $match->awayTeam->name }}
                                                </div>
                                                @if($match->winner)
                                                    <span class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                        {{ $match->winner }} won
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-on-surface-variant">
                                                    {{ $match->match_datetime->format('M d') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="bg-surface-container-lowest border border-black/5 rounded-2xl p-8 text-center">
                            <span class="material-symbols-outlined empty-state-icon text-on-surface-variant">sports_soccer</span>
                            <p class="font-body-lg text-body-lg text-on-surface-variant mt-2">No matches found</p>
                            <p class="font-body-md text-body-md text-on-surface-variant/60">
                                @if(!$team)
                                    Join a team to start playing matches!
                                @else
                                    Your team hasn't played any matches yet. Check back soon!
                                @endif
                            </p>
                        </div>
                    @endif
                </section>

                <!-- 6. Your Team & 7. Your Tournament (Bento Grid) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-md fade-in-up delay-5">
                    <!-- Team Card -->
                    @if($team)
                        <a href="{{ route('player.teams.show', $team) }}"
                            class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-col justify-between min-h-[240px] hover:shadow-md transition-shadow cursor-pointer group">
                            <div class="flex justify-between items-start">
                                <div
                                    class="w-12 h-12 rounded-lg bg-surface-container-highest flex items-center justify-center overflow-hidden">
                                    <img class="w-full h-full object-cover p-2" src="{{ $team->logo ? asset('storage/' . $team->logo) : asset('images/default-team.png') }}"
                                        alt="{{ $team->name }}" />
                                </div>
                                <span
                                    class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">north_east</span>
                            </div>
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs uppercase tracking-widest">
                                    Your Team</p>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">{{ $team->name }}</h4>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    {{ $team->players()->count() }} Players · 
                                    {{ $team->wins }}W - {{ $team->draws }}D - {{ $team->losses }}L
                                </p>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('player.teams.index') }}"
                            class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-col justify-between min-h-[240px] hover:shadow-md transition-shadow cursor-pointer group">
                            <div class="flex justify-between items-start">
                                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined"
                                        style="font-variation-settings: 'FILL' 1;">group_add</span>
                                </div>
                                <span
                                    class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">north_east</span>
                            </div>
                            <div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs uppercase tracking-widest">
                                    No Team Yet</p>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Find or Create a Team</h4>
                                <p class="font-body-md text-body-md text-primary font-medium flex items-center gap-xs">
                                    Get started now
                                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </p>
                            </div>
                        </a>
                    @endif

                    <!-- Tournament Card -->
                    <div
                        class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-col justify-between min-h-[240px] hover:shadow-md transition-shadow cursor-pointer group relative overflow-hidden">
                        <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary/5 rounded-full pointer-events-none">
                        </div>
                        <div class="flex justify-between items-start relative z-10">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined"
                                    style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                            </div>
                            <span
                                class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">north_east</span>
                        </div>
                        <div class="relative z-10">
                            <p class="font-label-sm text-label-sm text-on-surface-variant mb-xs uppercase tracking-widest">
                                Active Tournament</p>
                            @if($tournaments->hasTournaments)
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">
                                    {{ $tournaments->items->first()->name ?? 'Tournament' }}
                                </h4>
                                @if($team)
                                    <p class="font-body-md text-body-md text-primary font-medium flex items-center gap-xs">
                                        @if($nextMatch)
                                            Next match: {{ $nextMatch->match_datetime->format('M d') }}
                                        @else
                                            Check fixtures
                                        @endif
                                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                    </p>
                                @else
                                    <p class="font-body-md text-body-md text-on-surface-variant">
                                        Join a team to compete
                                    </p>
                                @endif
                            @else
                                <h4 class="font-headline-sm text-headline-sm text-on-surface mb-xs">No Active Tournaments</h4>
                                <p class="font-body-md text-body-md text-on-surface-variant">
                                    @if($team)
                                        Your team hasn't joined any tournaments yet
                                    @else
                                        Join a team to start competing in tournaments
                                    @endif
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column / Sidebar -->
            <div class="lg:col-span-4 flex flex-col gap-xl fade-in-up delay-3">
                <!-- 7. 5ivezz Wallet (Coming Soon) -->
                <div
                    class="bg-on-surface text-surface-container-lowest rounded-2xl p-lg relative overflow-hidden shadow-[0_4px_24px_rgba(0,0,0,0.1)]">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent pointer-events-none"></div>
                    <div
                        class="absolute top-0 right-0 bg-surface-container-lowest/10 backdrop-blur-md px-sm py-base rounded-bl-lg font-label-sm text-label-sm tracking-widest uppercase">
                        Coming Soon</div>
                    <div class="flex items-center gap-sm mb-lg opacity-60">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        <p class="font-label-md text-label-md">5ivezz Wallet</p>
                    </div>
                    <p class="font-display-lg text-display-lg mb-sm opacity-50 select-none">₦ ———</p>
                    <p class="font-body-md text-body-md text-outline-variant opacity-60">Secure grassroots payouts and match
                        fee management directly in the app.</p>
                </div>

                <!-- 8. Honours / Achievements -->
                <div
                    class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Honours</h3>
                    
                    @if($achievements->hasAchievements)
                        <div class="flex flex-col gap-sm">
                            @foreach($achievements->items as $achievement)
                                <div
                                    class="flex items-center gap-md p-sm rounded-lg hover:bg-surface-container-low transition-colors cursor-default">
                                    <div
                                        class="w-10 h-10 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[20px]"
                                            style="font-variation-settings: 'FILL' 1;">{{ $achievement->icon ?? 'trophy' }}</span>
                                    </div>
                                    <div>
                                        <p class="font-label-md text-label-md text-on-surface">{{ $achievement->title }}</p>
                                        <p class="font-label-sm text-label-sm text-on-surface-variant">
                                            {{ $achievement->achieved_date->format('M Y') }}
                                            @if($achievement->team)
                                                · {{ $achievement->team->name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($achievements->count > 3)
                                <a href="#" class="text-primary text-sm font-medium text-center hover:underline">
                                    View all {{ $achievements->count }} honours
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6">
                            <span class="material-symbols-outlined empty-state-icon text-on-surface-variant">military_tech</span>
                            <p class="font-body-md text-body-md text-on-surface-variant mt-2">No honours yet</p>
                            <p class="font-body-sm text-body-sm text-on-surface-variant/60">Start competing to earn achievements!</p>
                        </div>
                    @endif
                </div>

                <!-- 9. Football Journey (Minimalist Timeline) -->
                <div
                    class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-lg">Journey</h3>
                    <div class="relative pl-sm border-l-2 border-surface-container-highest space-y-md">
                        <div class="relative">
                            <div
                                class="absolute -left-[21px] top-1 w-3 h-3 bg-primary rounded-full border-2 border-surface-container-lowest">
                            </div>
                            <div class="pl-md">
                                <p class="font-label-sm text-label-sm text-primary mb-1">Present</p>
                                <p class="font-label-md text-label-md text-on-surface">
                                    {{ $team ? $team->name : 'Free Agent' }}
                                </p>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">
                                    {{ $team ? 'Senior Squad · ' . strtoupper($user->position ?? 'N/A') : 'Looking for a team' }}
                                </p>
                            </div>
                        </div>
                        
                        @if($achievements->hasAchievements)
                            @foreach($achievements->items->take(2) as $achievement)
                                <div class="relative">
                                    <div
                                        class="absolute -left-[21px] top-1 w-3 h-3 bg-outline-variant rounded-full border-2 border-surface-container-lowest">
                                    </div>
                                    <div class="pl-md">
                                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">
                                            {{ $achievement->achieved_date->format('M Y') }}
                                        </p>
                                        <p class="font-label-md text-label-md text-on-surface">{{ $achievement->title }}</p>
                                        <p class="font-label-sm text-label-sm text-on-surface-variant">
                                            {{ $achievement->description ?? 'Achievement unlocked' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="relative">
                                <div
                                    class="absolute -left-[21px] top-1 w-3 h-3 bg-outline-variant/30 rounded-full border-2 border-surface-container-lowest">
                                </div>
                                <div class="pl-md">
                                    <p class="font-label-sm text-label-sm text-on-surface-variant/60">No journey milestones yet</p>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant/60">Start playing to build your legacy</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            // Dynamic greeting is now handled in PHP
            console.log('5ivezz Player Dashboard loaded');
        </script>
    @endpush
@endsection