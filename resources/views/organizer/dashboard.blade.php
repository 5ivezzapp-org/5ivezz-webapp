{{-- resources/views/organizer/dashboard.blade.php --}}
@extends('layouts.guest')

@section('title', 'Organizer Dashboard - 5ivezz')

@section('content')
    <style>
        .tournament-card {
            transition: all 0.2s ease;
        }

        .tournament-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.06);
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Welcome Section --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Welcome back, {{ $organizer->full_name ?? 'Organizer' }}!
                    </h1>
                    <p class="text-gray-600 mt-1">Here's what's happening with your tournaments.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($organizer->company_logo ?? false)
                        <img src="{{ asset('storage/' . $organizer->company_logo) }}"
                            alt="{{ $organizer->company_name ?? 'Company' }}" class="w-12 h-12 rounded-full object-cover">
                    @endif
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $organizer->verification_status === 'verified' ? 'bg-green-100 text-green-800' :
        ($organizer->verification_status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($organizer->verification_status ?? 'Pending') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600">tournament</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Tournaments</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_tournaments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Active</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_tournaments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-50 rounded-lg">
                        <span class="material-symbols-outlined text-purple-600">groups</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Teams</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_teams'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-amber-50 rounded-lg">
                        <span class="material-symbols-outlined text-amber-600">pending_actions</span>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_registrations'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- My Tournaments --}}
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">My Tournaments</h2>
                    <p class="text-sm text-gray-500">Manage and edit your competitions</p>
                </div>
                <div class="flex items-center gap-2">
                    @if($stats['total_tournaments'] > 6)
                        <a href="{{ route('organizer.tournaments.index') }}" class="text-sm text-primary hover:underline">
                            View all ({{ $stats['total_tournaments'] }})
                        </a>
                    @endif
                    <a href="{{ route('organizer.tournaments.create') }}"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        New
                    </a>
                </div>
            </div>

            @if($tournaments->isEmpty())
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">emoji_events</span>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">No tournaments yet</h3>
                    <p class="text-sm text-gray-500 mb-4">Create your first tournament and start accepting teams.</p>
                    <a href="{{ route('organizer.tournaments.create') }}"
                        class="inline-block px-5 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                        Create Tournament
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($tournaments as $tournament)
                        <div class="tournament-card bg-white border border-gray-200 rounded-lg overflow-hidden flex flex-col">
                            {{-- Cover --}}
                            <div class="h-32 relative overflow-hidden bg-gray-100">
                                <img src="{{ $tournament->cover_image_url }}" alt="{{ $tournament->name }}"
                                    class="w-full h-full object-cover">
                                <span class="absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $tournament->status === 'published' ? 'bg-blue-100 text-blue-800' :
                        ($tournament->status === 'ongoing' ? 'bg-green-100 text-green-800' :
                            ($tournament->status === 'completed' ? 'bg-purple-100 text-purple-800' :
                                ($tournament->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                                    'bg-gray-100 text-gray-800'))) }}">
                                    {{ $tournament->getStatusDisplayText() }}
                                </span>
                            </div>

                            {{-- Body --}}
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1">
                                    {{ $tournament->name }}
                                </h3>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mb-3">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $tournament->city }}, {{ $tournament->state }}
                                </p>

                                <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-4">
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                        {{ $tournament->tournament_start_date->format('M d') }} –
                                        {{ $tournament->tournament_end_date->format('M d') }}
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">group</span>
                                        {{ $tournament->teams_count }}/{{ $tournament->max_teams }} teams
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="mt-auto pt-3 border-t border-gray-100 flex items-center gap-2">
                                    <a href="{{ route('organizer.tournaments.show', $tournament) }}"
                                        class="flex-1 text-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition-colors text-xs font-medium">
                                        View
                                    </a>
                                    <a href="{{ route('organizer.tournaments.edit', $tournament) }}"
                                        class="flex-1 text-center px-3 py-1.5 bg-primary/10 text-primary rounded-md hover:bg-primary/20 transition-colors text-xs font-medium">
                                        Edit
                                    </a>
                                    @if($tournament->status === 'draft')
                                        <form action="{{ route('organizer.tournaments.publish', $tournament) }}" method="POST"
                                            class="flex-1">
                                            @csrf
                                            <button type="submit"
                                                class="w-full px-3 py-1.5 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors text-xs font-medium">
                                                Publish
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Pending Registrations --}}
        @if($pendingRegistrations->isNotEmpty())
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Pending Team Registrations</h2>
                        <p class="text-sm text-gray-500">Teams waiting for your approval</p>
                    </div>
                    <a href="{{ route('organizer.tournaments.index') }}" class="text-sm text-primary hover:underline">
                        View all
                    </a>
                </div>

                <div class="space-y-3">
                    @foreach($pendingRegistrations as $team)
                        @php
                            $tournament = $team->tournaments->first();
                        @endphp
                        @if($tournament)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $team->logo ? asset('storage/' . $team->logo) : 'https://ui-avatars.com/api/?name=' . urlencode($team->name) . '&size=40&background=00595c&color=fff&bold=true' }}"
                                        class="w-10 h-10 rounded-full object-cover" alt="{{ $team->name }}">
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">{{ $team->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            wants to join <strong>{{ $tournament->name }}</strong>
                                        </p>
                                    </div>
                                </div>
                                {{-- inside the pending registrations loop --}}
                                <a href="{{ route('organizer.tournaments.teams.review', [$tournament, $team]) }}"
                                    class="text-xs text-primary hover:underline font-medium">
                                    Review →
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('organizer.tournaments.create') }}"
                    class="flex items-center justify-center gap-2 p-4 bg-primary/5 hover:bg-primary/10 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-primary">add_circle</span>
                    <span class="text-primary font-medium">Create Tournament</span>
                </a>
                <a href="{{ route('organizer.tournaments.index') }}"
                    class="flex items-center justify-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-600">list</span>
                    <span class="text-gray-700 font-medium">All Tournaments</span>
                </a>
                <a href="{{ route('organizer.profile') }}"
                    class="flex items-center justify-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-600">person</span>
                    <span class="text-gray-700 font-medium">Edit Profile</span>
                </a>
                <a href="#"
                    class="flex items-center justify-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-gray-600">help</span>
                    <span class="text-gray-700 font-medium">Support</span>
                </a>
            </div>
        </div>
    </div>
@endsection