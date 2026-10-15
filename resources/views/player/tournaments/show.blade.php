{{-- resources/views/player/tournaments/show.blade.php --}}
@extends('layouts.guest')

@section('title', $tournament->name . ' - 5ivezz')

@section('content')
<main class="max-w-6xl mx-auto px-md md:px-lg pt-4 pb-24">
    <a href="{{ route('tournaments.index') }}" class="inline-flex items-center gap-1 text-on-surface-variant hover:text-on-surface mb-md">
        <span class="material-symbols-outlined text-[20px]">arrow_back</span> Back to Tournaments
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-md">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Hero --}}
    <section class="relative rounded-2xl overflow-hidden mb-xl">
        <img src="{{ $tournament->cover_image_url }}" alt="{{ $tournament->name }}" class="w-full h-[320px] object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
        <div class="absolute bottom-0 left-0 p-lg text-white">
            <span class="inline-block px-3 py-1 rounded-full text-label-sm font-semibold mb-sm
                {{ $tournament->status === 'ongoing' ? 'bg-green-500' : 'bg-white/20 backdrop-blur' }}">
                {{ $tournament->getStatusDisplayText() }}
            </span>
            <h1 class="font-display-lg text-display-lg">{{ $tournament->name }}</h1>
            <p class="font-body-lg text-white/80 flex items-center gap-1 mt-1">
                <span class="material-symbols-outlined text-[18px]">location_on</span>
                {{ $tournament->venue_name }}, {{ $tournament->city }}, {{ $tournament->state }}
            </p>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
        {{-- Left column --}}
        <div class="lg:col-span-2 space-y-lg">
            <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                <h2 class="font-headline-md mb-md">About</h2>
                <p class="text-on-surface-variant">{{ $tournament->description }}</p>
            </section>

            <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                <h2 class="font-headline-md mb-md">Details</h2>
                <div class="grid grid-cols-2 gap-md">
                    <div><span class="text-label-sm text-on-surface-variant">Category:</span> <strong>{{ ucfirst($tournament->category) }}</strong></div>
                    <div><span class="text-label-sm text-on-surface-variant">Type:</span> <strong>{{ strtoupper($tournament->type) }}</strong></div>
                    <div><span class="text-label-sm text-on-surface-variant">Format:</span> <strong>{{ ucfirst(str_replace('-', ' ', $tournament->tournament_format)) }}</strong></div>
                    <div><span class="text-label-sm text-on-surface-variant">Registration:</span> <strong>{{ ucfirst($tournament->registration_method) }}</strong></div>
                    @if($tournament->registration_fee > 0)
                        <div><span class="text-label-sm text-on-surface-variant">Fee:</span> <strong>₦{{ number_format($tournament->registration_fee, 2) }}</strong></div>
                    @endif
                    <div><span class="text-label-sm text-on-surface-variant">Teams:</span> <strong>{{ $teamsCount }}/{{ $tournament->max_teams }}</strong></div>
                    <div><span class="text-label-sm text-on-surface-variant">Players/Team:</span> <strong>{{ $tournament->min_players_per_team }}–{{ $tournament->max_players_per_team }}</strong></div>
                    <div><span class="text-label-sm text-on-surface-variant">Dates:</span> <strong>{{ $tournament->tournament_start_date->format('M d') }} – {{ $tournament->tournament_end_date->format('M d, Y') }}</strong></div>
                </div>
            </section>

            @if($tournament->tournament_rules || $tournament->match_rules)
                <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                    <h2 class="font-headline-md mb-md">Rules</h2>
                    @if($tournament->tournament_rules)
                        <h3 class="font-label-md font-bold mt-sm">Tournament Rules</h3>
                        <p class="text-on-surface-variant whitespace-pre-line">{{ $tournament->tournament_rules }}</p>
                    @endif
                    @if($tournament->match_rules)
                        <h3 class="font-label-md font-bold mt-md">Match Rules</h3>
                        <p class="text-on-surface-variant whitespace-pre-line">{{ $tournament->match_rules }}</p>
                    @endif
                </section>
            @endif

            @if($tournament->winner_prize || $tournament->runner_up_prize || $tournament->third_place_prize)
                <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                    <h2 class="font-headline-md mb-md">Prizes</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-md">
                        @if($tournament->winner_prize)
                            <div class="text-center p-md bg-yellow-50 rounded-xl">
                                <span class="material-symbols-outlined text-yellow-600">emoji_events</span>
                                <p class="font-label-sm text-on-surface-variant">Winner</p>
                                <p class="font-headline-sm font-bold">₦{{ number_format($tournament->winner_prize, 0) }}</p>
                            </div>
                        @endif
                        @if($tournament->runner_up_prize)
                            <div class="text-center p-md bg-gray-50 rounded-xl">
                                <span class="material-symbols-outlined text-gray-500">military_tech</span>
                                <p class="font-label-sm text-on-surface-variant">Runner-Up</p>
                                <p class="font-headline-sm font-bold">₦{{ number_format($tournament->runner_up_prize, 0) }}</p>
                            </div>
                        @endif
                        @if($tournament->third_place_prize)
                            <div class="text-center p-md bg-orange-50 rounded-xl">
                                <span class="material-symbols-outlined text-orange-500">workspace_premium</span>
                                <p class="font-label-sm text-on-surface-variant">3rd Place</p>
                                <p class="font-headline-sm font-bold">₦{{ number_format($tournament->third_place_prize, 0) }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            {{-- Upcoming matches --}}
            @if($upcomingMatches->isNotEmpty())
                <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                    <h2 class="font-headline-md mb-md">Upcoming Matches</h2>
                    @foreach($upcomingMatches as $match)
                        <div class="flex justify-between items-center py-sm border-b last:border-0">
                            <span>{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</span>
                            <span class="text-label-sm text-on-surface-variant">{{ $match->match_datetime->format('M d, H:i') }}</span>
                        </div>
                    @endforeach
                </section>
            @endif

            {{-- Approved teams --}}
            <section class="bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                <h2 class="font-headline-md mb-md">Registered Teams ({{ $teamsCount }})</h2>
                @if($approvedTeams->isEmpty())
                    <p class="text-on-surface-variant">No teams have registered yet.</p>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-sm">
                        @foreach($approvedTeams as $t)
                            <div class="flex items-center gap-sm p-sm bg-surface-container-low rounded-lg">
                                <img src="{{ $t->logo ? asset('storage/' . $t->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($t->name) . '&size=40&background=00595c&color=fff&bold=true' }}" 
                                     class="w-10 h-10 rounded-full object-cover" />
                                <div class="min-w-0">
                                    <p class="font-label-md truncate">{{ $t->name }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $t->players_count }} players</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Right column — Registration card --}}
        <div class="lg:col-span-1">
            <div class="sticky top-4 bg-surface-container-lowest border border-black/5 rounded-2xl p-lg">
                <h3 class="font-headline-sm mb-md">Registration</h3>

                @if($registration)
                    {{-- Already registered --}}
                    <div class="p-md rounded-lg mb-md
                        {{ $registration->pivot->status === 'approved' ? 'bg-green-50 text-green-700' : 
                           ($registration->pivot->status === 'rejected' ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700') }}">
                        <p class="font-label-md font-semibold">
                            Status: {{ ucfirst($registration->pivot->status) }}
                        </p>
                        @if($registration->pivot->status === 'pending')
                            <p class="text-sm mt-1">Your registration is awaiting organizer approval.</p>
                        @elseif($registration->pivot->status === 'approved')
                            <p class="text-sm mt-1">Your team is confirmed for this tournament.</p>
                        @endif
                    </div>

                    @if($registration->pivot->status !== 'approved' || $tournament->status !== 'ongoing')
                        <form action="{{ route('tournaments.withdraw', $tournament) }}" method="POST"
                              onsubmit="return confirm('Withdraw your team from this tournament?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-50 text-red-700 px-md py-sm rounded-lg hover:bg-red-100">
                                Withdraw Team
                            </button>
                        </form>
                    @endif

                @elseif(!$userTeam)
                    <div class="p-md rounded-lg bg-gray-50 text-gray-600 mb-md">
                        <p class="font-label-md">You're not on a team.</p>
                        <p class="text-sm mt-1">Join or create a team to register for tournaments.</p>
                    </div>
                    <a href="{{ route('teams.index') }}" 
                       class="block text-center bg-primary text-on-primary px-md py-sm rounded-lg hover:bg-primary/90">
                        Find a Team
                    </a>

                @elseif($userTeam->captain_id !== Auth::id())
                    <div class="p-md rounded-lg bg-blue-50 text-blue-700 mb-md">
                        <p class="font-label-md">Only team captains can register.</p>
                        <p class="text-sm mt-1">Ask your captain ({{ $userTeam->captain->first_name ?? 'captain' }}) to register your team.</p>
                    </div>

                @elseif($canRegister)
                    <div class="p-md rounded-lg bg-surface-container-low mb-md">
                        <p class="font-label-sm text-on-surface-variant">Registering as</p>
                        <p class="font-label-md font-bold">{{ $userTeam->name }}</p>
                        <p class="text-xs text-on-surface-variant">{{ $userTeam->players()->count() }} players</p>
                    </div>
                    <form action="{{ route('tournaments.register', $tournament) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-primary text-on-primary px-md py-sm rounded-lg hover:bg-primary/90 font-semibold">
                            Register Team
                        </button>
                    </form>

                @else
                    <div class="p-md rounded-lg bg-red-50 text-red-700 mb-md">
                        <p class="font-label-md font-semibold mb-sm">Cannot register:</p>
                        <ul class="text-sm space-y-1 list-disc list-inside">
                            @foreach($registrationBlockers as $blocker)
                                <li>{{ $blocker }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Key dates --}}
                <div class="mt-lg pt-lg border-t border-outline-variant/20 text-sm space-y-2">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Registration opens</span>
                        <strong>{{ $tournament->registration_opens->format('M d, Y') }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Registration closes</span>
                        <strong>{{ $tournament->registration_closes->format('M d, Y') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection