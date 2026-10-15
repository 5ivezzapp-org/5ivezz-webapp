{{-- resources/views/organizer/tournaments/partials/team-row.blade.php --}}
@php
    $logoUrl = $team->logo
        ? asset('storage/' . $team->logo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($team->name) . '&size=40&background=00595c&color=fff&bold=true';

    $statusColors = [
        'pending'  => 'bg-amber-100 text-amber-800',
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100 transition-colors">
    {{-- Left: team info --}}
    <div class="flex items-center gap-4 min-w-0 flex-1">
        <img src="{{ $logoUrl }}"
             alt="{{ $team->name }}"
             class="w-12 h-12 rounded-full object-cover border border-white shadow-sm shrink-0">

        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-2 flex-wrap">
                <p class="font-semibold text-sm text-gray-900 truncate">{{ $team->name }}</p>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wide {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $status }}
                </span>
            </div>

            <div class="text-xs text-gray-500 mt-1 flex items-center gap-3 flex-wrap">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                    {{ $team->city ?? 'Location not set' }}
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">groups</span>
                    {{ $team->active_players_count ?? $team->players->count() }} players
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                    {{ $team->pivot->created_at->diffForHumans() }}
                </span>
                @if($team->captain)
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">person</span>
                        {{ $team->captain->first_name }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Right: actions --}}
    <div class="flex items-center gap-2 shrink-0 sm:ml-3 self-end sm:self-auto">
        {{-- View Team (public player-facing page, new tab) --}}
        <a href="{{ route('player.teams.show', $team) }}"
           target="_blank"
           rel="noopener"
           title="View team's public page"
           class="inline-flex items-center gap-1 px-3 py-1.5 bg-white border border-gray-300 text-gray-700 text-xs font-medium rounded-md hover:bg-gray-50 transition-colors">
            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
            Team
        </a>

        {{-- Review / View registration --}}
        <a href="{{ route('organizer.tournaments.teams.review', [$tournament, $team]) }}"
           class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary text-white text-xs font-medium rounded-md hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined text-[16px]">
                {{ $status === 'pending' ? 'fact_check' : 'visibility' }}
            </span>
            {{ $status === 'pending' ? 'Review' : 'View' }}
        </a>
    </div>
</div>