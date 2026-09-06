{{-- resources/views/player/teams/create.blade.php --}}
@extends('layouts.guest')

@section('title', '5ivezz - Create Team')

@section('content')
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .image-upload-preview {
            position: relative;
            overflow: hidden;
        }

        .image-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

    <!-- Main Workspace -->
    <main class="max-w-[800px] mx-auto px-md md:px-lg pt-4 pb-[140px]">
        <!-- Header -->
        <header class="mb-2xl">
            <div class="flex items-center gap-4 mb-sm">
                <a href="{{ route('player.teams.index') }}"
                    class="text-on-surface-variant hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="font-display-lg text-display-lg text-on-surface">Create your team.</h1>
            </div>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                Build your squad, enter competitions and create your team's football record.
            </p>
        </header>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <h3 class="text-sm font-medium text-red-800 mb-2">Please fix the following errors:</h3>
                <ul class="text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="space-y-2xl relative" method="POST" action="{{ route('player.teams.store') }}"
            enctype="multipart/form-data">
            @csrf

            <!-- Section 01: Team Identity -->
            <section class="group">
                <div class="flex items-center gap-sm mb-lg">
                    <span class="font-headline-sm text-headline-sm text-primary">01</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Team Identity</h2>
                </div>
                <div class="space-y-lg">
                    <!-- Premium Image Uploader -->
                    <div class="w-full h-[240px] bg-surface-container border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-surface-container-high hover:border-primary transition-colors group relative image-upload-preview"
                        id="logoUpload">
                        <div id="logoPlaceholder" class="flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 rounded-full bg-primary-container/20 flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-primary text-[32px]">add_photo_alternate</span>
                            </div>
                            <p class="font-label-md text-label-md text-on-surface font-medium">Upload Team Logo</p>
                            <p class="font-label-sm text-label-sm text-on-surface-variant mt-1">Recommended: 1024x1024px PNG
                            </p>
                        </div>
                        <img id="logoPreview" class="absolute inset-0 w-full h-full object-contain hidden"
                            alt="Logo preview" />
                        <input type="file" name="logo" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewLogo(this)" />
                        @error('logo')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Inputs -->
                    <div class="space-y-md">
                        <div class="relative">
                            <label class="block font-label-md text-label-md text-on-surface mb-xs" for="name">Team Name
                                <span class="text-red-500">*</span></label>
                            <input
                                class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-primary px-4 py-3 rounded-t-lg font-body-md text-on-surface placeholder:text-outline transition-colors focus:ring-0 @error('name') border-error @enderror"
                                id="name" name="name" placeholder="e.g. Dynamo Athletic" type="text"
                                value="{{ old('name') }}" required />
                            @error('name')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="relative">
                            <label class="block font-label-md text-label-md text-on-surface mb-xs"
                                for="description">Description (Optional)</label>
                            <textarea
                                class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-primary px-4 py-3 rounded-t-lg font-body-md text-on-surface placeholder:text-outline transition-colors focus:ring-0 resize-none @error('description') border-error @enderror"
                                id="description" name="description" placeholder="Tell us about your squad..."
                                rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <!-- Divider -->
            <hr class="border-outline-variant/30" />

            <!-- Section 02: Team Type -->
            <section>
                <div class="flex items-center gap-sm mb-lg">
                    <span class="font-headline-sm text-headline-sm text-primary">02</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Team Type</h2>
                </div>
                <div class="flex flex-wrap gap-sm">
                    @foreach(['amateur' => 'Amateur', 'academy' => 'Academy', 'school' => 'School', 'casual' => 'Casual / Sunday League'] as $value => $label)
                        <label class="cursor-pointer">
                            <input class="peer sr-only" name="team_type" type="radio" value="{{ $value }}" {{ old('team_type', 'amateur') == $value ? 'checked' : '' }} />
                            <div
                                class="px-lg py-sm rounded-full border border-outline-variant text-on-surface-variant font-label-md text-label-md transition-all peer-checked:bg-primary peer-checked:text-on-primary peer-checked:border-primary hover:bg-surface-variant/50">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('team_type')
                    <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                @enderror
            </section>

            <!-- Divider -->
            <hr class="border-outline-variant/30" />

            <!-- Section 03: Location -->
            <section>
                <div class="flex items-center gap-sm mb-lg">
                    <span class="font-headline-sm text-headline-sm text-primary">03</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Base Location</h2>
                </div>

                <div class="space-y-md">
                    <!-- Country -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs" for="country">Country <span
                                class="text-red-500">*</span></label>
                        <select
                            class="w-full bg-surface-container-low border border-outline-variant/50 focus:border-primary px-4 py-3 rounded-lg font-body-md text-on-surface transition-colors focus:ring-0 shadow-sm @error('country') border-error @enderror"
                            id="country" name="country" required>
                            <option value="">Select Country</option>
                            <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                            <option value="Ghana" {{ old('country') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                            <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                            <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa
                            </option>
                            <option value="Others" {{ old('country') == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                        @error('country')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- State -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs" for="state">State <span
                                class="text-red-500">*</span></label>
                        <select
                            class="w-full bg-surface-container-low border border-outline-variant/50 focus:border-primary px-4 py-3 rounded-lg font-body-md text-on-surface transition-colors focus:ring-0 shadow-sm @error('state') border-error @enderror"
                            id="state" name="state" required>
                            <option value="">Select State</option>
                            @foreach($states as $stateName => $lgas)
                                <option value="{{ $stateName }}" {{ old('state') == $stateName ? 'selected' : '' }}>
                                    {{ $stateName }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City/LGA -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs" for="city">City / LGA <span
                                class="text-red-500">*</span></label>
                        <select
                            class="w-full bg-surface-container-low border border-outline-variant/50 focus:border-primary px-4 py-3 rounded-lg font-body-md text-on-surface transition-colors focus:ring-0 shadow-sm @error('city') border-error @enderror"
                            id="city" name="city" required>
                            <option value="">Select City/LGA</option>
                            @if(old('state') && isset($states[old('state')]))
                                @foreach($states[old('state')] as $lga)
                                    <option value="{{ $lga }}" {{ old('city') == $lga ? 'selected' : '' }}>
                                        {{ $lga }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('city')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Map Visual (optional) -->
                    <div
                        class="w-full h-48 rounded-xl overflow-hidden relative shadow-sm border border-outline-variant/20 bg-surface-container">
                        <img class="w-full h-full object-cover opacity-80 mix-blend-multiply"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfFgfhhuZc4wWHkBJOjRZdH-e9S6QuGLFN8tuizo6rRQL5qVZ7ywyHU06LWukGAzBAewOyjvDoRRWCRZcCoi1cr0Jo8e2itW5hXTPONvO2WyoVxHQG49U1H_HJgt-H2pbKbLIiQhU5yF10q2btgPQ909vXu4OdRtj5oNayq47D3Q_kdcLRXOSeT6HBcWjwM2BZpaTLo2Pz65pMv0nDHZl3dEqWNe9gWmEamzkx5LVAtOG7vw9YG9i-yA" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-surface-container/80 to-transparent flex items-end p-md">
                            <div
                                class="bg-surface/90 backdrop-blur-sm px-sm py-xs rounded-md shadow-sm flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                                <span class="font-label-sm text-label-sm text-on-surface">
                                    @if(old('city') && old('state'))
                                        {{ old('city') }}, {{ old('state') }}
                                    @else
                                        Location pending
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Divider -->
            <hr class="border-outline-variant/30" />

            <!-- Section 04: Team Management -->
            <section>
                <div class="flex items-center gap-sm mb-lg">
                    <span class="font-headline-sm text-headline-sm text-primary">04</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Management</h2>
                </div>
                <p class="font-body-md text-on-surface-variant mb-md">You will be assigned as the primary team
                    administrator.</p>
                <div
                    class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl p-md flex items-center gap-md shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <div
                        class="w-12 h-12 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden">
                        <img class="w-full h-full object-cover" src="{{ Auth::user()->avatar_url }}"
                            alt="{{ Auth::user()->full_name }}" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-label-md text-label-md text-on-surface">{{ Auth::user()->full_name }}</h3>
                        <p class="font-body-md text-sm text-on-surface-variant">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="px-sm py-1 rounded-full bg-primary-container/20 border border-primary/10">
                        <span class="font-label-sm text-label-sm text-primary-container font-semibold">Admin</span>
                    </div>
                </div>
            </section>

            <!-- Divider -->
            <hr class="border-outline-variant/30" />

            <!-- Section 05: Squad -->
            <section class="pb-xl">
                <div class="flex items-center justify-between mb-lg">
                    <div class="flex items-center gap-sm">
                        <span class="font-headline-sm text-headline-sm text-primary">05</span>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Initial Squad</h2>
                    </div>
                    <span
                        class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-sm py-1 rounded-full">You
                        + 0 Players</span>
                </div>
                <div class="bg-primary/5 border border-primary/20 rounded-xl p-lg relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4">
                    </div>
                    <h3 class="font-label-md text-label-md text-on-surface mb-xs relative z-10">Your unique Invite Code</h3>
                    <p class="font-body-md text-on-surface-variant mb-md relative z-10">Share this code with players so they
                        can link to your team roster.</p>
                    <div
                        class="flex items-center justify-between bg-surface-container-lowest border border-outline-variant/50 rounded-lg p-sm relative z-10">
                        <span
                            class="font-headline-md text-headline-md font-mono text-primary tracking-widest pl-2">{{ strtoupper(Str::random(8)) }}</span>
                        <button type="button" onclick="copyCode()"
                            class="p-2 rounded-md hover:bg-surface-variant transition-colors text-on-surface flex items-center justify-center group">
                            <span
                                class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">content_copy</span>
                        </button>
                    </div>
                    <p class="font-label-sm text-label-sm text-on-surface-variant mt-3 relative z-10">
                        <span class="material-symbols-outlined text-[16px] align-middle">info</span>
                        You'll receive your permanent invite code after creating the team.
                    </p>
                </div>
            </section>

            <!-- Sticky Action Bar -->
            <div
                class="fixed bottom-0 left-0 w-full z-40 bg-surface/90 backdrop-blur-xl border-t border-outline-variant/20 pb-[100px] md:pb-lg pt-md px-md md:px-lg shadow-[0_-4px_24px_rgba(0,0,0,0.05)]">
                <div class="max-w-[800px] mx-auto flex justify-between items-center">
                    <span class="font-body-md text-on-surface-variant hidden sm:block">Ready to hit the pitch?</span>
                    <div class="flex gap-3 w-full sm:w-auto">
                        <a href="{{ route('player.teams.index') }}"
                            class="px-6 py-2 rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-primary text-on-primary font-label-md text-label-md px-xl py-sm rounded-lg hover:bg-primary/90 active:scale-95 transition-all shadow-md flex items-center gap-2 flex-1 sm:flex-none justify-center">
                            Create Team
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    @push('scripts')
        <script>
            function copyCode() {
                const code = document.querySelector('.font-mono').textContent;
                navigator.clipboard.writeText(code).then(() => {
                    const btn = event.target.closest('button');
                    const icon = btn.querySelector('.material-symbols-outlined');
                    icon.textContent = 'check';
                    setTimeout(() => {
                        icon.textContent = 'content_copy';
                    }, 2000);
                });
            }

            function previewLogo(input) {
                const preview = document.getElementById('logoPreview');
                const placeholder = document.getElementById('logoPlaceholder');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    preview.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const stateSelect = document.getElementById('state');
                const citySelect = document.getElementById('city');
                const statesData = @json($states);

                if (stateSelect && citySelect) {
                    stateSelect.addEventListener('change', function () {
                        const selectedState = this.value;
                        const lgas = statesData[selectedState] || [];

                        // Clear current options
                        citySelect.innerHTML = '<option value="">Select City/LGA</option>';

                        // Add new options
                        lgas.forEach(function (lga) {
                            const option = document.createElement('option');
                            option.value = lga;
                            option.textContent = lga;
                            citySelect.appendChild(option);
                        });
                    });
                }
            });

            // Update location display when city or state changes
            document.addEventListener('DOMContentLoaded', function () {
                const stateSelect = document.getElementById('state');
                const citySelect = document.getElementById('city');
                const locationDisplay = document.querySelector('.bg-surface/90 .font-label-sm');

                function updateLocationDisplay() {
                    if (locationDisplay) {
                        const city = citySelect.value;
                        const state = stateSelect.value;
                        if (city && state) {
                            locationDisplay.textContent = city + ', ' + state;
                        } else if (state) {
                            locationDisplay.textContent = state;
                        } else {
                            locationDisplay.textContent = 'Location pending';
                        }
                    }
                }

                if (stateSelect) {
                    stateSelect.addEventListener('change', updateLocationDisplay);
                }
                if (citySelect) {
                    citySelect.addEventListener('change', updateLocationDisplay);
                }
            });
        </script>
    @endpush
@endsection