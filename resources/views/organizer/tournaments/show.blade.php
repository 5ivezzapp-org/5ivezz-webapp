{{-- resources/views/organizer/tournaments/show.blade.php --}}
@extends('layouts.guest')

@section('title', $tournament->name . ' - 5ivezz')

@section('content')
@php
    $registeredTeams = $tournament->teams()
        ->with(['captain'])
        ->get();

    // Attach active player counts using a single pivot query
    $activeCounts = \DB::table('team_player')
        ->select('team_id', \DB::raw('COUNT(*) as active_players_count'))
        ->where('status', 'active')
        ->whereIn('team_id', $registeredTeams->pluck('id'))
        ->groupBy('team_id')
        ->pluck('active_players_count', 'team_id');

    foreach ($registeredTeams as $team) {
        $team->active_players_count = $activeCounts[$team->id] ?? 0;
    }

    $pendingTeams  = $registeredTeams->where('pivot.status', 'pending');
    $approvedTeams = $registeredTeams->where('pivot.status', 'approved');
    $rejectedTeams = $registeredTeams->where('pivot.status', 'rejected');
@endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('organizer.tournaments.index') }}" class="text-gray-600 hover:text-gray-900">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ $tournament->name }}</h1>
            <span class="ml-auto px-3 py-1 text-sm rounded-full
                {{ $tournament->status === 'published' ? 'bg-green-100 text-green-800' :
        ($tournament->status === 'draft' ? 'bg-yellow-100 text-yellow-800' :
            ($tournament->status === 'ongoing' ? 'bg-blue-100 text-blue-800' :
                ($tournament->status === 'completed' ? 'bg-purple-100 text-purple-800' :
                    'bg-gray-100 text-gray-800'))) }}">
                {{ $tournament->getStatusDisplayText() }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-blue-700">{{ session('info') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-700">• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            @if($tournament->cover_image)
                <img src="{{ asset('storage/' . $tournament->cover_image) }}" alt="{{ $tournament->name }}"
                    class="w-full h-64 object-cover">
            @endif

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tournament Info -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Tournament Information</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Category:</span> {{ ucfirst($tournament->category) }}</p>
                            <p><span class="font-medium">Type:</span> {{ $tournament->type }}</p>
                            @if($tournament->edition)
                                <p><span class="font-medium">Edition:</span> {{ $tournament->edition }}</p>
                            @endif
                            <p><span class="font-medium">Format:</span>
                                {{ ucfirst(str_replace('-', ' ', $tournament->tournament_format)) }}</p>
                        </div>
                    </div>

                    <!-- Organizer Info -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Organizer Information</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Organization:</span> {{ $tournament->organization_name }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $tournament->phone_number }}</p>
                            <p><span class="font-medium">Email:</span> {{ $tournament->email_address }}</p>
                            @if($tournament->website_social)
                                <p><span class="font-medium">Website:</span> <a href="{{ $tournament->website_social }}"
                                        target="_blank"
                                        class="text-primary hover:underline">{{ $tournament->website_social }}</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Date & Location -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Date & Location</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Registration:</span>
                                {{ $tournament->registration_opens->format('M d, Y') }} -
                                {{ $tournament->registration_closes->format('M d, Y') }}</p>
                            <p><span class="font-medium">Tournament:</span>
                                {{ $tournament->tournament_start_date->format('M d, Y') }} -
                                {{ $tournament->tournament_end_date->format('M d, Y') }}</p>
                            <p><span class="font-medium">Venue:</span> {{ $tournament->venue_name }}</p>
                            <p><span class="font-medium">Address:</span> {{ $tournament->venue_address }},
                                {{ $tournament->city }}, {{ $tournament->state }}, {{ $tournament->country }}</p>
                        </div>
                    </div>

                    <!-- Competition Format -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Competition Format</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Teams:</span> {{ $tournament->number_of_teams }}</p>
                            <p><span class="font-medium">Max Players/Team:</span> {{ $tournament->max_players_per_team }}
                            </p>
                            <p><span class="font-medium">Min Players/Team:</span> {{ $tournament->min_players_per_team }}
                            </p>
                        </div>
                    </div>

                    <!-- Team Registration -->
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Team Registration</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <p><span class="font-medium">Method:</span> {{ ucfirst($tournament->registration_method) }}</p>
                            @if($tournament->registration_fee > 0)
                                <p><span class="font-medium">Fee:</span> ₦{{ number_format($tournament->registration_fee, 2) }}
                                </p>
                            @endif
                            <p><span class="font-medium">Max Teams:</span> {{ $tournament->max_teams }}</p>
                            <p><span class="font-medium">Deadline:</span>
                                {{ $tournament->team_registration_deadline->format('M d, Y') }}</p>
                            <p><span class="font-medium">Manager Details:</span>
                                {{ $tournament->requires_manager_details ? 'Required' : 'Not Required' }}</p>
                            <p><span class="font-medium">Player Roster:</span>
                                {{ $tournament->requires_player_roster ? 'Required' : 'Not Required' }}</p>
                        </div>
                        @if($tournament->team_eligibility)
                            <div class="mt-2">
                                <p class="font-medium">Eligibility Requirements:</p>
                                <p class="text-gray-600 mt-1">{{ $tournament->team_eligibility }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Rules -->
                    @if($tournament->tournament_rules || $tournament->match_rules)
                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Rules</h3>
                            @if($tournament->tournament_rules)
                                <div class="mb-3">
                                    <p class="font-medium">Tournament Rules:</p>
                                    <p class="text-gray-600 mt-1 whitespace-pre-line">{{ $tournament->tournament_rules }}</p>
                                </div>
                            @endif
                            @if($tournament->match_rules)
                                <div>
                                    <p class="font-medium">Match Rules:</p>
                                    <p class="text-gray-600 mt-1 whitespace-pre-line">{{ $tournament->match_rules }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Prizes -->
                    @if($tournament->winner_prize || $tournament->runner_up_prize || $tournament->third_place_prize || $tournament->additional_prize_details)
                        <div class="md:col-span-2">
                            <h3 class="text-sm font-medium text-gray-500 mb-2">Prize & Awards</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                @if($tournament->winner_prize)
                                    <p><span class="font-medium">Winner:</span> ₦{{ number_format($tournament->winner_prize, 2) }}
                                    </p>
                                @endif
                                @if($tournament->runner_up_prize)
                                    <p><span class="font-medium">Runner-Up:</span>
                                        ₦{{ number_format($tournament->runner_up_prize, 2) }}</p>
                                @endif
                                @if($tournament->third_place_prize)
                                    <p><span class="font-medium">3rd Place:</span>
                                        ₦{{ number_format($tournament->third_place_prize, 2) }}</p>
                                @endif
                            </div>
                            @if($tournament->additional_prize_details)
                                <p class="text-gray-600 mt-2 whitespace-pre-line">{{ $tournament->additional_prize_details }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap gap-3">
                    <a href="{{ route('organizer.tournaments.edit', $tournament) }}"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                        Edit Tournament
                    </a>

                    @if($tournament->status === 'draft')
                        <form action="{{ route('organizer.tournaments.publish', $tournament) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                Publish Tournament
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('organizer.tournaments.destroy', $tournament) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this tournament?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Delete Tournament
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===================== REGISTERED TEAMS ===================== --}}
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">

            <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Registered Teams</h2>
                    <p class="text-sm text-gray-500">
                        {{ $approvedTeams->count() }} approved ·
                        {{ $pendingTeams->count() }} pending ·
                        {{ $rejectedTeams->count() }} rejected
                        · <span class="font-medium">{{ $approvedTeams->count() }}/{{ $tournament->max_teams }} slots
                            filled</span>
                    </p>
                </div>
                @if($pendingTeams->isNotEmpty())
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                        <span class="material-symbols-outlined text-[16px]">pending_actions</span>
                        {{ $pendingTeams->count() }} awaiting review
                    </span>
                @endif
            </div>

            @if($registeredTeams->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">group_off</span>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">No teams registered yet</h3>
                    <p class="text-sm text-gray-500">
                        Share the tournament link so teams can start registering.
                    </p>
                </div>
            @else

                {{-- Pending first --}}
                @if($pendingTeams->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-sm font-semibold text-amber-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">schedule</span>
                            Pending ({{ $pendingTeams->count() }})
                        </h3>
                        <div class="space-y-3">
                            @foreach($pendingTeams as $team)
                                @include('organizer.tournaments.partials.team-row', [
                                    'team' => $team,
                                    'tournament' => $tournament,
                                    'status' => 'pending',
                                ])
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Approved --}}
                @if($approvedTeams->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-sm font-semibold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            Approved ({{ $approvedTeams->count() }})
                        </h3>
                        <div class="space-y-3">
                            @foreach($approvedTeams as $team)
                                @include('organizer.tournaments.partials.team-row', [
                                    'team' => $team,
                                    'tournament' => $tournament,
                                    'status' => 'approved',
                                ])
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Rejected --}}
                @if($rejectedTeams->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-semibold text-red-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                            Rejected ({{ $rejectedTeams->count() }})
                        </h3>
                        <div class="space-y-3">
                            @foreach($rejectedTeams as $team)
                                @include('organizer.tournaments.partials.team-row', [
                                    'team' => $team,
                                    'tournament' => $tournament,
                                    'status' => 'rejected',
                                ])
                            @endforeach
                        </div>
                    </div>
                @endif

            @endif
        </div>
    </div>
@endsection