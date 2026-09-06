{{-- resources/views/player/teams/index.blade.php --}}
@extends('layouts.guest')

@section('title', '5ivezz - Teams Discovery')

@section('content')
<style>
    .glass-panel {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    .team-card {
        transition: all 0.3s ease;
    }
    .team-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }
</style>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-md md:px-lg pt-4 pb-24">
    <!-- Opening Section -->
    <section class="mb-lg pt-sm">
        <div class="flex items-center justify-between mb-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-2 h-2 rounded-full bg-primary"></div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">5IVEZZ / TEAMS</span>
                </div>
                <h2 class="font-display-lg text-[40px] md:text-display-lg text-on-background">Find your team.</h2>
            </div>
            
            <!-- CREATE TEAM BUTTON -->
            <a href="{{ route('player.teams.create') }}" 
               class="flex items-center gap-2 bg-primary text-on-primary px-6 py-3 rounded-full font-label-md text-label-md hover:bg-primary/90 transition-all active:scale-95 shadow-md">
                <span class="material-symbols-outlined">add</span>
                Create Team
            </a>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
            <button class="flex items-center gap-2 bg-surface-container-low px-4 py-2 rounded-full border border-outline-variant/30 active:scale-95 transition-transform">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">location_on</span>
                <span class="font-label-md text-label-md text-on-surface">Lagos, Nigeria</span>
                <span class="material-symbols-outlined text-on-surface-variant text-sm">expand_more</span>
            </button>
            <div class="flex gap-2 overflow-x-auto w-full sm:w-auto pb-2 sm:pb-0 scrollbar-hide">
                <button class="shrink-0 bg-primary text-on-primary px-5 py-2 rounded-full font-label-md text-label-md active:scale-95 transition-transform">All</button>
                <button class="shrink-0 bg-surface-container-highest text-on-surface-variant px-5 py-2 rounded-full font-label-md text-label-md hover:bg-surface-variant active:scale-95 transition-transform">Popular</button>
                <button class="shrink-0 bg-surface-container-highest text-on-surface-variant px-5 py-2 rounded-full font-label-md text-label-md hover:bg-surface-variant active:scale-95 transition-transform">Active</button>
                <button class="shrink-0 bg-surface-container-highest text-on-surface-variant px-5 py-2 rounded-full font-label-md text-label-md hover:bg-surface-variant active:scale-95 transition-transform">New</button>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-600">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Featured Team Surface -->
    @if($teams->isNotEmpty())
        <section class="mb-xl relative rounded-[24px] overflow-hidden group cursor-pointer">
            <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/40 to-transparent z-10"></div>
            <div class="h-[400px] w-full relative">
                @php $featured = $teams->first(); @endphp
                <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                     src="{{ $featured->cover_image_url ?? asset('images/Background image.png') }}" alt="{{ $featured->name }}" />
            </div>
            <div class="absolute bottom-0 left-0 w-full p-lg z-20 flex flex-col md:flex-row justify-between items-end gap-md">
                <div class="flex items-center gap-md">
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white rounded-2xl flex items-center justify-center shadow-lg p-2 shrink-0">
                        <img class="w-full h-full object-contain" src="{{ $featured->logo_url }}" alt="{{ $featured->name }}" />
                    </div>
                    <div>
                        <span class="inline-block bg-secondary-fixed/20 text-secondary-fixed backdrop-blur-md px-3 py-1 rounded-full font-label-sm text-label-sm mb-2 border border-secondary-fixed/30">FEATURED SQUAD</span>
                        <h3 class="font-headline-lg text-white mb-1">{{ $featured->name }}</h3>
                        <p class="font-body-md text-white/80 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">location_on</span> {{ $featured->city ?? $featured->location }}, {{ $featured->state ?? 'Nigeria' }}
                        </p>
                    </div>
                </div>
                <div class="flex gap-4 bg-black/30 backdrop-blur-md rounded-xl p-4 border border-white/10 w-full md:w-auto">
                    <div class="text-center">
                        <div class="font-headline-md text-secondary-fixed">{{ $featured->wins }}</div>
                        <div class="font-label-sm text-label-sm text-white/60">WINS</div>
                    </div>
                    <div class="w-[1px] bg-white/20"></div>
                    <div class="text-center">
                        <div class="font-headline-md text-white">{{ $featured->draws }}</div>
                        <div class="font-label-sm text-label-sm text-white/60">DRAWS</div>
                    </div>
                    <div class="w-[1px] bg-white/20"></div>
                    <div class="text-center">
                        <div class="font-headline-md text-error-container">{{ $featured->losses }}</div>
                        <div class="font-label-sm text-label-sm text-white/60">LOSSES</div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- No Teams Message -->
    @if($teams->isEmpty())
        <div class="text-center py-20">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">groups</span>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No teams yet</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">Be the first to create a team and start your football journey!</p>
            <a href="{{ route('player.teams.create') }}" 
               class="inline-flex items-center gap-2 bg-primary text-on-primary px-8 py-3 rounded-full font-label-md text-label-md hover:bg-primary/90 transition-all active:scale-95 shadow-md">
                <span class="material-symbols-outlined">add</span>
                Create Your Team
            </a>
        </div>
    @else
        <!-- Asymmetric Team Collection Grid -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-md mb-xl">
            @foreach($teams as $index => $team)
                @php
                    $type = $index % 4;
                @endphp

                @if($type == 0)
                    <!-- TYPE A: Identity -->
                    <div class="md:col-span-5 bg-white rounded-[20px] p-lg border border-black/5 shadow-[0_4px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow relative overflow-hidden group cursor-pointer team-card">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                        <a href="{{ route('player.teams.show', $team) }}" class="block">
                            <div class="flex justify-between items-start mb-xl relative z-10">
                                <div class="w-16 h-16 bg-surface-container rounded-xl flex items-center justify-center p-2">
                                    <img class="w-full h-full object-contain" src="{{ $team->logo_url }}" alt="{{ $team->name }}" />
                                </div>
                                <div class="bg-surface-container-low px-3 py-1 rounded-full font-label-sm text-label-sm text-on-surface-variant">Active</div>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-headline-md text-on-background mb-1">{{ $team->name }}</h4>
                                <p class="font-label-md text-on-surface-variant flex items-center gap-1 mb-4">
                                    <span class="material-symbols-outlined text-sm">location_on</span> {{ $team->city ?? $team->location ?? 'Location not set' }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="bg-surface-container px-3 py-1.5 rounded-lg font-label-md text-primary">{{ $team->wins }}W</div>
                                    <div class="bg-surface-container px-3 py-1.5 rounded-lg font-label-md text-on-surface-variant">{{ $team->draws }}D</div>
                                    <div class="bg-surface-container px-3 py-1.5 rounded-lg font-label-md text-on-surface-variant">{{ $team->losses }}L</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @elseif($type == 1)
                    <!-- TYPE B: Squad Focus -->
                    <div class="md:col-span-7 bg-surface-bright rounded-[20px] p-lg border border-black/5 shadow-[0_4px_12px_rgba(0,0,0,0.03)] hover:shadow-md transition-shadow flex flex-col justify-between group cursor-pointer relative overflow-hidden team-card">
                        <a href="{{ route('player.teams.show', $team) }}" class="block h-full">
                            <div class="absolute inset-0 bg-gradient-to-br from-tertiary/5 to-transparent pointer-events-none"></div>
                            <div class="flex justify-between items-start mb-6 relative z-10">
                                <div>
                                    <h4 class="font-headline-md text-on-background mb-1">{{ $team->name }}</h4>
                                    <p class="font-label-md text-on-surface-variant">{{ $team->players->count() }} players</p>
                                </div>
                                <span class="material-symbols-outlined text-tertiary bg-tertiary/10 p-2 rounded-full">group</span>
                            </div>
                            <div class="relative z-10 mt-auto">
                                <div class="flex items-center -space-x-4 mb-3">
                                    @foreach($team->players->take(4) as $player)
                                        <img class="w-12 h-12 rounded-full border-2 border-surface-bright object-cover" 
                                             src="{{ $player->avatar_url }}" alt="{{ $player->full_name }}" />
                                    @endforeach
                                    @if($team->players->count() > 4)
                                        <div class="w-12 h-12 rounded-full border-2 border-surface-bright bg-tertiary text-white flex items-center justify-center font-label-sm">+{{ $team->players->count() - 4 }}</div>
                                    @endif
                                </div>
                                <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $team->players->count() }} Active Players</p>
                            </div>
                        </a>
                    </div>
                @elseif($type == 2)
                    <!-- TYPE C: Record Emphasis -->
                    <div class="md:col-span-7 bg-[#1A1C19] rounded-[20px] p-lg shadow-lg hover:shadow-xl transition-shadow relative overflow-hidden group cursor-pointer team-card">
                        <a href="{{ route('player.teams.show', $team) }}" class="block h-full">
                            <div class="absolute right-0 top-0 w-1/2 h-full opacity-10" style="background-image: radial-gradient(circle at 100% 0%, #70fbc4 0%, transparent 70%);"></div>
                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div class="flex items-center gap-3 mb-6">
                                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                        <img class="w-8 h-8 object-contain" src="{{ $team->logo_url }}" alt="{{ $team->name }}" />
                                    </div>
                                    <h4 class="font-headline-sm text-white">{{ $team->name }}</h4>
                                </div>
                                <div class="mt-auto">
                                    <p class="font-label-sm text-secondary-fixed/80 uppercase tracking-widest mb-2">Current Season Record</p>
                                    <div class="flex items-baseline gap-2">
                                        <span class="font-display-lg text-[48px] text-white">{{ $team->wins }}</span><span class="font-label-md text-white/50">W</span>
                                        <span class="font-display-lg text-[48px] text-white ml-4">{{ $team->draws }}</span><span class="font-label-md text-white/50">D</span>
                                        <span class="font-display-lg text-[48px] text-error-container ml-4">{{ $team->losses }}</span><span class="font-label-md text-white/50">L</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <!-- TYPE D: Editorial -->
                    <div class="md:col-span-5 rounded-[20px] overflow-hidden relative shadow-md group cursor-pointer h-[250px] md:h-auto team-card">
                        <a href="{{ route('player.teams.show', $team) }}" class="block h-full">
                            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                 src="{{ $team->cover_image_url ?? asset('images/default-cover.jpg') }}" alt="{{ $team->name }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 w-full p-md">
                                <div class="bg-white/20 backdrop-blur-md rounded-full px-3 py-1 inline-block mb-2 border border-white/20">
                                    <span class="font-label-sm text-white">{{ $team->players->count() }} Players</span>
                                </div>
                                <h4 class="font-headline-md text-white leading-tight">{{ $team->name }}</h4>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </section>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $teams->links() }}
        </div>
    @endif
</main>
@endsection