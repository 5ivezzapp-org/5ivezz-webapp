{{-- resources/views/organizer/tournaments/edit.blade.php --}}
@extends('layouts.guest')

@section('title', 'Edit ' . $tournament->name . ' - 5ivezz')

@section('content')
<main class="w-full max-w-[1400px] mx-auto px-lg md:px-3xl pt-16 md:pt-4 pb-3xl">
    <div class="mb-2xl flex items-center justify-between">
        <div>
            <a href="{{ route('organizer.tournaments.show', $tournament) }}" 
               class="text-on-surface-variant hover:text-on-surface flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Back to Tournament
            </a>
            <h1 class="font-display-lg text-display-lg text-on-surface">Edit Tournament</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-xs">{{ $tournament->name }}</p>
        </div>
        <span class="px-3 py-1 text-sm rounded-full {{ $tournament->getStatusBadgeClass() }}">
            {{ ucfirst($tournament->status) }}
        </span>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-lg mb-xl">
            <h3 class="font-label-md text-label-md text-red-600 font-semibold">Please fix the following errors:</h3>
            <ul class="mt-sm space-y-xs">
                @foreach ($errors->all() as $error)
                    <li class="font-body-sm text-body-sm text-red-600">• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizer.tournaments.update', $tournament) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Tournament Information --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">01</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Tournament Information</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <div>
                    <label class="block font-label-md text-label-md mb-xs">Tournament Name <span class="text-error">*</span></label>
                    <input class="input-premium w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="text" name="name" value="{{ old('name', $tournament->name) }}" required />
                </div>

                <div>
                    <label class="block font-label-md text-label-md mb-xs">Cover Image</label>
                    @if($tournament->cover_image)
                        <img src="{{ asset('storage/' . $tournament->cover_image) }}" 
                             class="w-full h-48 object-cover rounded-2xl mb-sm" />
                    @endif
                    <input type="file" name="cover_image" accept="image/*" 
                           class="w-full border border-outline-variant rounded-2xl px-md py-sm" />
                </div>

                <div>
                    <label class="block font-label-md text-label-md mb-xs">Description <span class="text-error">*</span></label>
                    <textarea class="w-full border border-outline-variant rounded-2xl px-md py-sm min-h-[120px]" 
                              name="description" required>{{ old('description', $tournament->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <div>
                        <label class="block font-label-md text-label-md mb-xs">Category <span class="text-error">*</span></label>
                        <select class="w-full border border-outline-variant rounded-2xl px-md py-sm" name="category" required>
                            @foreach(['youth','adult','pro-am','senior','women','mixed'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $tournament->category) == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-label-md text-label-md mb-xs">Type <span class="text-error">*</span></label>
                        <select class="w-full border border-outline-variant rounded-2xl px-md py-sm" name="type" required>
                            @foreach(['u-10','u-12','u-14','u-16','u-18','u-21','open'] as $t)
                                <option value="{{ $t }}" {{ old('type', $tournament->type) == $t ? 'selected' : '' }}>
                                    {{ strtoupper($t) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-label-md text-label-md mb-xs">Edition</label>
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="text" name="edition" value="{{ old('edition', $tournament->edition) }}" />
                </div>

                <div class="bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                    <h3 class="font-label-md uppercase tracking-wider mb-md">Organizer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="text" name="organization_name" 
                               value="{{ old('organization_name', $tournament->organization_name) }}" 
                               placeholder="Organization Name" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="tel" name="phone_number" 
                               value="{{ old('phone_number', $tournament->phone_number) }}" 
                               placeholder="Phone" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="email" name="email_address" 
                               value="{{ old('email_address', $tournament->email_address) }}" 
                               placeholder="Email" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="url" name="website_social" 
                               value="{{ old('website_social', $tournament->website_social) }}" 
                               placeholder="Website/Social" />
                    </div>
                </div>
            </div>
        </section>

        {{-- Dates & Location --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">02</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Date &amp; Location</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                    <div class="space-y-md">
                        <h3 class="font-label-md uppercase tracking-wider">Registration</h3>
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="date" name="registration_opens" 
                               value="{{ old('registration_opens', $tournament->registration_opens->format('Y-m-d')) }}" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="date" name="registration_closes" 
                               value="{{ old('registration_closes', $tournament->registration_closes->format('Y-m-d')) }}" required />
                    </div>
                    <div class="space-y-md">
                        <h3 class="font-label-md uppercase tracking-wider">Tournament</h3>
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="date" name="tournament_start_date" 
                               value="{{ old('tournament_start_date', $tournament->tournament_start_date->format('Y-m-d')) }}" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="date" name="tournament_end_date" 
                               value="{{ old('tournament_end_date', $tournament->tournament_end_date->format('Y-m-d')) }}" required />
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                    <h3 class="font-label-md uppercase tracking-wider mb-md">Venue Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="text" name="venue_name" 
                               value="{{ old('venue_name', $tournament->venue_name) }}" placeholder="Venue Name" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="text" name="venue_address" 
                               value="{{ old('venue_address', $tournament->venue_address) }}" placeholder="Address" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="text" name="city" 
                               value="{{ old('city', $tournament->city) }}" placeholder="City/LGA" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                               type="text" name="state" 
                               value="{{ old('state', $tournament->state) }}" placeholder="State" required />
                        <input class="w-full border border-outline-variant rounded-2xl px-md py-sm md:col-span-2" 
                               type="text" name="country" 
                               value="{{ old('country', $tournament->country) }}" placeholder="Country" required />
                    </div>
                </div>
            </div>
        </section>

        {{-- Format --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">03</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Competition Format</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <select class="w-full border border-outline-variant rounded-2xl px-md py-sm" name="tournament_format" required>
                    @foreach(['league','round-robin','knockout','group-knockout','league-playoffs','friendly','custom'] as $fmt)
                        <option value="{{ $fmt }}" {{ old('tournament_format', $tournament->tournament_format) == $fmt ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('-', ' ', $fmt)) }}
                        </option>
                    @endforeach
                </select>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" name="number_of_teams" 
                           value="{{ old('number_of_teams', $tournament->number_of_teams) }}" min="2" placeholder="Number of Teams" required />
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" name="max_players_per_team" 
                           value="{{ old('max_players_per_team', $tournament->max_players_per_team) }}" min="1" placeholder="Max Players" required />
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" name="min_players_per_team" 
                           value="{{ old('min_players_per_team', $tournament->min_players_per_team) }}" min="1" placeholder="Min Players" required />
                </div>
            </div>
        </section>

        {{-- Registration --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">04</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Team Registration</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <select class="w-full border border-outline-variant rounded-2xl px-md py-sm" name="registration_method" required>
                    @foreach(['free','paid','invitation'] as $m)
                        <option value="{{ $m }}" {{ old('registration_method', $tournament->registration_method) == $m ? 'selected' : '' }}>
                            {{ ucfirst($m) }}
                        </option>
                    @endforeach
                </select>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" step="0.01" name="registration_fee" 
                           value="{{ old('registration_fee', $tournament->registration_fee) }}" placeholder="Registration Fee" />
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" name="max_teams" 
                           value="{{ old('max_teams', $tournament->max_teams) }}" min="2" placeholder="Max Teams" required />
                </div>

                <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                       type="date" name="team_registration_deadline" 
                       value="{{ old('team_registration_deadline', $tournament->team_registration_deadline->format('Y-m-d')) }}" required />

                <textarea class="w-full border border-outline-variant rounded-2xl px-md py-sm min-h-[100px]" 
                          name="team_eligibility" placeholder="Team Eligibility Requirements">{{ old('team_eligibility', $tournament->team_eligibility) }}</textarea>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-md bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                    <label class="flex items-center justify-between">
                        <span class="font-label-md">Manager Details Required</span>
                        <input type="checkbox" name="requires_manager_details" value="1" 
                               {{ old('requires_manager_details', $tournament->requires_manager_details) ? 'checked' : '' }} />
                    </label>
                    <label class="flex items-center justify-between">
                        <span class="font-label-md">Player Roster Required</span>
                        <input type="checkbox" name="requires_player_roster" value="1" 
                               {{ old('requires_player_roster', $tournament->requires_player_roster) ? 'checked' : '' }} />
                    </label>
                </div>
            </div>
        </section>

        {{-- Rules --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">05</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Rules</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <textarea class="w-full border border-outline-variant rounded-2xl px-md py-sm min-h-[120px]" 
                          name="tournament_rules" placeholder="Tournament Rules">{{ old('tournament_rules', $tournament->tournament_rules) }}</textarea>
                <textarea class="w-full border border-outline-variant rounded-2xl px-md py-sm min-h-[120px]" 
                          name="match_rules" placeholder="Match Rules">{{ old('match_rules', $tournament->match_rules) }}</textarea>
            </div>
        </section>

        {{-- Prizes --}}
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl mb-2xl">
            <div class="lg:col-span-4">
                <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">06</span>
                <h2 class="font-headline-md text-headline-md text-on-surface">Prize &amp; Awards</h2>
            </div>
            <div class="lg:col-span-8 flex flex-col gap-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" step="0.01" name="winner_prize" 
                           value="{{ old('winner_prize', $tournament->winner_prize) }}" placeholder="Winner Prize" />
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" step="0.01" name="runner_up_prize" 
                           value="{{ old('runner_up_prize', $tournament->runner_up_prize) }}" placeholder="Runner-Up Prize" />
                    <input class="w-full border border-outline-variant rounded-2xl px-md py-sm" 
                           type="number" step="0.01" name="third_place_prize" 
                           value="{{ old('third_place_prize', $tournament->third_place_prize) }}" placeholder="3rd Place Prize" />
                </div>
                <textarea class="w-full border border-outline-variant rounded-2xl px-md py-sm min-h-[80px]" 
                          name="additional_prize_details" placeholder="Additional Prize Details">{{ old('additional_prize_details', $tournament->additional_prize_details) }}</textarea>
            </div>
        </section>

        {{-- Actions --}}
        <div class="flex justify-end gap-md pt-2xl border-t border-outline-variant/30">
            <a href="{{ route('organizer.tournaments.show', $tournament) }}" 
               class="px-lg py-sm rounded-full border border-outline hover:bg-surface-container-low">
                Cancel
            </a>
            <button type="submit" 
                    class="font-semibold bg-primary text-on-primary px-xl py-sm rounded-full hover:bg-primary/90 shadow-md">
                Save Changes
            </button>
        </div>
    </form>
</main>
@endsection