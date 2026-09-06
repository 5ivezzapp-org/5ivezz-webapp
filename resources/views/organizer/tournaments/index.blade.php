{{-- resources/views/organizer/tournaments/index.blade.php --}}
@extends('layouts.guest')

@section('title', 'My Tournaments - 5ivezz')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">My Tournaments</h1>
        <a href="{{ route('organizer.tournaments.create') }}" 
           class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
            Create Tournament
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($tournaments->isEmpty())
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">tournament</span>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Tournaments Yet</h3>
            <p class="text-gray-600 mb-4">Start creating your first tournament and bring your competition to life!</p>
            <a href="{{ route('organizer.tournaments.create') }}" 
               class="inline-block px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                Create Your First Tournament
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tournaments as $tournament)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($tournament->cover_image)
                        <img src="{{ asset('storage/' . $tournament->cover_image) }}" 
                             alt="{{ $tournament->name }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-gray-400">sports_soccer</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $tournament->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full {{ $tournament->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($tournament->status) }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $tournament->description }}</p>
                        
                        <div class="text-sm text-gray-500 space-y-1">
                            <p>📅 {{ $tournament->tournament_start_date->format('M d, Y') }} - {{ $tournament->tournament_end_date->format('M d, Y') }}</p>
                            <p>📍 {{ $tournament->city }}, {{ $tournament->state }}</p>
                            <p>👥 {{ $tournament->number_of_teams }} teams</p>
                        </div>
                        
                        <div class="flex gap-2 mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('organizer.tournaments.show', $tournament) }}" 
                               class="flex-1 text-center px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                                View
                            </a>
                            <a href="{{ route('organizer.tournaments.edit', $tournament) }}" 
                               class="flex-1 text-center px-3 py-1 bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-colors text-sm">
                                Edit
                            </a>
                            @if($tournament->status === 'draft')
                                <form action="{{ route('organizer.tournaments.publish', $tournament) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors text-sm">
                                        Publish
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">
            {{ $tournaments->links() }}
        </div>
    @endif
</div>
@endsection