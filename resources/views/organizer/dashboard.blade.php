{{-- resources/views/organizer/dashboard.blade.php --}}
@extends('layouts.guest')

@section('title', 'Organizer Dashboard - 5ivezz')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back, {{ $organizer->full_name ?? 'Organizer' }}!
                </h1>
                <p class="text-gray-600 mt-1">
                    Here's what's happening with your tournaments.
                </p>
            </div>
            <div class="flex items-center gap-3">
                @if($organizer->company_logo ?? false)
                    <img src="{{ asset('storage/' . $organizer->company_logo) }}" 
                         alt="{{ $organizer->company_name ?? 'Company' }}" 
                         class="w-12 h-12 rounded-full object-cover">
                @endif
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    {{ $organizer->verification_status ?? 'Pending' }}
                </span>
            </div>
        </div>
    </div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-50 rounded-lg">
                <span class="material-symbols-outlined text-blue-600">tournament</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Total Tournaments</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $organizer->tournaments()->count() }}
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-50 rounded-lg">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-600">Active Tournaments</p>
                <p class="text-2xl font-bold text-gray-900">
                    {{ $organizer->tournaments()->where('status', 'published')->count() }}
                </p>
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
                <p class="text-2xl font-bold text-gray-900">
                    {{ $organizer->tournaments()->withCount('teams')->get()->sum('teams_count') }}
                </p>
            </div>
        </div>
    </div>
</div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('organizer.tournaments.create') }}" 
               class="flex items-center justify-center gap-2 p-4 bg-primary/5 hover:bg-primary/10 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                <span class="text-primary font-medium">Create Tournament</span>
            </a>
            <a href="{{ route('organizer.profile') }}" 
               class="flex items-center justify-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-gray-600">person</span>
                <span class="text-gray-700 font-medium">Edit Profile</span>
            </a>
            <a href="#" 
               class="flex items-center justify-center gap-2 p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-gray-600">settings</span>
                <span class="text-gray-700 font-medium">Settings</span>
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