{{-- resources/views/player/teams/show.blade.php --}}
@extends('layouts.guest')

@section('title', $team->name . ' - 5ivezz')

@section('content')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.5); opacity: 0; }
        }
        .pulse-dot::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            background-color: #00595c;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }
        .match-card {
            transition: all 0.2s ease;
        }
        .match-card:hover {
            background: rgba(0,0,0,0.02);
        }
        .player-card {
            transition: all 0.2s ease;
        }
        .player-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
    </style>

    <!-- Main Canvas -->
    <main class="pt-[20px] pb-[100px] max-w-[1200px] mx-auto px-md md:px-lg space-y-xl">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Hero: Verified Team Profile Surface -->
        <section class="bg-surface-container-lowest shadow-[0_4px_12px_rgba(0,0,0,0.03)] rounded-xl border border-black/5 p-lg md:p-xl flex flex-col md:flex-row gap-lg md:items-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2"></div>

            <div class="flex-shrink-0 flex justify-center md:justify-start">
                <div class="relative">
                    @if($team->logo)
                        <img class="w-32 h-32 md:w-40 md:h-40 rounded-full border border-outline-variant/20 bg-surface-container-low object-cover p-2 shadow-sm"
                            src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" />
                    @else
                        <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border border-outline-variant/20 bg-primary/10 flex items-center justify-center text-4xl font-bold text-primary">
                            {{ substr($team->name, 0, 2) }}
                        </div>
                    @endif
                    <div class="absolute bottom-2 right-2 bg-surface-container-lowest rounded-full p-1 shadow-sm border border-black/5">
                        <span class="material-symbols-outlined text-tertiary" style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                </div>
            </div>

            <div class="flex-grow flex flex-col gap-sm text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-sm md:gap-md">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">{{ $team->name }}</h2>
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-secondary-container/20 text-on-secondary-container rounded-full font-label-sm text-label-sm border border-secondary-container/30">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        Active Roster
                    </span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    {{ $team->description ?? 'A competitive football team playing in the 5ivezz league system.' }}
                </p>

                <div class="mt-md flex justify-center md:justify-start gap-xl">
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-primary tracking-tighter">{{ $teamStats->wins }}</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Wins</span>
                    </div>
                    <div class="w-px h-12 bg-outline-variant/30 self-center"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-on-surface-variant tracking-tighter">{{ $teamStats->draws }}</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Draws</span>
                    </div>
                    <div class="w-px h-12 bg-outline-variant/30 self-center"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-error tracking-tighter">{{ $teamStats->losses }}</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Losses</span>
                    </div>
                    <div class="w-px h-12 bg-outline-variant/30 self-center hidden md:block"></div>
                    <div class="flex flex-col items-center md:items-start hidden md:flex">
                        <span class="font-display-lg text-display-lg text-on-surface-variant tracking-tighter">{{ $teamStats->total }}</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Total</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-md">
            <div class="stat-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">Goals For</p>
                <p class="font-headline-lg text-headline-lg text-primary">{{ $teamStats->goals_for }}</p>
            </div>
            <div class="stat-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">Goals Against</p>
                <p class="font-headline-lg text-headline-lg text-error">{{ $teamStats->goals_against }}</p>
            </div>
            <div class="stat-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">Goal Difference</p>
                <p class="font-headline-lg text-headline-lg {{ $teamStats->goal_difference >= 0 ? 'text-primary' : 'text-error' }}">
                    {{ $teamStats->goal_difference >= 0 ? '+' : '' }}{{ $teamStats->goal_difference }}
                </p>
            </div>
            <div class="stat-card bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                <p class="font-label-sm text-label-sm text-on-surface-variant">Win Rate</p>
                <p class="font-headline-lg text-headline-lg text-on-surface">{{ $teamStats->win_percentage }}%</p>
            </div>
        </div>

        <!-- Actions -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-md">
            @auth
                @if($isMember)
                    <div class="md:col-span-2 bg-secondary-container/10 text-secondary-container rounded-xl px-lg py-4 flex items-center justify-between">
                        <span class="font-headline-sm text-headline-sm">
                            @if($userRole == 'captain')
                                👑 You're the Captain
                            @elseif($userRole == 'vice_captain')
                                ⭐ You're the Vice Captain
                            @else
                                ✅ You're a member of this team
                            @endif
                        </span>
                        <span class="material-symbols-outlined">check_circle</span>
                    </div>
                    @if($userRole != 'captain')
                        <form action="{{ route('player.teams.leave', $team) }}" method="POST" onsubmit="return confirm('Are you sure you want to leave this team?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-error/10 text-error rounded-xl px-lg py-4 hover:bg-error/20 transition-colors active:scale-[0.98] duration-200">
                                <span class="font-headline-sm text-headline-sm">Leave Team</span>
                            </button>
                        </form>
                    @endif
                @else
                    <form action="{{ route('player.teams.join') }}" method="POST" class="md:col-span-2">
                        @csrf
                        <input type="hidden" name="invite_code" value="{{ $team->invite_code }}">
                        <button type="submit" 
                                class="w-full bg-primary text-on-primary rounded-xl px-lg py-4 flex items-center justify-between shadow-[0_4px_12px_rgba(0,0,0,0.1)] hover:bg-primary/90 transition-colors active:scale-[0.98] duration-200 group">
                            <span class="font-headline-sm text-headline-sm">Join This Team</span>
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </button>
                    </form>
                @endif
            @else
                <div class="md:col-span-2 bg-surface-container-low border border-outline-variant/20 rounded-xl px-lg py-4">
                    <p class="font-body-md text-body-md text-on-surface-variant">Login to join this team</p>
                </div>
            @endauth

            <div class="bg-surface-container-low border border-outline-variant/20 rounded-xl p-md flex flex-col justify-center">
                <span class="font-label-sm text-label-sm text-on-surface-variant mb-xs uppercase tracking-wider">Invite Code</span>
                <div class="flex items-center justify-between bg-surface-container-lowest rounded-lg border border-outline-variant/30 p-sm">
                    <span class="font-label-md text-label-md text-on-surface font-mono">{{ $team->invite_code }}</span>
                    <button onclick="copyInviteCode('{{ $team->invite_code }}')"
                        class="text-primary hover:bg-primary/10 p-1 rounded transition-colors" title="Copy Invite Code">
                        <span class="material-symbols-outlined text-[20px]">content_copy</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Top Scorers -->
        @if($topScorers->isNotEmpty())
            <section class="space-y-md">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">sports_score</span>
                    Top Scorers
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-md">
                    @foreach($topScorers as $scorer)
                        <div class="bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center mx-auto mb-2">
                                <span class="material-symbols-outlined text-primary">sports_soccer</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface">{{ $scorer->player->first_name ?? 'Unknown' }}</p>
                            <p class="font-headline-sm text-headline-sm text-primary">{{ $scorer->goals }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Goals</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Upcoming Matches -->
        <section class="space-y-md">
            <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">event</span>
                Upcoming Matches
            </h3>
            
            @if($upcomingMatches->isNotEmpty())
                <div class="space-y-md">
                    @foreach($upcomingMatches as $match)
                        <div class="bg-surface-container-lowest shadow-sm rounded-xl border border-black/5 p-lg flex flex-col md:flex-row items-center justify-between gap-lg relative overflow-hidden hover:shadow-md transition-shadow">
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                            <div class="flex flex-col text-center md:text-left w-full md:w-auto">
                                @if($match->tournament)
                                    <span class="font-label-sm text-label-sm text-primary mb-1 uppercase tracking-wider">
                                        {{ $match->tournament->name }}
                                    </span>
                                @endif
                                <h4 class="font-headline-sm text-headline-sm text-on-surface">
                                    {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                </h4>
                                <p class="font-body-md text-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-1 mt-2">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                                    {{ $match->match_datetime->format('M d, Y • H:i') }}
                                </p>
                                @if($match->venue_name)
                                    <p class="font-body-md text-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-1 mt-1">
                                        <span class="material-symbols-outlined text-[16px]">location_on</span> 
                                        {{ $match->venue_name }}
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center gap-md w-full md:w-auto justify-center md:justify-end border-t md:border-t-0 md:border-l border-outline-variant/20 pt-md md:pt-0 md:pl-lg mt-sm md:mt-0">
                                <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">
                                    {{ $match->stage ?? 'Group Stage' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-8 text-center">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 48px;">event_available</span>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2">No upcoming matches scheduled</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant/60">Check back later for fixtures</p>
                </div>
            @endif
        </section>

        <!-- Recent Matches -->
        <section class="space-y-md">
            <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">history</span>
                Recent Matches
            </h3>
            
            @if($recentMatches->isNotEmpty())
                <div class="space-y-md">
                    @foreach($recentMatches as $match)
                        <div class="bg-surface-container-lowest shadow-sm rounded-xl border border-black/5 p-lg flex flex-col md:flex-row items-center justify-between gap-lg hover:shadow-md transition-shadow">
                            <div class="flex flex-col text-center md:text-left w-full md:w-auto">
                                @if($match->tournament)
                                    <span class="font-label-sm text-label-sm text-on-surface-variant mb-1 uppercase tracking-wider">
                                        {{ $match->tournament->name }}
                                    </span>
                                @endif
                                <h4 class="font-headline-sm text-headline-sm text-on-surface">
                                    {{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
                                </h4>
                                <p class="font-body-md text-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-2 mt-2">
                                    <span class="font-bold text-primary">{{ $match->home_score ?? '0' }}</span>
                                    <span class="text-on-surface-variant">-</span>
                                    <span class="font-bold {{ $match->winner == $match->awayTeam->name ? 'text-primary' : 'text-on-surface' }}">
                                        {{ $match->away_score ?? '0' }}
                                    </span>
                                    @if($match->winner)
                                        <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">
                                            {{ $match->winner }} won
                                        </span>
                                    @endif
                                </p>
                                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                                    {{ $match->match_datetime->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-8 text-center">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 48px;">sports_soccer</span>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2">No recent matches</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant/60">Your team hasn't played any matches yet</p>
                </div>
            @endif
        </section>

        <!-- Current Tournament -->
        @if($currentTournament)
            <section class="space-y-md">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">emoji_events</span>
                    Current Tournament
                </h3>
                <div class="bg-gradient-to-r from-primary/10 to-primary/5 rounded-xl border border-primary/20 p-lg relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative z-10">
                        <h4 class="font-headline-md text-headline-md text-on-surface">{{ $currentTournament->name }}</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1">
                            {{ $currentTournament->city }}, {{ $currentTournament->state }}
                        </p>
                        <div class="flex gap-4 mt-3">
                            <span class="font-label-sm text-label-sm text-primary">
                                {{ $currentTournament->tournament_start_date->format('M d') }} - 
                                {{ $currentTournament->tournament_end_date->format('M d, Y') }}
                            </span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">
                                {{ $currentTournament->number_of_teams ?? 'TBD' }} Teams
                            </span>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Tournament History -->
        @if($tournamentHistory->isNotEmpty())
            <section class="space-y-md">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Tournament History
                </h3>
                <div class="relative pl-6 ml-2 space-y-lg border-l-2 border-surface-container-high pb-md">
                    @foreach($tournamentHistory as $index => $tournament)
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full {{ $index === 0 ? 'bg-primary' : 'bg-outline-variant' }} border-4 border-surface shadow-sm {{ $index === 0 ? 'pulse-dot' : '' }}"></div>
                            <div class="bg-surface-container-lowest rounded-xl p-md border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:shadow-md transition-shadow cursor-default">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-label-md text-label-md text-on-surface font-bold">{{ $tournament->name }}</h4>
                                    <span class="font-label-sm text-label-sm text-outline">{{ $tournament->tournament_end_date->format('M Y') }}</span>
                                </div>
                                <p class="font-body-md text-body-md text-on-surface-variant text-sm">
                                    {{ $tournament->city }}, {{ $tournament->state }}
                                </p>
                                <div class="flex items-center gap-sm mt-2">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container-high text-on-surface-variant rounded font-label-sm text-[10px] uppercase tracking-wide">
                                        <span class="material-symbols-outlined text-[14px]">sports_soccer</span> 
                                        {{ $tournament->number_of_teams ?? 'Multiple' }} Teams
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container-high text-on-surface-variant rounded font-label-sm text-[10px] uppercase tracking-wide">
                                        <span class="material-symbols-outlined text-[14px]">event</span> 
                                        {{ $tournament->tournament_format ?? 'Standard' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Team Achievements -->
        @if($achievements->isNotEmpty())
            <section class="space-y-md">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">trophy</span>
                    Team Honours
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-md">
                    @foreach($achievements as $achievement)
                        <div class="bg-surface-container-lowest border border-black/5 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 rounded-full bg-secondary-container/20 text-secondary-container flex items-center justify-center mx-auto mb-2">
                                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">{{ $achievement->icon ?? 'trophy' }}</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface">{{ $achievement->title }}</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $achievement->achieved_date->format('M Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- The Squad -->
        <section class="space-y-md">
            <div class="flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">groups</span>
                    The Squad
                </h3>
                <span class="font-label-md text-label-md text-on-surface-variant">{{ $playerCount }} players</span>
            </div>
            
            @if($players->isNotEmpty())
                <div class="flex overflow-x-auto gap-md pb-md no-scrollbar snap-x snap-mandatory px-1">
                    @foreach($players as $player)
                        <div class="player-card flex-shrink-0 w-[140px] snap-start flex flex-col items-center bg-surface-container-lowest p-md rounded-xl border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                            @if($player->avatar)
                                <img class="w-16 h-16 rounded-full object-cover border-2 border-surface bg-surface-container-high mb-sm shadow-sm"
                                    src="{{ asset('storage/' . $player->avatar) }}" alt="{{ $player->full_name }}" />
                            @else
                                <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-xl font-bold text-primary border-2 border-surface">
                                    {{ substr($player->first_name, 0, 1) }}
                                </div>
                            @endif
                            <span class="font-label-md text-label-md text-on-surface text-center line-clamp-1">{{ $player->first_name }}</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant mt-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] uppercase">
                                {{ $player->pivot->role }}
                                @if($player->pivot->role == 'captain')
                                    👑
                                @endif
                            </span>
                            @if($player->pivot->jersey_number)
                                <span class="font-label-sm text-label-sm text-primary mt-1">#{{ $player->pivot->jersey_number }}</span>
                            @endif
                        </div>
                    @endforeach

                    @if($isMember && $userRole == 'captain')
                        <button class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center justify-center bg-surface-container-low/50 p-md rounded-xl border border-dashed border-outline-variant/50 hover:bg-surface-container-low transition-colors group">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform mb-sm">
                                <span class="material-symbols-outlined">add</span>
                            </div>
                            <span class="font-label-md text-label-md text-primary">Invite Player</span>
                        </button>
                    @endif
                </div>
            @else
                <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-8 text-center">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 48px;">group_off</span>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-2">No players yet</p>
                    <p class="font-body-sm text-body-sm text-on-surface-variant/60">Players will appear here when they join</p>
                </div>
            @endif
        </section>
    </main>

    @push('scripts')
        <script>
            function copyInviteCode(code) {
                navigator.clipboard.writeText(code).then(() => {
                    const btn = event.target.closest('button');
                    const icon = btn.querySelector('.material-symbols-outlined');
                    const originalText = icon.textContent;
                    icon.textContent = 'check';
                    setTimeout(() => {
                        icon.textContent = originalText;
                    }, 2000);
                });
            }
        </script>
    @endpush
@endsection