@extends('layouts.guest')

@section('title', '5ivezz - Home')

@section('content')
<style>
    .pt-16 {
        padding-top: 0;
    }
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }
    .hide-scroll {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .tournament-card {
        transition: all 0.3s ease;
    }
    .tournament-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    }
    .empty-state-icon {
        font-size: 64px;
        opacity: 0.4;
    }
</style>

<!-- Hero Section -->
<section class="relative w-full min-h-screen overflow-hidden mb-2xl">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-black/40 z-10"></div>
    <img class="absolute inset-0 w-full h-full object-cover z-0"
        data-alt="A striking, low-angle editorial photograph of a grassroots football player pausing on a dusty, sun-drenched local pitch in Lagos."
        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCv7uOy7yaw72YGx_ucHG69bM27ucIlLw01mropLm8BdNQsO8Pr0minwcWfTOi3L5KhrbsJqu9vq3LfsuD5gcwlTcNxgfXpy9HBk9o9nZG9CoVeWtvYM_xYYUkV3a7qjiKk4njMassO42iMSDBLMgNrSjhFIwKc6z4qj5CZ8UiZFzSYGB836DbC_DvzDWwfV23awpPC4e1GKGQ7RalJ9kWB7mD9ElhGtKDm8j92v4mpnEDnEWtu2-jQzA" />
    
    <!-- Content -->
    <div class="relative z-20 h-full min-h-screen flex flex-col justify-between p-md lg:p-xl pt-3xl">
        <!-- Brand Anchor -->
        <div class="flex items-center space-x-2 text-white">
            .
        </div>
        
        <!-- Bottom Content -->
        <div class="w-full flex flex-col lg:flex-row justify-between items-end pb-2xl lg:pb-xl gap-lg">
            <!-- Typography Poster -->
            <div class="max-w-2xl text-white">
                <h1 class="font-display-lg text-display-lg leading-tight mb-sm tracking-tighter drop-shadow-md">
                    Your Football.<br />
                    Your Record.<br />
                    <span class="text-primary-fixed">Your Future.</span>
                </h1>
                <p class="font-body-lg text-body-lg text-white/80 mt-4 max-w-lg drop-shadow-md">
                    {{ $platformStats->players }} players • {{ $platformStats->teams }} teams • {{ $platformStats->tournaments }} tournaments
                </p>
            </div>
            
            <!-- Floating Glass UI Cards -->
            <div class="flex flex-col sm:flex-row gap-md w-full lg:w-auto overflow-x-auto hide-scroll pb-4 lg:pb-0">
                <!-- Player Card -->
                @if($featuredPlayer)
                <div class="min-w-[280px] bg-white/10 backdrop-blur-2xl border border-white/20 rounded-xl p-md flex flex-col gap-sm text-white shadow-xl stat-card">
                    <div class="flex items-center gap-sm mb-2">
                        <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center shrink-0 overflow-hidden">
                            <img class="w-full h-full object-cover" src="{{ $featuredPlayer->avatar }}" alt="{{ $featuredPlayer->name }}" />
                        </div>
                        <div>
                            <h3 class="font-headline-sm text-headline-sm leading-tight font-bold">{{ $featuredPlayer->name }}</h3>
                            <p class="font-label-md text-label-md text-white/70">{{ $featuredPlayer->position }} • {{ $featuredPlayer->team }}</p>
                        </div>
                    </div>
                    <div class="flex justify-between border-t border-white/10 pt-sm mt-sm">
                        <div class="text-center">
                            <p class="font-label-sm text-label-sm text-white/70">Matches</p>
                            <p class="font-headline-md text-headline-md font-bold">{{ $featuredPlayer->matches }}</p>
                        </div>
                        <div class="w-px bg-white/10 mx-sm"></div>
                        <div class="text-center">
                            <p class="font-label-sm text-label-sm text-white/70">Goals</p>
                            <p class="font-headline-md text-headline-md font-bold">{{ $featuredPlayer->goals }}</p>
                        </div>
                        <div class="w-px bg-white/10 mx-sm"></div>
                        <div class="text-center">
                            <p class="font-label-sm text-label-sm text-white/70">Assists</p>
                            <p class="font-headline-md text-headline-md font-bold">{{ $featuredPlayer->assists }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Tournament Card -->
                @if($featuredTournament)
                <div class="min-w-[280px] bg-white/10 backdrop-blur-2xl border border-white/20 rounded-xl p-md flex flex-col gap-sm text-white shadow-xl relative overflow-hidden stat-card">
                    <div class="absolute top-0 right-0 w-16 h-16 bg-primary-container/40 blur-xl rounded-full translate-x-1/2 -translate-y-1/2">
                    </div>
                    <div class="flex items-start justify-between mb-2 z-10">
                        <div class="flex flex-col">
                            <span class="inline-block px-2 py-1 bg-secondary/20 border border-secondary-fixed/30 rounded-full font-label-sm text-label-sm text-secondary-fixed mb-sm w-max">
                                {{ $featuredTournament->status == 'published' ? 'Registration Open' : ucfirst($featuredTournament->status) }}
                            </span>
                            <h3 class="font-headline-sm text-headline-sm leading-tight font-bold pr-2">{{ $featuredTournament->name }}</h3>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">emoji_events</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-auto z-10 pt-sm">
                        <div class="flex items-center gap-xs text-white/80">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="font-label-md text-label-md">{{ $featuredTournament->teams_count }} Teams</span>
                        </div>
                        <button class="bg-primary text-on-primary font-label-md text-label-md px-4 py-2 rounded-full hover:bg-primary/90 transition-colors">
                            <a href="{{ route('explore.index') }}" class="text-inherit no-underline">Explore</a>
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Canvas Content -->
<div class="w-full max-w-[1200px] mx-auto min-h-screen">
    <!-- Platform Stats -->
    <section class="px-md lg:px-xl py-xl">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-md">
            <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-4 text-center shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                <p class="font-display-lg text-display-lg text-primary">{{ number_format($platformStats->players) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Players</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-4 text-center shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                <p class="font-display-lg text-display-lg text-primary">{{ number_format($platformStats->teams) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Teams</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-4 text-center shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                <p class="font-display-lg text-display-lg text-primary">{{ number_format($platformStats->tournaments) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Tournaments</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-4 text-center shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                <p class="font-display-lg text-display-lg text-primary">{{ number_format($platformStats->matches) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Matches</p>
            </div>
            <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-4 text-center shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
                <p class="font-display-lg text-display-lg text-primary">{{ number_format($platformStats->goals) }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant">Goals</p>
            </div>
        </div>
    </section>

    <!-- System Visualization Section -->
    <section class="px-md lg:px-xl py-2xl flex flex-col items-center text-center">
        <h2 class="font-display-lg text-display-lg mb-xl max-w-3xl text-on-background">Football deserves a <span class="text-primary font-bold">better system</span>.</h2>
        <div class="flex flex-wrap justify-center items-center gap-md lg:gap-xl w-full max-w-4xl mx-auto py-lg">
            <!-- Node 1 -->
            <div class="flex flex-col items-center gap-sm">
                <div class="w-16 h-16 rounded-2xl bg-surface-container-high border border-outline-variant/30 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary text-3xl">person</span>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Player</span>
            </div>
            <span class="material-symbols-outlined text-outline-variant hidden sm:block">arrow_forward</span>
            <!-- Node 2 -->
            <div class="flex flex-col items-center gap-sm">
                <div class="w-16 h-16 rounded-2xl bg-surface-container-high border border-outline-variant/30 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary text-3xl">groups</span>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Team</span>
            </div>
            <span class="material-symbols-outlined text-outline-variant hidden sm:block">arrow_forward</span>
            <!-- Node 3 -->
            <div class="flex flex-col items-center gap-sm">
                <div class="w-16 h-16 rounded-2xl bg-surface-container-high border border-outline-variant/30 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary text-3xl">emoji_events</span>
                </div>
                <span class="font-label-md text-label-md text-on-surface-variant font-medium">Tournament</span>
            </div>
            <span class="material-symbols-outlined text-outline-variant hidden sm:block">arrow_forward</span>
            <!-- Node 4 -->
            <div class="flex flex-col items-center gap-sm">
                <div class="w-16 h-16 rounded-2xl bg-primary text-on-primary shadow-md flex items-center justify-center ring-4 ring-primary-container/20">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">analytics</span>
                </div>
                <span class="font-label-md text-label-md text-primary font-bold">Record</span>
            </div>
        </div>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mt-lg">Stop losing your stats in group chats. 5ivezz builds a permanent, professional record of your grassroots journey, bridging the gap between local pitches and global opportunities.</p>
    </section>

    <!-- Player Identity Moment -->
    <section class="px-md lg:px-xl py-2xl">
        <div class="bg-surface-container-low rounded-xl border border-outline-variant/20 overflow-hidden shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-col lg:flex-row">
            <div class="w-full lg:w-1/2 h-64 lg:h-auto relative">
                <img class="w-full h-full object-cover"
                    data-alt="A clean, highly stylized studio portrait of a young African football player looking confidently off-camera."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfqXf_cJ63gGRfzKkKhNESpsPEtgqZezI7soIvYy_prvrFZw0X6zWBq57rA-_pgtQrsMNDAGaQD_ZLYIlxdPCQreo3ruxPUC-K84BlKXWrM6Lg9y90-yVRkwyJbMBCNnImMjpvixHm7LtJ_La-4n2FHLdt5WofzRyW9JFYYKAlvLGwmCwAFdlriglhXPaIXGVNyQVL4bXTgbgxYNlsIaA2YCZyLqcyk8hQ0ytxUHSRLSzHCSDVFeZbtg" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent lg:hidden"></div>
                <div class="absolute bottom-0 left-0 p-md lg:hidden text-white">
                    <h3 class="font-headline-lg text-headline-lg font-bold">Your Identity.</h3>
                </div>
            </div>
            <div class="w-full lg:w-1/2 p-lg lg:p-2xl flex flex-col justify-center">
                <h3 class="font-headline-lg text-headline-lg font-bold mb-md text-on-surface hidden lg:block">Your Identity. Formed on the pitch.</h3>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-xl">Every match played, every goal scored, permanently linked to your profile. Build a digital CV that proves your worth to scouts, clubs, and peers.</p>
                <div class="space-y-4">
                    <div class="bg-surface rounded-lg p-md border border-outline-variant/20 flex items-center gap-md">
                        <div class="w-10 h-10 rounded-full bg-primary-container/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">query_stats</span>
                        </div>
                        <div>
                            <h4 class="font-label-md text-label-md font-bold text-on-surface">Verified Match Data</h4>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Stats authenticated by tournament organizers.</p>
                        </div>
                    </div>
                    <div class="bg-surface rounded-lg p-md border border-outline-variant/20 flex items-center gap-md">
                        <div class="w-10 h-10 rounded-full bg-primary-container/10 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">share</span>
                        </div>
                        <div>
                            <h4 class="font-label-md text-label-md font-bold text-on-surface">Shareable Player Card</h4>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Export your real-time stats to social media instantly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tournament Discovery Section -->
    <section class="px-md lg:px-xl py-2xl">
        <div class="mb-xl flex flex-col md:flex-row md:items-end justify-between gap-md">
            <div>
                <h2 class="font-display-lg text-display-lg font-bold text-on-background mb-sm">On the pitch.</h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">Discover premium grassroots tournaments happening near you. Real competition, documented permanently.</p>
            </div>
            <a href="{{ route('explore.index') }}" class="w-max font-label-md text-label-md text-primary flex items-center gap-xs hover:text-primary-container transition-colors group">
                View all tournaments
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
        
        @if($activeTournaments->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-md lg:gap-lg">
            @foreach($activeTournaments as $tournament)
            <div class="group cursor-pointer flex flex-col bg-surface rounded-xl border border-outline-variant/20 overflow-hidden shadow-sm hover:shadow-md transition-shadow tournament-card">
                <div class="h-48 relative overflow-hidden">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        data-alt="{{ $tournament->name }}"
                        src="{{ $tournament->cover_image ?? 'https://images.unsplash.com/photo-1459865264687-595d652de67e?w=400&h=300&fit=crop' }}" />
                    <div class="absolute top-sm right-sm {{ $tournament->status_class }} font-label-sm text-label-sm px-2 py-1 rounded shadow-sm">
                        {{ $tournament->status_display }}
                    </div>
                </div>
                <div class="p-md flex flex-col flex-grow">
                    <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface mb-xs line-clamp-1">{{ $tournament->name }}</h3>
                    <div class="flex items-center gap-xs text-on-surface-variant mb-md">
                        <span class="material-symbols-outlined text-sm">location_on</span>
                        <span class="font-label-sm text-label-sm">{{ $tournament->city }}, {{ $tournament->state }}</span>
                    </div>
                    <div class="mt-auto flex justify-between items-center pt-md border-t border-outline-variant/20">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Prize Pool</span>
                            <span class="font-label-md text-label-md font-bold text-on-surface">
                                @if($tournament->winner_prize)
                                    ₦{{ number_format($tournament->winner_prize, 0) }}
                                @else
                                    TBA
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-xs text-primary bg-primary/5 px-2 py-1 rounded-md">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span class="font-label-sm text-label-sm font-bold">
                                {{ $tournament->teams_count }}/{{ $tournament->max_teams }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl border border-black/5 p-12 text-center">
            <div class="flex flex-col items-center">
                <span class="material-symbols-outlined empty-state-icon text-on-surface-variant">emoji_events</span>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-4 mb-2">No active tournaments right now</h3>
                <p class="text-on-surface-variant text-body-md max-w-md mx-auto">
                    Check back soon for upcoming tournaments in your area. 
                    Tournaments will appear here when organizers publish them.
                </p>
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('explore.index') }}" class="bg-primary text-on-primary px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                        Explore Tournaments
                    </a>
                    @auth
                        <a href="{{ route('player.teams.index') }}" class="bg-surface border border-outline-variant px-6 py-2 rounded-lg hover:bg-surface-container-low transition-colors">
                            Find a Team
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @endif
    </section>

    <!-- Conversion Moment -->
    <section class="px-md lg:px-xl py-3xl mb-xl">
        <div class="bg-primary text-on-primary rounded-2xl p-xl lg:p-3xl text-center flex flex-col items-center shadow-xl relative overflow-hidden">
            <!-- Abstract background shapes -->
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary-fixed/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-secondary-fixed/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <span class="material-symbols-outlined text-5xl mb-md opacity-90" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                <h2 class="font-display-lg text-display-lg font-bold mb-sm tracking-tight">Running a tournament?</h2>
                <p class="font-body-lg text-body-lg text-primary-container-lowest/80 max-w-xl mx-auto mb-xl">Stop managing brackets on spreadsheets. Give your teams a professional digital experience.</p>
                <h3 class="font-headline-lg text-headline-lg font-bold mb-lg text-primary-fixed">Put it on 5ivezz.</h3>
                <button class="bg-white text-primary font-label-md text-label-md font-bold px-8 py-4 rounded-full shadow-lg hover:scale-105 active:scale-95 transition-all duration-200">
                    <a href="{{ route('organizer.register') }}" class="text-inherit no-underline">Register your tournament</a>
                </button>
            </div>
        </div>
    </section>
</div>
@endsection