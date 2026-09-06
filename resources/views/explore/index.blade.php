@extends('layouts.guest')

@section('title', 'PitchMaster Africa — Explore: The Football Universe')

@section('content')
<main class="max-w-7xl mx-auto px-md md:px-xl pt-2xl pb-xl">
    <!-- Hero Section -->
    <header class="mb-xl">
        <div class="flex items-center gap-2 mb-xs text-primary font-label-md uppercase tracking-wider">
            <span class="material-symbols-outlined text-[18px]">public</span>
            The Football Universe
        </div>
        <h1 class="font-display-lg text-display-lg text-on-surface mb-xs tracking-tight">Explore</h1>
        <p class="font-body-lg text-on-surface-variant max-w-xl">Players. Teams. Tournaments. Your football world starts here.</p>
    </header>

    <!-- Universal Search & Filter Bar -->
    <div class="mb-xl space-y-md">
        <form action="{{ route('explore.index') }}" method="GET" class="relative flex items-center">
            <span class="absolute left-md text-outline material-symbols-outlined text-[24px]">search</span>
            <input class="w-full bg-surface-container-lowest border border-outline-variant/40 rounded-xl py-md pl-[52px] pr-xl text-on-surface placeholder:text-outline focus:outline-none focus:border-primary-container focus:ring-2 focus:ring-primary-container/20 transition-all shadow-sm" 
                   id="global-search" 
                   name="search"
                   placeholder="Search players, teams or tournaments..." 
                   type="text"
                   value="{{ request('search') }}"/>
            <button type="submit" class="absolute right-md bg-primary text-on-primary px-md py-xs rounded-lg text-label-md flex items-center gap-1 transition-colors hover:bg-primary/90">
                <span class="material-symbols-outlined text-[18px]">search</span>
                Search
            </button>
        </form>
        
        <!-- Category Switcher -->
        <div class="flex gap-xs overflow-x-auto pb-xs scrollbar-none" id="category-switcher">
            <a href="{{ route('explore.index', ['category' => 'all']) }}" 
               class="category-pill {{ $category == 'all' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant' }} px-lg py-sm rounded-full text-label-md font-medium whitespace-nowrap transition-all">
                Everything
            </a>
            <a href="{{ route('explore.index', ['category' => 'players']) }}" 
               class="category-pill {{ $category == 'players' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant' }} px-lg py-sm rounded-full text-label-md font-medium whitespace-nowrap transition-all">
                Players
            </a>
            <a href="{{ route('explore.index', ['category' => 'teams']) }}" 
               class="category-pill {{ $category == 'teams' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant' }} px-lg py-sm rounded-full text-label-md font-medium whitespace-nowrap transition-all">
                Teams
            </a>
            <a href="{{ route('explore.index', ['category' => 'tournaments']) }}" 
               class="category-pill {{ $category == 'tournaments' ? 'bg-primary-container text-on-primary-container shadow-sm' : 'bg-surface-container-low text-on-surface-variant' }} px-lg py-sm rounded-full text-label-md font-medium whitespace-nowrap transition-all">
                Tournaments
            </a>
        </div>
    </div>

    <!-- Search Results -->
    @if(request('search') && !empty(request('search')))
        @php
            $searchResults = App\Models\Tournament::where('name', 'LIKE', '%' . request('search') . '%')
                ->where('status', '!=', 'draft')
                ->limit(3)
                ->get();
            $searchTeams = App\Models\Team::where('name', 'LIKE', '%' . request('search') . '%')
                ->where('status', 'active')
                ->withCount('players')
                ->limit(3)
                ->get();
            $searchPlayers = App\Models\User::where(function($q) use ($searchTerm) {
                    $q->where('first_name', 'LIKE', '%' . request('search') . '%')
                      ->orWhere('last_name', 'LIKE', '%' . request('search') . '%');
                })
                ->where('is_active', true)
                ->limit(3)
                ->get();
            $hasResults = $searchResults->isNotEmpty() || $searchTeams->isNotEmpty() || $searchPlayers->isNotEmpty();
        @endphp
        
        @if($hasResults)
            <section class="mb-2xl">
                <h2 class="font-headline-md text-headline-md text-on-surface mb-md">Search Results for "{{ request('search') }}"</h2>
                <div class="grid grid-cols-1 gap-md">
                    @foreach($searchResults as $result)
                        <div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 flex justify-between items-center">
                            <div>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface">{{ $result->name }}</h4>
                                <p class="text-on-surface-variant text-body-md">{{ $result->city }}, {{ $result->state }}</p>
                            </div>
                            <span class="text-label-sm text-primary">{{ ucfirst($result->status) }}</span>
                        </div>
                    @endforeach
                    @foreach($searchTeams as $result)
                        <div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <img class="w-12 h-12 rounded-full object-cover" src="{{ $result->logo ? asset('storage/' . $result->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($result->name) . '&size=40&background=00595c&color=fff&bold=true' }}" alt="{{ $result->name }}">
                                <div>
                                    <h4 class="font-headline-sm text-headline-sm text-on-surface">{{ $result->name }}</h4>
                                    <p class="text-on-surface-variant text-body-md">{{ $result->players_count }} players</p>
                                </div>
                            </div>
                            <a href="{{ route('player.teams.show', $result) }}" class="text-primary font-label-md hover:underline">View Team</a>
                        </div>
                    @endforeach
                    @foreach($searchPlayers as $result)
                        <div class="bg-surface-container-lowest p-md rounded-xl border border-outline-variant/30 flex justify-between items-center">
                            <div class="flex items-center gap-3">
                                <img class="w-12 h-12 rounded-full object-cover" src="{{ $result->avatar ? asset('storage/' . $result->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($result->full_name) . '&size=40&background=0D9488&color=fff&bold=true' }}" alt="{{ $result->full_name }}">
                                <div>
                                    <h4 class="font-headline-sm text-headline-sm text-on-surface">{{ $result->full_name }}</h4>
                                    <p class="text-on-surface-variant text-body-md">{{ $result->position ?? 'Player' }} • {{ $result->city ?? 'Location not set' }}</p>
                                </div>
                            </div>
                            <span class="text-label-sm text-on-surface-variant">{{ $result->team ? $result->team->name : 'Free Agent' }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        @else
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-8 text-center mb-2xl">
                <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">search_off</span>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No results found</h3>
                <p class="text-on-surface-variant text-body-md">Try adjusting your search terms or browse the categories below.</p>
            </div>
        @endif
    @endif

    <!-- Worth Discovering: Asymmetric Bento Grid -->
    <section class="mb-2xl">
        <div class="flex justify-between items-end mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Worth Discovering</h2>
                <p class="text-on-surface-variant text-body-md">Handpicked highlights across the grassroots ecosystem</p>
            </div>
            <a class="text-primary font-label-md hover:underline flex items-center gap-1" href="#">View all <span class="material-symbols-outlined text-[16px]">arrow_forward</span></a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-md">
            <!-- Featured Tournament Card -->
            @if($featuredTournament)
            <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative">
                <div class="absolute inset-0 bg-cover bg-center opacity-10 group-hover:opacity-15 transition-opacity" 
                     style="background-image: url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1200&h=400&fit=crop')"></div>
                <div class="p-xl relative z-10 flex flex-col h-full justify-between">
                    <div class="flex justify-between items-start mb-xl">
                        <span class="bg-secondary-container text-on-secondary-container px-sm py-xs rounded-full text-label-sm uppercase tracking-wider font-semibold">
                            {{ $featuredTournament->status == 'published' ? 'Registration Open' : ucfirst($featuredTournament->status) }}
                        </span>
                        <span class="text-outline text-label-md">{{ $featuredTournament->category ?? 'Open Age' }} • {{ $featuredTournament->tournament_format ?? 'Standard' }}</span>
                    </div>
                    <div>
                        <span class="text-primary font-label-md uppercase tracking-wider block mb-xs">Featured Tournament</span>
                        <h3 class="font-headline-lg text-headline-lg text-on-surface mb-sm">{{ $featuredTournament->name }}</h3>
                        <p class="text-on-surface-variant mb-xl max-w-lg">{{ $featuredTournament->description ?? 'The premier grassroots tournament uniting elite regional talent.' }}</p>
                        <div class="flex items-center gap-xl text-on-surface-variant text-label-md">
                            <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-[18px]">location_on</span> {{ $featuredTournament->city }}, {{ $featuredTournament->state }}</div>
                            <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-[18px]">group</span> {{ $featuredTournament->teams_count ?? 0 }} Teams</div>
                        </div>
                    </div>
                    <div class="pt-lg mt-lg border-t border-outline-variant/20 flex justify-between items-center">
                        @if($featuredTournament->winner_prize)
                            <span class="text-on-surface font-semibold text-label-md">Prize Pool: ₦{{ number_format($featuredTournament->winner_prize, 2) }}</span>
                        @else
                            <span class="text-on-surface-variant text-label-md">Registration Fee: ₦{{ number_format($featuredTournament->registration_fee, 2) }}</span>
                        @endif
                        <button class="bg-primary-container text-on-primary-container px-lg py-sm rounded-lg text-label-md font-medium hover:opacity-90 transition-opacity">Register Team</button>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Featured Player Card -->
            @if($featuredPlayer)
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between group relative">
                <div class="h-48 bg-cover bg-center relative" 
                     style="background-image: url('{{ $featuredPlayer->avatar ? asset('storage/' . $featuredPlayer->avatar) : 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=400&h=200&fit=crop' }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-transparent to-transparent"></div>
                </div>
                <div class="p-md flex flex-col flex-grow justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-xs">
                            <span class="bg-primary-fixed text-on-primary-fixed px-sm py-xs rounded text-label-sm font-bold">
                                {{ strtoupper($featuredPlayer->position ?? 'N/A') }} • {{ $featuredPlayer->team ? $featuredPlayer->team->name : 'Free Agent' }}
                            </span>
                            <span class="flex items-center text-primary text-label-sm gap-xs">
                                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span> Verified
                            </span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $featuredPlayer->full_name }}</h3>
                        <p class="text-on-surface-variant text-body-md mt-xs">{{ $featuredPlayer->bio ?? 'Talented player making waves in the grassroots football scene.' }}</p>
                    </div>
                    <div class="mt-lg pt-sm border-t border-outline-variant/20 flex justify-between items-center text-label-md">
                        <span class="text-outline">{{ $featuredPlayer->matches ?? 0 }} Apps • {{ $featuredPlayer->goals ?? 0 }} Goals</span>
                        <a href="{{ route('player.profile') }}" class="text-primary font-semibold hover:underline cursor-pointer">View Profile</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Section 1: Tournaments -->
    <section class="mb-2xl content-section" id="section-tournaments" style="{{ $category != 'all' && $category != 'tournaments' ? 'display: none;' : '' }}">
        <div class="flex justify-between items-end mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Active Tournaments</h2>
                <p class="text-on-surface-variant text-body-md">Find where the game is happening right now</p>
            </div>
        </div>
        @if($tournaments->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            @foreach($tournaments as $tournament)
            <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-md">
                        <span class="bg-{{ $tournament->status == 'ongoing' ? 'secondary-container' : ($tournament->status == 'published' ? 'primary-fixed' : 'surface-variant') }} text-on-{{ $tournament->status == 'ongoing' ? 'secondary-container' : ($tournament->status == 'published' ? 'primary-fixed' : 'surface-variant') }} px-sm py-xs rounded-full text-label-sm font-semibold">
                            {{ $tournament->status == 'ongoing' ? 'Live Now' : ($tournament->status == 'published' ? 'Starting Soon' : ucfirst($tournament->status)) }}
                        </span>
                        <span class="text-outline text-label-sm">{{ $tournament->category ?? 'Open Age' }}</span>
                    </div>
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-xs">{{ $tournament->name }}</h3>
                    <p class="text-on-surface-variant text-body-md mb-md">{{ Str::limit($tournament->description ?? 'Tournament details', 80) }}</p>
                    <div class="space-y-xs text-label-md text-on-surface-variant mb-lg">
                        <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">calendar_today</span> {{ $tournament->tournament_start_date->format('M d') }} - {{ $tournament->tournament_end_date->format('M d, Y') }}</div>
                        <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">location_on</span> {{ $tournament->city }}, {{ $tournament->state }}</div>
                        <div class="flex items-center gap-xs"><span class="material-symbols-outlined text-[16px]">group</span> {{ $tournament->teams_count ?? 0 }} Teams</div>
                    </div>
                </div>
                <button class="w-full bg-surface-container-low hover:bg-surface-variant text-on-surface py-sm rounded-lg text-label-md font-medium transition-colors">
                    {{ $tournament->status == 'completed' ? 'View Results' : 'View Details' }}
                </button>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-8 text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">emoji_events</span>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No tournaments available</h3>
            <p class="text-on-surface-variant text-body-md">Check back later for new tournaments in your area.</p>
        </div>
        @endif
    </section>

    <!-- Section 2: Players -->
    <section class="mb-2xl content-section" id="section-players" style="{{ $category != 'all' && $category != 'players' ? 'display: none;' : '' }}">
        <div class="flex justify-between items-end mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Featured Players</h2>
                <p class="text-on-surface-variant text-body-md">Photography-first athlete identity cards</p>
            </div>
        </div>
        @if($players->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
            @foreach($players as $player)
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col">
                <div class="h-64 bg-cover bg-center relative" 
                     style="background-image: url('{{ $player->avatar ? asset('storage/' . $player->avatar) : 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=400&h=300&fit=crop' }}')">
                    <div class="absolute bottom-md left-md bg-surface/90 backdrop-blur-md px-sm py-xs rounded-lg text-label-sm font-bold text-on-surface">
                        {{ $player->position_display ?? 'N/A' }} • {{ $player->team_name ?? 'Free Agent' }}
                    </div>
                </div>
                <div class="p-md flex flex-col justify-between flex-grow">
                    <div>
                        <div class="flex justify-between items-center mb-xs">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $player->full_name }}</h3>
                            <span class="text-primary text-label-sm font-semibold flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span> Verified
                            </span>
                        </div>
                        <p class="text-on-surface-variant text-body-md">{{ $player->bio ?? Str::limit('Talented player making waves in the grassroots football scene.', 80) }}</p>
                    </div>
                    <div class="mt-md pt-md border-t border-outline-variant/20 flex justify-between text-label-md text-on-surface-variant">
                        <div><span>Matches:</span> <strong class="text-on-surface">{{ $player->matches ?? 0 }}</strong></div>
                        <div><span>Goals:</span> <strong class="text-on-surface">{{ $player->goals ?? 0 }}</strong></div>
                        <div><span>Rating:</span> <strong class="text-primary">{{ $player->goals > 0 ? '8.5' : 'N/A' }}</strong></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-8 text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">person_off</span>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No players available</h3>
            <p class="text-on-surface-variant text-body-md">Players will appear here as they join the platform.</p>
        </div>
        @endif
    </section>

    <!-- Section 3: Teams -->
    <section class="mb-2xl content-section" id="section-teams" style="{{ $category != 'all' && $category != 'teams' ? 'display: none;' : '' }}">
        <div class="flex justify-between items-end mb-md">
            <div>
                <h2 class="font-headline-md text-headline-md text-on-surface">Digital Clubhouses</h2>
                <p class="text-on-surface-variant text-body-md">Top-tier grassroots team identities and rosters</p>
            </div>
        </div>
        @if($teams->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
            @foreach($teams as $team)
            <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all flex items-center justify-between">
                <div class="flex items-center gap-md">
                    <div class="w-16 h-16 rounded-xl bg-primary-container text-on-primary-container flex items-center justify-center font-headline-lg text-headline-lg shadow-inner overflow-hidden">
                        <img class="w-full h-full object-cover" src="{{ $team->logo_url }}" alt="{{ $team->name }}" />
                    </div>
                    <div>
                        <div class="flex items-center gap-xs">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $team->name }}</h3>
                            <span class="material-symbols-outlined text-[16px] text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                        </div>
                        <p class="text-on-surface-variant text-body-md">{{ $team->city ?? 'Location not set' }} • {{ $team->players_count }} Registered Players</p>
                        @if($team->form && $team->form != 'N/A')
                            <span class="text-label-sm text-outline mt-xs block">Form: {{ $team->form }}</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('player.teams.show', $team) }}" class="bg-surface-container-low hover:bg-surface-variant text-on-surface px-lg py-sm rounded-lg text-label-md font-medium transition-colors">
                    Clubhouse
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-8 text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">group_off</span>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-2">No teams available</h3>
            <p class="text-on-surface-variant text-body-md">Teams will appear here when they are created.</p>
        </div>
        @endif
    </section>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categoryButtons = document.querySelectorAll('.category-pill');
        const contentSections = document.querySelectorAll('.content-section');

        // Category switching is now handled by server-side links
        // But we keep the client-side logic for instant feedback
        categoryButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                // The actual navigation is handled by the href
                // But we add visual feedback
                categoryButtons.forEach(btn => {
                    btn.classList.remove('bg-primary-container', 'text-on-primary-container', 'shadow-sm');
                    btn.classList.add('bg-surface-container-low', 'text-on-surface-variant');
                });
                button.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
                button.classList.add('bg-primary-container', 'text-on-primary-container', 'shadow-sm');
            });
        });

        // Search functionality - auto-submit on Enter
        const searchInput = document.getElementById('global-search');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    e.target.closest('form').submit();
                }
            });
        }
    });
</script>
@endpush
@endsection