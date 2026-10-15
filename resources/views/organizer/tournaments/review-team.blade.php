{{-- resources/views/organizer/tournaments/review-team.blade.php --}}
@extends('layouts.guest')

@section('title', 'Review Registration - ' . $team->name)

@section('content')
<style>
    .player-card {
        transition: all 0.2s ease;
    }
    .player-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
    }
    .check-passed { color: #16a34a; }
    .check-failed { color: #dc2626; }
</style>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Breadcrumb / Header --}}
    <div class="mb-6">
        <a href="{{ route('organizer.tournaments.show', $tournament) }}"
           class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 mb-2">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to {{ $tournament->name }}
        </a>
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Review Registration</h1>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $team->name }} wants to join <strong>{{ $tournament->name }}</strong>
                </p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                {{ $registration->pivot->status === 'approved' ? 'bg-green-100 text-green-800' :
                   ($registration->pivot->status === 'rejected' ? 'bg-red-100 text-red-800' :
                   'bg-yellow-100 text-yellow-800') }}">
                {{ ucfirst($registration->pivot->status) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            @foreach($errors->all() as $error)
                <p class="text-sm text-red-700">• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= LEFT: Team + Players ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Team Profile --}}
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 flex items-center gap-4 border-b border-gray-100">
                    <img src="{{ $team->logo_url }}"
                         alt="{{ $team->name }}"
                         class="w-20 h-20 rounded-xl object-cover border border-gray-200 bg-gray-50">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-xl font-bold text-gray-900 truncate">{{ $team->name }}</h2>
                        <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                            {{ $team->city ?? 'Location not set' }}{{ $team->state ? ', ' . $team->state : '' }}
                        </p>
                        @if($team->captain)
                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[16px]">person</span>
                                Captain: <strong>{{ $team->captain->full_name }}</strong>
                            </p>
                        @endif
                    </div>
                </div>

                @if($team->description)
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">About</h3>
                        <p class="text-sm text-gray-700">{{ $team->description }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-3 divide-x divide-gray-100 border-b border-gray-100">
                    <div class="p-4 text-center">
                        <p class="text-2xl font-bold text-primary">{{ $team->wins ?? 0 }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Wins</p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-2xl font-bold text-gray-700">{{ $team->draws ?? 0 }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Draws</p>
                    </div>
                    <div class="p-4 text-center">
                        <p class="text-2xl font-bold text-red-500">{{ $team->losses ?? 0 }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Losses</p>
                    </div>
                </div>

                <div class="p-4 text-sm text-gray-600 flex items-center justify-between">
                    <span>
                        Requested {{ $registration->pivot->created_at->diffForHumans() }}
                    </span>
                    <a href="{{ route('player.teams.show', $team) }}" target="_blank"
                       class="text-primary hover:underline text-sm font-medium">
                        View Full Team Page →
                    </a>
                </div>
            </div>

            {{-- Squad --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Squad ({{ $playerCount }} players)
                    </h3>
                </div>

                @if($team->players->isEmpty())
                    <div class="text-center py-8 text-gray-500">
                        <span class="material-symbols-outlined text-4xl">group_off</span>
                        <p class="mt-2 text-sm">No active players in this team.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($team->players as $player)
                            <div class="player-card bg-gray-50 rounded-lg p-3 text-center border border-gray-100">
                                <img src="{{ $player->avatar_url }}"
                                     alt="{{ $player->full_name }}"
                                     class="w-14 h-14 rounded-full object-cover mx-auto mb-2 border-2 border-white shadow-sm">
                                <p class="font-medium text-sm text-gray-900 truncate">
                                    {{ $player->first_name }} {{ $player->last_name }}
                                </p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ strtoupper($player->position ?? 'N/A') }}
                                    @if($player->pivot->jersey_number)
                                        · #{{ $player->pivot->jersey_number }}
                                    @endif
                                </p>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] uppercase font-semibold
                                    {{ $player->pivot->role === 'captain' ? 'bg-amber-100 text-amber-800' :
                                       ($player->pivot->role === 'vice_captain' ? 'bg-blue-100 text-blue-800' :
                                       'bg-gray-200 text-gray-700') }}">
                                    {{ $player->pivot->role }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ================= RIGHT: Criteria + Decision ================= --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Criteria Checklist --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Eligibility Check</h3>

                <div class="space-y-3">
                    @foreach($checks as $key => $check)
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-[20px] mt-0.5 {{ $check['passed'] ? 'check-passed' : 'check-failed' }}">
                                {{ $check['passed'] ? 'check_circle' : 'cancel' }}
                            </span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $check['label'] }}</p>
                                <p class="text-xs text-gray-500">{{ $check['detail'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(!$allChecksPassed)
                    <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                        <p class="text-xs text-amber-800">
                            <strong>Note:</strong> Some criteria aren't met. You can still approve, but the team may not be eligible to play.
                        </p>
                    </div>
                @endif
            </div>

            {{-- Tournament Requirements --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tournament Requirements</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Category</span>
                        <strong>{{ ucfirst($tournament->category) }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Type</span>
                        <strong>{{ strtoupper($tournament->type) }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Format</span>
                        <strong>{{ ucfirst(str_replace('-', ' ', $tournament->tournament_format)) }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Roster</span>
                        <strong>{{ $tournament->min_players_per_team }}–{{ $tournament->max_players_per_team }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Registration</span>
                        <strong>
                            {{ $tournament->registration_method === 'paid'
                                ? '₦' . number_format($tournament->registration_fee, 2)
                                : ucfirst($tournament->registration_method) }}
                        </strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Slots</span>
                        <strong>{{ $tournament->approvedTeams()->count() }}/{{ $tournament->max_teams }}</strong>
                    </div>
                </div>

                @if($tournament->team_eligibility)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Eligibility</p>
                        <p class="text-sm text-gray-700">{{ $tournament->team_eligibility }}</p>
                    </div>
                @endif
            </div>

            {{-- Decision --}}
            @if($registration->pivot->status === 'pending')
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Decision</h3>

                    <form method="POST"
                          action="{{ route('organizer.tournaments.teams.approve', [$tournament, $team]) }}"
                          class="mb-3">
                        @csrf
                        <textarea name="note"
                                  rows="2"
                                  placeholder="Optional note (visible to team)"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-primary/30"></textarea>
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            Approve Team
                        </button>
                    </form>

                    <form method="POST"
                          action="{{ route('organizer.tournaments.teams.reject', [$tournament, $team]) }}"
                          onsubmit="return confirm('Reject {{ $team->name }}\'s registration?')">
                        @csrf
                        <textarea name="note"
                                  rows="2"
                                  placeholder="Optional reason for rejection"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-red-300"></textarea>
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                            Reject Team
                        </button>
                    </form>
                </div>
            @elseif($registration->pivot->status === 'approved')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                        <h3 class="text-lg font-semibold text-green-800">Approved</h3>
                    </div>
                    <p class="text-sm text-green-700 mb-3">
                        This team is confirmed for the tournament.
                    </p>
                    @if($registration->pivot->approved_at)
                        <p class="text-xs text-green-600">
                            Approved {{ \Carbon\Carbon::parse($registration->pivot->approved_at)->diffForHumans() }}
                        </p>
                    @endif
                    @if($registration->pivot->notes)
                        <div class="mt-3 pt-3 border-t border-green-200">
                            <p class="text-xs font-semibold text-green-700 uppercase tracking-wider mb-1">Note</p>
                            <p class="text-sm text-green-800">{{ $registration->pivot->notes }}</p>
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('organizer.tournaments.teams.reject', [$tournament, $team]) }}"
                          onsubmit="return confirm('Revoke approval for {{ $team->name }}?')"
                          class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                            Revoke Approval
                        </button>
                    </form>
                </div>
            @elseif($registration->pivot->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-red-600">cancel</span>
                        <h3 class="text-lg font-semibold text-red-800">Rejected</h3>
                    </div>
                    @if($registration->pivot->notes)
                        <p class="text-sm text-red-700">{{ $registration->pivot->notes }}</p>
                    @endif

                    <form method="POST"
                          action="{{ route('organizer.tournaments.teams.approve', [$tournament, $team]) }}"
                          class="mt-4">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                            Approve Instead
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection