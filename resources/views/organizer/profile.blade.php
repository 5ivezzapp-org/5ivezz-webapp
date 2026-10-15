{{-- resources/views/organizer/profile.blade.php --}}
@extends('layouts.guest')

@section('title', 'Organizer Profile - 5ivezz')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            {{-- Logo --}}
            <form action="{{ route('organizer.profile.logo') }}" method="POST" enctype="multipart/form-data" class="shrink-0">
                @csrf
                <div class="relative group w-24 h-24 rounded-full border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-primary flex items-center justify-center overflow-hidden transition-all duration-300 cursor-pointer">
                    @if($organizer->company_logo)
                        <img src="{{ asset('storage/' . $organizer->company_logo) }}"
                             alt="{{ $organizer->company_name ?? $organizer->full_name }}"
                             class="w-full h-full object-cover" />
                    @else
                        <span class="material-symbols-outlined text-3xl text-gray-400 group-hover:text-primary transition-colors">
                            add_photo_alternate
                        </span>
                    @endif
                    <input accept=".jpg,.jpeg,.png,.webp"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           name="company_logo"
                           type="file"
                           onchange="this.form.submit()" />
                </div>
            </form>

            {{-- Identity --}}
            <div class="flex-1 text-center sm:text-left">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $organizer->full_name }}</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold self-center sm:self-auto
                        {{ $organizer->verification_status === 'verified' ? 'bg-green-100 text-green-800' :
                           ($organizer->verification_status === 'rejected' ? 'bg-red-100 text-red-800' :
                           'bg-yellow-100 text-yellow-800') }}">
                        <span class="material-symbols-outlined text-[14px] mr-1">
                            {{ $organizer->verification_status === 'verified' ? 'verified' :
                               ($organizer->verification_status === 'rejected' ? 'cancel' : 'pending') }}
                        </span>
                        {{ ucfirst($organizer->verification_status) }}
                    </span>
                </div>

                @if($organizer->company_name)
                    <p class="text-gray-700 font-medium mt-1">{{ $organizer->company_name }}</p>
                @endif

                <div class="flex flex-wrap justify-center sm:justify-start gap-x-4 gap-y-1 mt-2 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">mail</span>
                        {{ $organizer->email }}
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">call</span>
                        {{ $organizer->phone }}
                    </span>
                    @if($organizer->city || $organizer->state)
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">location_on</span>
                            {{ $organizer->city ? $organizer->city . ', ' : '' }}{{ $organizer->state }}
                        </span>
                    @endif
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                        Joined {{ $organizer->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= STATS GRID ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-blue-500">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Tournaments</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_tournaments'] }}</p>
            <p class="text-xs text-gray-500 mt-1">
                {{ $stats['published_tournaments'] }} published · {{ $stats['draft_tournaments'] }} draft
            </p>
        </div>

        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-green-500">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Teams</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_teams'] }}</p>
            <p class="text-xs text-gray-500 mt-1">approved across all tournaments</p>
        </div>

        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-purple-500">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Total Players</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_players'] }}</p>
            <p class="text-xs text-gray-500 mt-1">on registered teams</p>
        </div>

        <div class="bg-white rounded-lg shadow p-5 border-l-4 border-amber-500">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Pending</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_requests'] }}</p>
            <p class="text-xs text-gray-500 mt-1">team registrations awaiting</p>
        </div>
    </div>

    {{-- Secondary stats row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600 text-[20px]">sports_soccer</span>
                <div>
                    <p class="text-xs text-gray-500">Ongoing</p>
                    <p class="font-bold text-gray-900">{{ $stats['ongoing_tournaments'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-600 text-[20px]">workspace_premium</span>
                <div>
                    <p class="text-xs text-gray-500">Completed</p>
                    <p class="font-bold text-gray-900">{{ $stats['completed_tournaments'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600 text-[20px]">event</span>
                <div>
                    <p class="text-xs text-gray-500">Total Matches</p>
                    <p class="font-bold text-gray-900">{{ $stats['total_matches'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600 text-[20px]">check_circle</span>
                <div>
                    <p class="text-xs text-gray-500">Completed</p>
                    <p class="font-bold text-gray-900">{{ $stats['completed_matches'] }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= RECENT TOURNAMENTS ================= --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Recent Tournaments</h2>
            <a href="{{ route('organizer.tournaments.index') }}"
               class="text-sm text-primary hover:underline font-medium">
                View all →
            </a>
        </div>

        @if($recentTournaments->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded-lg">
                <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">emoji_events</span>
                <p class="text-sm text-gray-500 mb-3">No tournaments yet</p>
                <a href="{{ route('organizer.tournaments.create') }}"
                   class="inline-block px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 text-sm font-medium">
                    Create your first tournament
                </a>
            </div>
        @else
            <div class="space-y-2">
                @foreach($recentTournaments as $t)
                    <a href="{{ route('organizer.tournaments.show', $t) }}"
                       class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <img src="{{ $t->cover_image_url }}"
                             alt="{{ $t->name }}"
                             class="w-14 h-10 object-cover rounded border border-gray-200">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm text-gray-900 truncate">{{ $t->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $t->teams_count }} teams · {{ $t->city }}, {{ $t->state }}
                            </p>
                        </div>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                            {{ $t->status === 'published' ? 'bg-blue-100 text-blue-800' :
                               ($t->status === 'ongoing' ? 'bg-green-100 text-green-800' :
                               ($t->status === 'completed' ? 'bg-purple-100 text-purple-800' :
                               ($t->status === 'cancelled' ? 'bg-red-100 text-red-800' :
                               'bg-gray-100 text-gray-700'))) }}">
                            {{ ucfirst($t->status) }}
                        </span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ================= EDIT PROFILE ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">

            {{-- Profile Info --}}
            <form action="{{ route('organizer.profile.update') }}" method="POST"
                  class="bg-white rounded-lg shadow-lg p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('full_name') border-red-500 @enderror"
                               name="full_name"
                               type="text"
                               value="{{ old('full_name', $organizer->full_name) }}"
                               required />
                        @error('full_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror"
                               name="phone"
                               type="tel"
                               value="{{ old('phone', $organizer->phone) }}"
                               required />
                        @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed"
                               type="email"
                               value="{{ $organizer->email }}"
                               disabled />
                        <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('company_name') border-red-500 @enderror"
                               name="company_name"
                               type="text"
                               value="{{ old('company_name', $organizer->company_name) }}" />
                        @error('company_name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('state') border-red-500 @enderror"
                                name="state"
                                id="stateSelect"
                                required>
                            <option value="">Select State</option>
                            @foreach($states as $stateName => $lgas)
                                <option value="{{ $stateName }}" {{ old('state', $organizer->state) == $stateName ? 'selected' : '' }}>
                                    {{ $stateName }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">City / LGA</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('city') border-red-500 @enderror"
                                name="city"
                                id="citySelect">
                            <option value="">Select City/LGA</option>
                            @php
                                $currentState = old('state', $organizer->state);
                                $cities = $states[$currentState] ?? [];
                            @endphp
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ old('city', $organizer->city) == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                        @error('city')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="submit"
                        class="mt-5 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                    Update Profile
                </button>
            </form>

            {{-- Change Password --}}
            <form action="{{ route('organizer.profile.password') }}" method="POST"
                  class="bg-white rounded-lg shadow-lg p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Current Password <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('current_password') border-red-500 @enderror"
                               name="current_password" type="password" required />
                        @error('current_password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('password') border-red-500 @enderror"
                               name="password" type="password" required />
                        @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password <span class="text-red-500">*</span></label>
                        <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"
                               name="password_confirmation" type="password" required />
                    </div>
                </div>

                <button type="submit"
                        class="mt-5 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                    Update Password
                </button>
            </form>
        </div>

        {{-- ================= SIDEBAR ================= --}}
        <div class="space-y-6">

            {{-- Verification Card --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Verification</h3>
                <div class="flex items-center gap-3 mb-3">
                    <span class="material-symbols-outlined text-4xl
                        {{ $organizer->verification_status === 'verified' ? 'text-green-500' :
                           ($organizer->verification_status === 'rejected' ? 'text-red-500' : 'text-yellow-500') }}">
                        {{ $organizer->verification_status === 'verified' ? 'verified' :
                           ($organizer->verification_status === 'rejected' ? 'cancel' : 'pending') }}
                    </span>
                    <div>
                        <p class="font-semibold text-gray-900">{{ ucfirst($organizer->verification_status) }}</p>
                        <p class="text-xs text-gray-500">
                            @if($organizer->verification_status === 'verified')
                                Your account is fully verified.
                            @elseif($organizer->verification_status === 'pending')
                                Awaiting admin review.
                            @else
                                Please contact support.
                            @endif
                        </p>
                    </div>
                </div>
                @if($organizer->cac_document)
                    <a href="{{ asset('storage/' . $organizer->cac_document) }}" target="_blank"
                       class="text-sm text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">description</span>
                        View CAC Document
                    </a>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('organizer.tournaments.create') }}"
                       class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 text-sm">
                        <span class="material-symbols-outlined text-primary text-[20px]">add_circle</span>
                        Create Tournament
                    </a>
                    <a href="{{ route('organizer.tournaments.index') }}"
                       class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 text-sm">
                        <span class="material-symbols-outlined text-gray-600 text-[20px]">list</span>
                        All Tournaments
                    </a>
                    <a href="{{ route('organizer.dashboard') }}"
                       class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 text-sm">
                        <span class="material-symbols-outlined text-gray-600 text-[20px]">dashboard</span>
                        Dashboard
                    </a>
                </div>
            </div>

            {{-- Sign Out --}}
            <form method="POST" action="{{ route('organizer.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-white rounded-lg shadow-lg p-4 hover:bg-red-50 transition-colors flex items-center justify-center gap-2 text-red-600 font-medium border border-transparent hover:border-red-200"
                        onclick="return confirm('Sign out?')">
                    <span class="material-symbols-outlined">logout</span>
                    Sign Out
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const stateSelect = document.getElementById('stateSelect');
        const citySelect = document.getElementById('citySelect');
        const statesData = @json($states);

        stateSelect.addEventListener('change', function () {
            const lgas = statesData[this.value] || [];
            citySelect.innerHTML = '<option value="">Select City/LGA</option>';
            lgas.forEach(function (lga) {
                const opt = document.createElement('option');
                opt.value = lga;
                opt.textContent = lga;
                citySelect.appendChild(opt);
            });
        });
    });
</script>
@endpush
@endsection