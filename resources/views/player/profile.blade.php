{{-- resources/views/player/profile.blade.php --}}
@extends('layouts.guest')

@section('title', '5ivezz Private Profile')

@section('content')
    <style>
        .profile-avatar-container {
            position: relative;
            display: inline-block;
        }
        
        .profile-avatar-container .edit-avatar-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #ffffff;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            cursor: pointer;
            transition: transform 0.2s ease;
            border: 2px solid #fff;
        }
        
        .profile-avatar-container .edit-avatar-btn:hover {
            transform: scale(1.1);
        }
        
        .stat-badge {
            background: rgba(0,0,0,0.03);
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.2s ease;
        }
        
        .stat-badge:hover {
            background: rgba(0,0,0,0.06);
            transform: translateY(-2px);
        }
        
        .activity-item {
            transition: all 0.2s ease;
        }
        
        .activity-item:hover {
            background: rgba(0,0,0,0.02);
        }
        
        .team-card {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        .error-text {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .success-text {
            color: #16a34a;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-input-error {
            border-color: #dc2626 !important;
        }
    </style>

    <!-- Display Success/Error Messages -->
    @if(session('success'))
        <div class="max-w-[1200px] mx-auto px-md pt-lg">
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-[1200px] mx-auto px-md pt-lg">
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-700">{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <header class="pt-2xl pb-lg px-md md:px-0 max-w-[1200px] mx-auto text-center">
        <div class="profile-avatar-container mb-md">
            @if($user->avatar)
                <img class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-surface-container-lowest"
                    src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->full_name }}" />
            @else
                <img class="w-32 h-32 rounded-full object-cover shadow-lg border-4 border-surface-container-lowest"
                    src="https://ui-avatars.com/api/?name={{ urlencode($user->full_name) }}&size=128&background=0D9488&color=fff&bold=true" 
                    alt="{{ $user->full_name }}" />
            @endif
            <form id="avatarForm" action="{{ route('player.profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="avatarUpload" name="avatar" accept="image/*" style="display: none;" onchange="this.form.submit()">
                <button type="button" class="edit-avatar-btn" onclick="document.getElementById('avatarUpload').click()">
                    <span class="material-symbols-outlined text-primary" style="font-size: 20px;">edit</span>
                </button>
            </form>
        </div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-xs">{{ $user->full_name }}</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mb-lg">{{ '@' . strtolower(str_replace(' ', '', $user->full_name)) . rand(10, 99) }}</p>
        <a href="{{ route('player.dashboard') }}"
            class="bg-primary text-on-primary font-label-md text-label-md py-sm px-xl rounded-full shadow-md hover:bg-primary/90 transition-colors hover:scale-[0.98] active:scale-95 inline-block">
            View Dashboard
        </a>
    </header>

    <!-- Main Content Container -->
    <main class="max-w-[1200px] mx-auto px-md grid grid-cols-1 md:grid-cols-12 gap-lg pb-2xl">
        <!-- Left Column / Top (Mobile) -->
        <div class="md:col-span-8 flex flex-col gap-lg">
            <!-- Personal Information -->
            <section
                class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <div class="flex items-center justify-between mb-md">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary">person</span>
                        Personal Information
                    </h2>
                    <button onclick="toggleEdit('personal')" class="text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined">edit_square</span>
                    </button>
                </div>
                
                <!-- Display Mode -->
                <div id="personalDisplay" class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Full Name</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->full_name }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Email</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Date of Birth</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->date_of_birth ? $user->date_of_birth->format('M d, Y') : 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Gender</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ ucfirst($user->gender ?? 'Not set') }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">City</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->city ?? 'Not set' }}</p>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">State</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->state ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <form id="personalForm" action="{{ route('player.profile.update') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-md">
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('first_name') form-input-error @enderror">
                            @error('first_name')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('last_name') form-input-error @enderror">
                            @error('last_name')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('date_of_birth') form-input-error @enderror">
                            @error('date_of_birth')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Gender</label>
                            <select name="gender" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('gender') form-input-error @enderror">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city', $user->city) }}" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('city') form-input-error @enderror">
                            @error('city')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">State</label>
                            <input type="text" name="state" value="{{ old('state', $user->state) }}" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('state') form-input-error @enderror">
                            @error('state')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Save Changes
                        </button>
                        <button type="button" onclick="toggleEdit('personal')" class="bg-surface border border-outline-variant px-4 py-2 rounded-lg hover:bg-surface-container-low transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </section>

            <!-- Football Identity -->
            <section
                class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <div class="flex items-center justify-between mb-md">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-primary">sports_soccer</span>
                        Football Identity
                    </h2>
                    <button onclick="toggleEdit('football')" class="text-primary hover:text-primary/80 transition-colors">
                        <span class="material-symbols-outlined">edit_square</span>
                    </button>
                </div>
                
                <!-- Display Mode -->
                <div id="footballDisplay">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-md mb-md">
                        <div class="stat-badge p-sm rounded-lg text-center">
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Position</label>
                            <p class="font-headline-sm text-headline-sm text-primary">{{ strtoupper($user->position ?? 'N/A') }}</p>
                        </div>
                        <div class="stat-badge p-sm rounded-lg text-center">
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Strong Foot</label>
                            <p class="font-headline-sm text-headline-sm text-primary">{{ ucfirst($user->preferred_foot ?? 'N/A') }}</p>
                        </div>
                        <div class="stat-badge p-sm rounded-lg text-center col-span-2 sm:col-span-1">
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Playing Level</label>
                            <p class="font-headline-sm text-headline-sm text-primary">{{ ucfirst($user->playing_level ?? 'N/A') }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Bio</label>
                        <p class="font-body-md text-body-md text-on-surface">{{ $user->bio ?? 'No bio added yet. Tell the world about your football journey!' }}</p>
                    </div>
                </div>

                <!-- Edit Mode -->
                <form id="footballForm" action="{{ route('player.profile.update') }}" method="POST" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Position</label>
                            <input type="text" name="position" value="{{ old('position', $user->position) }}" 
                                placeholder="e.g., CM, ST, CB" 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('position') form-input-error @enderror">
                            @error('position')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Preferred Foot</label>
                            <select name="preferred_foot" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('preferred_foot') form-input-error @enderror">
                                <option value="">Select Preferred Foot</option>
                                <option value="right" {{ old('preferred_foot', $user->preferred_foot) == 'right' ? 'selected' : '' }}>Right</option>
                                <option value="left" {{ old('preferred_foot', $user->preferred_foot) == 'left' ? 'selected' : '' }}>Left</option>
                                <option value="both" {{ old('preferred_foot', $user->preferred_foot) == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('preferred_foot')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Playing Level</label>
                            <select name="playing_level" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('playing_level') form-input-error @enderror">
                                <option value="casual" {{ old('playing_level', $user->playing_level) == 'casual' ? 'selected' : '' }}>Casual</option>
                                <option value="amateur" {{ old('playing_level', $user->playing_level) == 'amateur' ? 'selected' : '' }}>Amateur</option>
                                <option value="semi-pro" {{ old('playing_level', $user->playing_level) == 'semi-pro' ? 'selected' : '' }}>Semi-Pro</option>
                                <option value="professional" {{ old('playing_level', $user->playing_level) == 'professional' ? 'selected' : '' }}>Professional</option>
                            </select>
                            @error('playing_level')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Bio</label>
                            <textarea name="bio" rows="3" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('bio') form-input-error @enderror">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-primary text-on-primary px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                            Save Changes
                        </button>
                        <button type="button" onclick="toggleEdit('football')" class="bg-surface border border-outline-variant px-4 py-2 rounded-lg hover:bg-surface-container-low transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </section>

            <!-- Change Password -->
            <section
                class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <h2 class="font-headline-sm text-headline-sm text-on-surface mb-md flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">lock</span>
                    Change Password
                </h2>
                <form action="{{ route('player.profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-3">
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Current Password <span class="text-red-500">*</span></label>
                            <input type="password" name="current_password" required 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('current_password') form-input-error @enderror">
                            @error('current_password')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">New Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary @error('password') form-input-error @enderror">
                            @error('password')
                                <p class="error-text">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="font-label-sm text-label-sm text-on-surface-variant block mb-1">Confirm Password <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required 
                                class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                    </div>
                    <button type="submit" class="mt-3 bg-primary text-on-primary px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                        Update Password
                    </button>
                </form>
            </section>

            <!-- My Activity (Matches/Tournaments) -->
            <section
                class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <h2 class="font-headline-sm text-headline-sm text-on-surface mb-md flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">history</span>
                    Recent Activity
                </h2>
                
                @if($recentMatches->isNotEmpty())
                    <div class="flex flex-col gap-sm">
                        @foreach($recentMatches as $match)
                            <div class="activity-item flex items-center gap-md p-sm rounded-lg cursor-pointer border-b border-surface-variant last:border-0">
                                <div class="w-12 h-12 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">sports_soccer</span>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-label-md text-label-md text-on-surface">{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}</h3>
                                    <p class="font-body-md text-body-md text-on-surface-variant text-sm">
                                        Score: {{ $match->home_score ?? '0' }} - {{ $match->away_score ?? '0' }}
                                        @if($match->winner)
                                            · {{ $match->winner }} won
                                        @endif
                                    </p>
                                </div>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">{{ $match->match_datetime->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 48px;">sports_soccer</span>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-2">No recent matches</p>
                        <p class="font-body-sm text-body-sm text-on-surface-variant/60">Start playing to see your activity here!</p>
                    </div>
                @endif
            </section>
        </div>

        <!-- Right Column / Bottom (Mobile) -->
        <div class="md:col-span-4 flex flex-col gap-lg">
            <!-- Current Team -->
            @if($user->team)
                <section class="team-card text-white rounded-xl p-lg relative overflow-hidden shadow-lg">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent">
                    </div>
                    <h2 class="font-label-md text-label-md text-white/80 mb-sm relative z-10 uppercase tracking-widest">
                        Current Team</h2>
                    <div class="flex items-center gap-md relative z-10 mb-md">
                        @if($user->team->logo)
                            <img class="w-16 h-16 rounded-full bg-white object-contain p-1"
                                src="{{ asset('storage/' . $user->team->logo) }}" alt="{{ $user->team->name }}" />
                        @else
                            <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                                {{ substr($user->team->name, 0, 2) }}
                            </div>
                        @endif
                        <div>
                            <h3 class="font-headline-md text-headline-md font-bold">{{ $user->team->name }}</h3>
                            <p class="font-body-md text-body-md opacity-90">{{ ucfirst($teamRole ?? 'Player') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('player.teams.show', $user->team) }}"
                        class="w-full block text-center bg-white text-primary font-label-md text-label-md py-sm rounded-lg hover:bg-gray-100 transition-colors relative z-10">
                        View Team Hub
                    </a>
                </section>
            @else
                <section class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg text-center">
                    <span class="material-symbols-outlined text-on-surface-variant" style="font-size: 48px;">group_add</span>
                    <h3 class="font-headline-md text-headline-md text-on-surface mt-2">No Team Yet</h3>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-4">Join or create a team to start your journey</p>
                    <a href="{{ route('player.teams.index') }}" class="bg-primary text-on-primary px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors inline-block">
                        Find a Team
                    </a>
                </section>
            @endif

            <!-- Player Stats Summary -->
            <section class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <h2 class="font-headline-sm text-headline-sm text-on-surface mb-md flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    Career Stats
                </h2>
                <div class="grid grid-cols-3 gap-2">
                    <div class="stat-badge p-3 rounded-lg text-center">
                        <p class="font-headline-lg text-headline-lg text-primary">{{ $stats['matches'] }}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Matches</p>
                    </div>
                    <div class="stat-badge p-3 rounded-lg text-center">
                        <p class="font-headline-lg text-headline-lg text-primary">{{ $stats['goals'] }}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Goals</p>
                    </div>
                    <div class="stat-badge p-3 rounded-lg text-center">
                        <p class="font-headline-lg text-headline-lg text-primary">{{ $stats['assists'] }}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Assists</p>
                    </div>
                </div>
                @if($achievementsCount > 0)
                    <div class="mt-3 text-center">
                        <span class="inline-flex items-center gap-1 text-primary text-sm">
                            <span class="material-symbols-outlined" style="font-size: 16px;">emoji_events</span>
                            {{ $achievementsCount }} Honours
                        </span>
                    </div>
                @endif
            </section>

            <!-- Wallet -->
            <section class="bg-surface-container-lowest rounded-xl shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-black/5 p-lg">
                <div class="flex items-center justify-between mb-md">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                        <span class="material-symbols-outlined text-secondary">account_balance_wallet</span>
                        5ivezz Wallet
                    </h2>
                </div>
                <div class="bg-surface-container-low rounded-lg p-md mb-md border border-outline-variant/30 flex justify-between items-end">
                    <div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mb-1">Available Balance</p>
                        <p class="font-headline-lg text-headline-lg font-bold text-on-surface">₦0.00</p>
                    </div>
                    <span class="bg-secondary/10 text-secondary font-label-sm text-label-sm py-1 px-2 rounded-full border border-secondary/20">Coming Soon</span>
                </div>
                <div class="flex gap-sm">
                    <button disabled class="flex-1 bg-surface border border-outline text-on-surface-variant font-label-md text-label-md py-sm rounded-lg cursor-not-allowed flex items-center justify-center gap-xs opacity-60">
                        <span class="material-symbols-outlined">add</span> Add Funds
                    </button>
                    <button disabled class="flex-1 bg-surface border border-outline text-on-surface-variant font-label-md text-label-md py-sm rounded-lg cursor-not-allowed flex items-center justify-center gap-xs opacity-60">
                        <span class="material-symbols-outlined">receipt_long</span> History
                    </button>
                </div>
            </section>


            <!-- Sign Out Button -->
            <form method="POST" action="{{ route('player.logout') }}">
                @csrf
                <button type="submit"
                    class="w-full mt-sm py-md font-label-md text-label-md text-red-600 hover:bg-red-50 rounded-lg transition-colors flex items-center justify-center gap-xs">
                    <span class="material-symbols-outlined">logout</span> Sign Out
                </button>
            </form>
        </div>
    </main>

    <script>
        function toggleEdit(section) {
            const display = document.getElementById(section + 'Display');
            const form = document.getElementById(section + 'Form');
            if (display && form) {
                if (display.style.display === 'none') {
                    display.style.display = 'grid';
                    form.style.display = 'none';
                } else {
                    display.style.display = 'none';
                    form.style.display = 'block';
                }
            }
        }

        // Auto-show edit forms if there are validation errors
        @if($errors->any())
            @if($errors->has('first_name') || $errors->has('last_name') || $errors->has('date_of_birth') || $errors->has('gender') || $errors->has('city') || $errors->has('state'))
                document.addEventListener('DOMContentLoaded', function() {
                    toggleEdit('personal');
                });
            @endif
            @if($errors->has('position') || $errors->has('preferred_foot') || $errors->has('playing_level') || $errors->has('bio'))
                document.addEventListener('DOMContentLoaded', function() {
                    toggleEdit('football');
                });
            @endif
        @endif
    </script>
@endsection