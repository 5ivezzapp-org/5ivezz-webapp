{{-- resources/views/player/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', '5ivezz - Player Registration')

@section('content')
    <style>
        .input-premium {
            height: 52px;
            border-radius: 16px;
            border: 1px solid #bec9c9;
            background-color: #ffffff;
            transition: all 0.2s ease;
            padding: 0 16px;
            width: 100%;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: #181c1c;
        }

        .input-premium:focus {
            border-color: #00595c;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 89, 92, 0.1);
        }

        .input-premium::placeholder {
            color: #6e7979;
            opacity: 0.5;
        }

        .input-premium-error {
            border-color: #dc2626 !important;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        textarea.input-premium {
            height: auto;
            padding: 12px 16px;
            resize: none;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .level-btn {
            transition: all 0.2s ease;
        }

        .level-btn.active {
            border-color: #00595c;
            background-color: rgba(0, 89, 92, 0.1);
            color: #00595c;
        }
    </style>

    <!-- Header Section -->
    <header class="px-md md:px-lg max-w-[1200px] mx-auto pt-2xl pb-lg">
        <h1 class="font-display-lg text-display-lg text-primary mb-sm">Create your football identity.</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Your matches, teams and achievements will
            grow with you.</p>
    </header>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="max-w-[1200px] mx-auto px-md md:px-lg mb-6">
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Workspace -->
    <main class="px-md md:px-lg max-w-[1200px] mx-auto grid gap-2xl relative pb-32">
        <form method="POST" action="{{ route('player.register') }}" enctype="multipart/form-data">
            @csrf

            <!-- 01 Identity -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-lg items-start">
                <div class="md:col-span-3 sticky top-lg">
                    <span class="font-headline-lg text-headline-lg text-outline/30 block mb-base">01</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary">Identity</h2>
                </div>
                <div class="md:col-span-9 glass-card rounded-2xl p-lg space-y-md">
                    <div class="flex items-center gap-md">
                        <div class="relative w-24 h-24 rounded-full bg-surface-variant flex items-center justify-center border-2 border-dashed border-outline-variant hover:border-primary transition-colors overflow-hidden">
                            <span class="material-symbols-outlined text-outline" id="avatarPlaceholder">add_a_photo</span>
                            <img id="avatarPreview" class="w-full h-full object-cover hidden" alt="Avatar preview" />
                            <input type="file" name="avatar" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="previewAvatar(this)" />
                        </div>
                        <div>
                            <p class="font-label-md text-label-md text-on-surface">Profile Photo</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant">Recommended 500x500px.</p>
                            @error('avatar')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="first_name">First Name <span class="text-red-500">*</span></label>
                            <input class="input-premium @error('first_name') input-premium-error @enderror" 
                                id="first_name" name="first_name" placeholder="Enter first name"
                                type="text" value="{{ old('first_name') }}" required />
                            @error('first_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="last_name">Last Name <span class="text-red-500">*</span></label>
                            <input class="input-premium @error('last_name') input-premium-error @enderror" 
                                id="last_name" name="last_name" placeholder="Enter last name"
                                type="text" value="{{ old('last_name') }}" required />
                            @error('last_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="date_of_birth">Date of
                                Birth</label>
                            <input class="input-premium @error('date_of_birth') input-premium-error @enderror" 
                                id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth') }}" />
                            @error('date_of_birth')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="gender">Gender</label>
                            <select class="input-premium appearance-none bg-transparent @error('gender') input-premium-error @enderror" 
                                id="gender" name="gender">
                                <option value="">Select gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="relative">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="email">Email Address <span class="text-red-500">*</span></label>
                        <input class="input-premium @error('email') input-premium-error @enderror" 
                            id="email" name="email" placeholder="Enter email address" type="email"
                            value="{{ old('email') }}" required />
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="password">Password <span class="text-red-500">*</span></label>
                            <input class="input-premium @error('password') input-premium-error @enderror" 
                                id="password" name="password" placeholder="Min. 8 characters" type="password" required />
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="password_confirmation">Confirm Password <span class="text-red-500">*</span></label>
                            <input class="input-premium @error('password_confirmation') input-premium-error @enderror" 
                                id="password_confirmation" name="password_confirmation" placeholder="Confirm password" type="password" required />
                            @error('password_confirmation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <!-- 02 Football Profile -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-lg items-start">
                <div class="md:col-span-3 sticky top-lg">
                    <span class="font-headline-lg text-headline-lg text-outline/30 block mb-base">02</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary">Football Profile</h2>
                </div>
                <div class="md:col-span-9 glass-card rounded-2xl p-lg space-y-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="position">Primary Position</label>
                            <select class="input-premium appearance-none bg-transparent @error('position') input-premium-error @enderror" 
                                id="position" name="position">
                                <option value="">Select position</option>
                                <option value="gk" {{ old('position') == 'gk' ? 'selected' : '' }}>Goalkeeper</option>
                                <option value="def" {{ old('position') == 'def' ? 'selected' : '' }}>Defender</option>
                                <option value="mid" {{ old('position') == 'mid' ? 'selected' : '' }}>Midfielder</option>
                                <option value="fwd" {{ old('position') == 'fwd' ? 'selected' : '' }}>Forward</option>
                            </select>
                            @error('position')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="preferred_foot">Preferred Foot</label>
                            <select class="input-premium appearance-none bg-transparent @error('preferred_foot') input-premium-error @enderror" 
                                id="preferred_foot" name="preferred_foot">
                                <option value="">Select foot</option>
                                <option value="right" {{ old('preferred_foot') == 'right' ? 'selected' : '' }}>Right</option>
                                <option value="left" {{ old('preferred_foot') == 'left' ? 'selected' : '' }}>Left</option>
                                <option value="both" {{ old('preferred_foot') == 'both' ? 'selected' : '' }}>Both</option>
                            </select>
                            @error('preferred_foot')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="relative">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="bio">Bio
                            (Optional)</label>
                        <textarea class="input-premium h-24 @error('bio') input-premium-error @enderror" id="bio" name="bio"
                            placeholder="Tell us about your playstyle...">{{ old('bio') }}</textarea>
                        @error('bio')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-sm">Playing Level</label>
                        <div class="flex flex-wrap gap-sm">
                            <button type="button"
                                class="level-btn px-md py-xs rounded-full border border-outline-variant hover:border-primary hover:bg-surface-variant transition-colors font-label-md text-label-md text-on-surface playing-level {{ old('playing_level') == 'casual' ? 'active' : '' }}"
                                data-value="casual">Casual</button>
                            <button type="button"
                                class="level-btn px-md py-xs rounded-full border border-outline-variant hover:border-primary hover:bg-surface-variant transition-colors font-label-md text-label-md text-on-surface playing-level {{ old('playing_level', 'amateur') == 'amateur' ? 'active' : '' }}"
                                data-value="amateur">Amateur</button>
                            <button type="button"
                                class="level-btn px-md py-xs rounded-full border border-outline-variant hover:border-primary hover:bg-surface-variant transition-colors font-label-md text-label-md text-on-surface playing-level {{ old('playing_level') == 'semi-pro' ? 'active' : '' }}"
                                data-value="semi-pro">Semi-Pro</button>
                            <button type="button"
                                class="level-btn px-md py-xs rounded-full border border-outline-variant hover:border-primary hover:bg-surface-variant transition-colors font-label-md text-label-md text-on-surface playing-level {{ old('playing_level') == 'professional' ? 'active' : '' }}"
                                data-value="professional">Professional</button>
                        </div>
                        <input type="hidden" name="playing_level" id="playing_level" value="{{ old('playing_level', 'amateur') }}" />
                        @error('playing_level')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- 03 Location -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-lg items-start">
                <div class="md:col-span-3 sticky top-lg">
                    <span class="font-headline-lg text-headline-lg text-outline/30 block mb-base">03</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary">Location</h2>
                </div>
                <div class="md:col-span-9 glass-card rounded-2xl p-lg space-y-md">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs" for="state">State
                                / Region</label>
                            <input class="input-premium @error('state') input-premium-error @enderror" 
                                id="state" name="state" placeholder="Enter state" type="text"
                                value="{{ old('state') }}" />
                            @error('state')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                                for="city">City</label>
                            <input class="input-premium @error('city') input-premium-error @enderror" 
                                id="city" name="city" placeholder="Enter city" type="text"
                                value="{{ old('city') }}" />
                            @error('city')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <!-- 04 Team -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-lg items-start">
                <div class="md:col-span-3 sticky top-lg">
                    <span class="font-headline-lg text-headline-lg text-outline/30 block mb-base">04</span>
                    <h2 class="font-headline-sm text-headline-sm text-primary">Team</h2>
                </div>
                <div class="md:col-span-9 glass-card rounded-2xl p-lg space-y-md">
                    <div class="relative">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs"
                            for="invite_code">Invite Code (Optional)</label>
                        <input class="input-premium uppercase font-mono tracking-widest @error('invite_code') input-premium-error @enderror" 
                            id="invite_code" name="invite_code"
                            placeholder="XXXX-XXXX" type="text" value="{{ old('invite_code') }}" />
                        <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">If you received an invite to
                            join a team, enter it here.</p>
                        @error('invite_code')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Submit Button -->
            <div class="pt-5  w-full z-40 px-md md:px-lg flex justify-center pointer-events-none"
                style="margin-bottom: 80px;">
                <div class="w-full max-w-md pointer-events-auto">
                    <button type="submit"
                        class="w-full bg-primary hover:bg-surface-tint text-on-primary font-headline-sm text-headline-sm rounded-full py-sm px-lg shadow-lg flex items-center justify-between active:scale-[0.98] transition-all">
                        <span>Create Football Identity</span>
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
                    </button>
                </div>
            </div>
        </form>
    </main>

    @push('scripts')
        <script>
            // Avatar preview
            function previewAvatar(input) {
                const placeholder = document.getElementById('avatarPlaceholder');
                const preview = document.getElementById('avatarPreview');
                
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Playing level selection
            document.querySelectorAll('.playing-level').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.playing-level').forEach(b => {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                    document.getElementById('playing_level').value = this.dataset.value;
                });
            });
        </script>
    @endpush
@endsection