{{-- resources/views/tournaments/create.blade.php --}}
@extends('layouts.guest')

@section('title', 'Create Tournament - 5ivezz')

@section('content')
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .input-premium {
            @apply w-full bg-surface-container-lowest border border-outline-variant rounded-2xl px-md py-sm font-body-md text-on-surface focus:outline-none focus:ring-2 focus:ring-primary-container focus:border-transparent transition-all shadow-[0_2px_8px_rgba(0, 0, 0, 0.02)] hover:shadow-[0_4px_12px_rgba(0, 0, 0, 0.04)];
        }

        .section-divider {
            @apply border-t border-surface-container-highest my-3xl;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            width: 48px;
            height: 28px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #bec9c9;
            transition: .3s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }

        .toggle-switch input:checked+.toggle-slider {
            background-color: #0d7377;
        }

        .toggle-switch input:checked+.toggle-slider:before {
            transform: translateX(20px);
        }

        /* Mobile Responsive Overrides */
        @media (max-width: 768px) {
            .input-premium {
                font-size: 16px !important;
                padding: 14px 16px !important;
                min-height: 52px !important;
            }

            select.input-premium {
                background-position: right 12px center !important;
                padding-right: 44px !important;
            }

            textarea.input-premium {
                min-height: 140px !important;
            }

            .glass-panel {
                padding: 12px 16px !important;
                gap: 12px !important;
                flex-wrap: wrap !important;
            }

            .glass-panel button {
                flex: 1;
                min-height: 48px;
                justify-content: center;
                font-size: 15px !important;
                padding: 10px 16px !important;
            }

            main {
                padding-left: 16px !important;
                padding-right: 16px !important;
                padding-bottom: 100px !important;
            }

            .lg\:col-span-4.sticky {
                position: relative !important;
                top: 0 !important;
                margin-bottom: 8px !important;
            }

            section {
                margin-bottom: 8px !important;
            }

            .section-divider {
                margin: 32px 0 !important;
            }

            label.cursor-pointer div {
                padding: 16px !important;
                min-height: 80px !important;
            }

            .grid.md\:grid-cols-2 {
                gap: 12px !important;
            }

            .gap-lg {
                gap: 16px !important;
            }

            .mb-2xl {
                margin-bottom: 24px !important;
            }

            .mt-2xl {
                margin-top: 24px !important;
            }

            .aspect-video {
                min-height: 140px !important;
            }

            .aspect-video .material-symbols-outlined {
                font-size: 36px !important;
            }

            .w-full.h-48 {
                height: 180px !important;
            }

            .font-label-md {
                font-size: 14px !important;
            }

            .font-label-sm {
                font-size: 13px !important;
            }

            .font-headline-lg.text-headline-lg {
                font-size: 48px !important;
            }

            .font-headline-md.text-headline-md {
                font-size: 22px !important;
            }
        }

        @media (max-width: 480px) {
            .glass-panel {
                padding: 10px 12px !important;
                gap: 8px !important;
            }

            .glass-panel button {
                min-height: 44px !important;
                font-size: 14px !important;
                padding: 8px 12px !important;
                border-radius: 12px !important;
            }

            main {
                padding-left: 12px !important;
                padding-right: 12px !important;
                padding-bottom: 90px !important;
            }

            .grid.sm\:grid-cols-3 {
                grid-template-columns: 1fr !important;
                gap: 10px !important;
            }

            .grid.md\:grid-cols-2 {
                grid-template-columns: 1fr !important;
            }

            .section-divider {
                margin: 24px 0 !important;
            }

            .input-premium {
                padding: 12px 14px !important;
                min-height: 48px !important;
                font-size: 15px !important;
            }

            .gap-lg {
                gap: 14px !important;
            }

            .mb-2xl {
                margin-bottom: 20px !important;
            }

            h1.font-display-lg {
                font-size: 28px !important;
            }

            .font-headline-md.text-headline-md {
                font-size: 20px !important;
            }

            .font-headline-lg.text-headline-lg {
                font-size: 40px !important;
            }

            label.cursor-pointer div {
                padding: 14px !important;
                min-height: 64px !important;
                flex-direction: row !important;
                align-items: center !important;
                gap: 12px !important;
            }

            label.cursor-pointer div .material-symbols-outlined {
                font-size: 24px !important;
            }

            label.cursor-pointer div div h4 {
                font-size: 14px !important;
            }

            label.cursor-pointer div div p {
                font-size: 12px !important;
                margin-top: 0 !important;
            }

            .w-full.h-48 {
                height: 140px !important;
            }

            .toggle-switch {
                width: 40px !important;
                height: 24px !important;
            }

            .toggle-slider:before {
                height: 16px !important;
                width: 16px !important;
                left: 4px !important;
                bottom: 4px !important;
            }

            .toggle-switch input:checked+.toggle-slider:before {
                transform: translateX(16px) !important;
            }
        }

        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            .pb-safe {
                padding-bottom: env(safe-area-inset-bottom) !important;
            }
        }

        /* Custom scrollbar for textareas */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: transparent;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #bec9c9;
            border-radius: 10px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #a0a8a8;
        }

        .input-error {
            border-color: #dc2626 !important;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <!-- Main Canvas -->
    <main class="w-full max-w-[1400px] mx-auto px-lg md:px-3xl pt-16 md:pt-4 pb-3xl flex-1">
        <div class="mb-2xl">
            <h1 class="font-display-lg text-display-lg text-on-surface">Build Competition</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant mt-xs">Define the parameters of your next grassroots
                event.</p>
        </div>

        <!-- Error Messages -->
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

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-2xl p-lg mb-xl">
                <p class="font-body-md text-body-md text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('tournaments.store') }}" method="POST" enctype="multipart/form-data" id="tournamentForm">
            @csrf
            <input type="hidden" name="status" id="tournamentStatus" value="draft" />

            <!-- ============================================ -->
            <!-- SECTION 01: TOURNAMENT INFORMATION             -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">01</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Tournament Information</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">The public identity of your
                        competition.</p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <!-- Tournament Name -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Name <span class="text-error">*</span>
                        </label>
                        <input
                            class="input-premium font-headline-sm text-headline-sm !py-md placeholder:text-outline-variant @error('name') input-error @enderror"
                            placeholder="e.g. Summer Cup 2024" type="text" name="name" value="{{ old('name') }}" required />
                        @error('name')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tournament Cover Image -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Cover Image <span class="text-error">*</span>
                        </label>
                        <div class="aspect-video w-full rounded-2xl border-2 border-dashed border-outline-variant bg-surface-container-lowest flex flex-col items-center justify-center cursor-pointer hover:bg-surface-container-low transition-colors group relative @error('cover_image') border-red-400 @enderror"
                            style="min-height:160px;" onclick="document.getElementById('coverImage').click()">
                            <input type="file" id="coverImage" name="cover_image" accept="image/*" class="hidden"
                                onchange="previewCoverImage(this)" />
                            <span
                                class="material-symbols-outlined text-[48px] text-outline-variant group-hover:text-primary transition-colors">add_photo_alternate</span>
                            <span class="font-label-md text-label-md text-on-surface-variant mt-sm text-center px-4">Drag
                                &amp; drop or tap to upload 16:9 image</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant/60 mt-xs">Recommended: 1200 x
                                675px</span>
                            <div id="coverPreview" class="absolute inset-0 rounded-2xl overflow-hidden hidden">
                                <img src="" alt="Cover preview" class="w-full h-full object-cover" />
                            </div>
                        </div>
                        @error('cover_image')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tournament Description -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Description <span class="text-error">*</span>
                        </label>
                        <textarea
                            class="input-premium min-h-[120px] resize-none @error('description') input-error @enderror"
                            placeholder="Provide a brief overview of the tournament..." name="description"
                            required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category & Type Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Tournament Category <span class="text-error">*</span>
                            </label>
                            <select
                                class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('category') input-error @enderror"
                                name="category" required>
                                <option value="">Select Category</option>
                                <option value="youth" {{ old('category') == 'youth' ? 'selected' : '' }}>Youth</option>
                                <option value="adult" {{ old('category') == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="pro-am" {{ old('category') == 'pro-am' ? 'selected' : '' }}>Pro-Am</option>
                                <option value="senior" {{ old('category') == 'senior' ? 'selected' : '' }}>Senior</option>
                                <option value="women" {{ old('category') == 'women' ? 'selected' : '' }}>Women</option>
                                <option value="mixed" {{ old('category') == 'mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                            @error('category')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Tournament Type <span class="text-error">*</span>
                            </label>
                            <select
                                class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('type') input-error @enderror"
                                name="type" required>
                                <option value="">Select Type</option>
                                <option value="u-10" {{ old('type') == 'u-10' ? 'selected' : '' }}>U-10</option>
                                <option value="u-12" {{ old('type') == 'u-12' ? 'selected' : '' }}>U-12</option>
                                <option value="u-14" {{ old('type') == 'u-14' ? 'selected' : '' }}>U-14</option>
                                <option value="u-16" {{ old('type') == 'u-16' ? 'selected' : '' }}>U-16</option>
                                <option value="u-18" {{ old('type') == 'u-18' ? 'selected' : '' }}>U-18</option>
                                <option value="u-21" {{ old('type') == 'u-21' ? 'selected' : '' }}>U-21</option>
                                <option value="open" {{ old('type') == 'open' ? 'selected' : '' }}>Open</option>
                            </select>
                            @error('type')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tournament Edition -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Edition <span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                        </label>
                        <input class="input-premium @error('edition') input-error @enderror"
                            placeholder="e.g. 3rd Edition, 2024 Season" type="text" name="edition"
                            value="{{ old('edition') }}" />
                        @error('edition')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Organizer Information -->
                    <div class="bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                        <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider mb-md">Organizer
                            Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Organization Name <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('organization_name') input-error @enderror"
                                    placeholder="Your organization name" type="text" name="organization_name"
                                    value="{{ old('organization_name', $organizer->company_name ?? '') }}" required />
                                @error('organization_name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Phone Number <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('phone_number') input-error @enderror"
                                    placeholder="+234 800 000 0000" type="tel" name="phone_number"
                                    value="{{ old('phone_number', $organizer->phone ?? '') }}" required />
                                @error('phone_number')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Email Address <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('email_address') input-error @enderror"
                                    placeholder="organizer@email.com" type="email" name="email_address"
                                    value="{{ old('email_address', $organizer->email ?? '') }}" required />
                                @error('email_address')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Website/Social Media <span
                                        class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                                </label>
                                <input class="input-premium @error('website_social') input-error @enderror"
                                    placeholder="https://instagram.com/yourpage" type="url" name="website_social"
                                    value="{{ old('website_social') }}" />
                                @error('website_social')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <!-- ============================================ -->
            <!-- SECTION 02: DATE & LOCATION                   -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">02</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Date &amp; Location</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">When and where the action happens.
                    </p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <!-- Dates Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div class="space-y-md">
                            <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Registration
                            </h3>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">
                                    Registration Opens <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('registration_opens') input-error @enderror" type="date"
                                    name="registration_opens" value="{{ old('registration_opens') }}" required />
                                @error('registration_opens')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">
                                    Registration Closes <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('registration_closes') input-error @enderror" type="date"
                                    name="registration_closes" value="{{ old('registration_closes') }}" required />
                                @error('registration_closes')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-md">
                            <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider">Tournament</h3>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">
                                    Tournament Start Date <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('tournament_start_date') input-error @enderror"
                                    type="date" name="tournament_start_date" value="{{ old('tournament_start_date') }}"
                                    required />
                                @error('tournament_start_date')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-xs">
                                    Tournament End Date <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('tournament_end_date') input-error @enderror" type="date"
                                    name="tournament_end_date" value="{{ old('tournament_end_date') }}" required />
                                @error('tournament_end_date')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Venue Information -->
                    <div class="bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                        <h3 class="font-label-md text-label-md text-on-surface uppercase tracking-wider mb-md">Venue Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Venue Name <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('venue_name') input-error @enderror"
                                    placeholder="e.g. Main Stadium Arena" type="text" name="venue_name"
                                    value="{{ old('venue_name') }}" required />
                                @error('venue_name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Venue Address <span class="text-error">*</span>
                                </label>
                                <input class="input-premium @error('venue_address') input-error @enderror"
                                    placeholder="123 Street Name" type="text" name="venue_address"
                                    value="{{ old('venue_address') }}" required />
                                @error('venue_address')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- In your view, update the state and city fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                        State <span class="text-error">*</span>
                                    </label>
                                    <select
                                        class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('state') input-error @enderror"
                                        name="state" id="stateSelect" required>
                                        <option value="">Select State</option>
                                        @foreach($states as $stateName => $lgas)
                                            <option value="{{ $stateName }}" {{ old('state') == $stateName ? 'selected' : '' }}>
                                                {{ $stateName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                        City/LGA <span class="text-error">*</span>
                                    </label>
                                    <select
                                        class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('city') input-error @enderror"
                                        name="city" id="citySelect" required>
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
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                    Country <span class="text-error">*</span>
                                </label>
                                <select
                                    class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('country') input-error @enderror"
                                    name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="nigeria" {{ old('country') == 'nigeria' ? 'selected' : '' }}>Nigeria
                                    </option>
                                    <option value="ghana" {{ old('country') == 'ghana' ? 'selected' : '' }}>Ghana</option>
                                    <option value="kenya" {{ old('country') == 'kenya' ? 'selected' : '' }}>Kenya</option>
                                    <option value="south-africa" {{ old('country') == 'south-africa' ? 'selected' : '' }}>
                                        South Africa</option>
                                    <option value="others" {{ old('country') == 'others' ? 'selected' : '' }}>Others</option>
                                </select>
                                @error('country')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <!-- ============================================ -->
            <!-- SECTION 03: COMPETITION FORMAT                -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">03</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Competition Format</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Structure your tournament.</p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <!-- Tournament Format -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Format <span class="text-error">*</span>
                        </label>
                        <select
                            class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('tournament_format') input-error @enderror"
                            name="tournament_format" required>
                            <option value="">Select Format</option>
                            <option value="league" {{ old('tournament_format') == 'league' ? 'selected' : '' }}>League
                            </option>
                            <option value="round-robin" {{ old('tournament_format') == 'round-robin' ? 'selected' : '' }}>
                                Round Robin</option>
                            <option value="knockout" {{ old('tournament_format') == 'knockout' ? 'selected' : '' }}>Knockout
                            </option>
                            <option value="group-knockout" {{ old('tournament_format') == 'group-knockout' ? 'selected' : '' }}>Group Stage + Knockout</option>
                            <option value="league-playoffs" {{ old('tournament_format') == 'league-playoffs' ? 'selected' : '' }}>League + Playoffs</option>
                            <option value="friendly" {{ old('tournament_format') == 'friendly' ? 'selected' : '' }}>Friendly
                            </option>
                            <option value="custom" {{ old('tournament_format') == 'custom' ? 'selected' : '' }}>Custom
                            </option>
                        </select>
                        @error('tournament_format')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Team Numbers -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Number of Teams <span class="text-error">*</span>
                            </label>
                            <input class="input-premium @error('number_of_teams') input-error @enderror" type="number"
                                name="number_of_teams" value="{{ old('number_of_teams', 16) }}" min="2" required />
                            @error('number_of_teams')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Maximum Players per Team <span class="text-error">*</span>
                            </label>
                            <input class="input-premium @error('max_players_per_team') input-error @enderror" type="number"
                                name="max_players_per_team" value="{{ old('max_players_per_team', 11) }}" min="1"
                                required />
                            @error('max_players_per_team')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Minimum Players per Team <span class="text-error">*</span>
                            </label>
                            <input class="input-premium @error('min_players_per_team') input-error @enderror" type="number"
                                name="min_players_per_team" value="{{ old('min_players_per_team', 7) }}" min="1" required />
                            @error('min_players_per_team')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <!-- ============================================ -->
            <!-- SECTION 04: TEAM REGISTRATION                 -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">04</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Team Registration</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">How teams enter your tournament.</p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <!-- Registration Method -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Registration Method <span class="text-error">*</span>
                        </label>
                        <select
                            class="input-premium appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E')] bg-no-repeat bg-[position:right_16px_center] @error('registration_method') input-error @enderror"
                            name="registration_method" required>
                            <option value="">Select Method</option>
                            <option value="free" {{ old('registration_method') == 'free' ? 'selected' : '' }}>Free
                                Registration</option>
                            <option value="paid" {{ old('registration_method') == 'paid' ? 'selected' : '' }}>Paid
                                Registration</option>
                            <option value="invitation" {{ old('registration_method') == 'invitation' ? 'selected' : '' }}>
                                Invitation Only</option>
                        </select>
                        @error('registration_method')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Registration Fee (conditional) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Registration Fee <span class="text-on-surface-variant/60 text-label-sm">(If paid)</span>
                            </label>
                            <div class="relative">
                                <input class="input-premium pl-8 @error('registration_fee') input-error @enderror"
                                    placeholder="0.00" type="number" name="registration_fee"
                                    value="{{ old('registration_fee', 0) }}" step="0.01" min="0" />
                                @error('registration_fee')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Maximum Number of Teams <span class="text-error">*</span>
                            </label>
                            <input class="input-premium @error('max_teams') input-error @enderror" type="number"
                                name="max_teams" value="{{ old('max_teams', 16) }}" min="2" required />
                            @error('max_teams')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Team Registration Deadline -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Team Registration Deadline <span class="text-error">*</span>
                        </label>
                        <input class="input-premium @error('team_registration_deadline') input-error @enderror" type="date"
                            name="team_registration_deadline" value="{{ old('team_registration_deadline') }}" required />
                        @error('team_registration_deadline')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Team Eligibility -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Team Eligibility Requirements <span
                                class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                        </label>
                        <textarea
                            class="input-premium min-h-[100px] resize-none @error('team_eligibility') input-error @enderror"
                            placeholder="Specify any requirements for team eligibility..."
                            name="team_eligibility">{{ old('team_eligibility') }}</textarea>
                        @error('team_eligibility')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Toggles -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-md bg-surface-container-lowest rounded-2xl p-lg border border-outline-variant/30">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-label-md text-label-md text-on-surface block">Team Manager Details</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">Require at
                                    registration</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="requires_manager_details" value="1" {{ old('requires_manager_details', true) ? 'checked' : '' }} />
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="font-label-md text-label-md text-on-surface block">Player Roster
                                    Required</span>
                                <span class="font-label-sm text-label-sm text-on-surface-variant">At registration</span>
                            </div>
                            <label class="toggle-switch">
                                <input type="checkbox" name="requires_player_roster" value="1" {{ old('requires_player_roster', true) ? 'checked' : '' }} />
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <!-- ============================================ -->
            <!-- SECTION 05: TOURNAMENT RULES                  -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">05</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Tournament Rules</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Define the rules of play.</p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <!-- Tournament Rules -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Tournament Rules <span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                        </label>
                        <textarea
                            class="input-premium min-h-[120px] resize-none @error('tournament_rules') input-error @enderror"
                            placeholder="General tournament rules, code of conduct, scheduling policies..."
                            name="tournament_rules">{{ old('tournament_rules') }}</textarea>
                        @error('tournament_rules')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Match Rules -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Match Rules <span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                        </label>
                        <textarea
                            class="input-premium min-h-[120px] resize-none @error('match_rules') input-error @enderror"
                            placeholder="Match duration, substitution rules, tie-breaking procedures..."
                            name="match_rules">{{ old('match_rules') }}</textarea>
                        @error('match_rules')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <div class="section-divider"></div>

            <!-- ============================================ -->
            <!-- SECTION 06: PRIZE & AWARDS                    -->
            <!-- ============================================ -->
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-xl lg:gap-3xl items-start">
                <div class="lg:col-span-4 sticky top-[120px]">
                    <span class="font-headline-lg text-headline-lg text-primary/20 block mb-xs">06</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Prize &amp; Awards</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant mt-xs">Reward your participants.</p>
                </div>
                <div class="lg:col-span-8 flex flex-col gap-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-lg">
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Winner Prize (₦)<span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                            </label>
                            <div class="relative">
                                <input class="input-premium pl-8 @error('winner_prize') input-error @enderror"
                                    placeholder="0.00" type="number" name="winner_prize" value="{{ old('winner_prize') }}"
                                    step="0.01" min="0" />
                                @error('winner_prize')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <p class="font-label-sm text-label-sm text-on-surface-variant mt-xs">or describe the prize</p>
                        </div>
                        <div>
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                Runner-Up Prize (₦)<span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                            </label>
                            <div class="relative">
                                <input class="input-premium pl-8 @error('runner_up_prize') input-error @enderror"
                                    placeholder="0.00" type="number" name="runner_up_prize"
                                    value="{{ old('runner_up_prize') }}" step="0.01" min="0" />
                                @error('runner_up_prize')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-label-md text-label-md text-on-surface mb-xs">
                                3rd Place Prize (₦)<span class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                            </label>
                            <div class="relative">
                                <input class="input-premium pl-8 @error('third_place_prize') input-error @enderror"
                                    placeholder="0.00" type="number" name="third_place_prize"
                                    value="{{ old('third_place_prize') }}" step="0.01" min="0" />
                                @error('third_place_prize')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Prize Description -->
                    <div>
                        <label class="block font-label-md text-label-md text-on-surface mb-xs">
                            Additional Prize Details <span
                                class="text-on-surface-variant/60 text-label-sm">(Optional)</span>
                        </label>
                        <textarea
                            class="input-premium min-h-[80px] resize-none @error('additional_prize_details') input-error @enderror"
                            placeholder="Trophies, medals, certificates, or other prizes..."
                            name="additional_prize_details">{{ old('additional_prize_details') }}</textarea>
                        @error('additional_prize_details')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>
        </form>
    </main>

    <!-- ============================================ -->
    <!-- BOTTOM ACTION BAR                            -->
    <!-- ============================================ -->
    <div class="fixed bottom-0 w-full glass-panel border-t z-40 py-md px-lg flex justify-end gap-md pb-safe"
        style="margin-bottom: 80px;">
        <button type="button"
            class="font-label-md text-label-md text-on-surface px-lg py-sm rounded-full border border-outline hover:bg-surface-container-low transition-colors active:scale-95">
            <a href="{{ url()->previous() }}" class="...">Back</a>
        </button>
        <button type="button"
            class="font-label-md text-label-md font-semibold bg-primary text-on-primary px-xl py-sm rounded-full hover:bg-primary/90 transition-all active:scale-95 shadow-md"
            onclick="publishTournament()">
            Create Tournament
        </button>
    </div>

    @push('scripts')
        <script>
            function previewCoverImage(input) {
                const preview = document.getElementById('coverPreview');
                const img = preview.querySelector('img');

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        img.src = e.target.result;
                        preview.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function publishTournament() {
                document.getElementById('tournamentStatus').value = 'published';
                document.getElementById('tournamentForm').submit();
            }

            // Auto-dismiss success messages after 5 seconds
            document.addEventListener('DOMContentLoaded', function () {
                const successMessage = document.querySelector('.bg-green-50');
                if (successMessage) {
                    setTimeout(function () {
                        successMessage.style.transition = 'opacity 0.5s';
                        successMessage.style.opacity = '0';
                        setTimeout(function () {
                            successMessage.remove();
                        }, 500);
                    }, 5000);
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const stateSelect = document.getElementById('stateSelect');
                const citySelect = document.getElementById('citySelect');
                const statesData = @json($states);

                stateSelect.addEventListener('change', function () {
                    const selectedState = this.value;
                    const lgas = statesData[selectedState] || [];

                    citySelect.innerHTML = '<option value="">Select City/LGA</option>';

                    lgas.forEach(function (lga) {
                        const option = document.createElement('option');
                        option.value = lga;
                        option.textContent = lga;
                        citySelect.appendChild(option);
                    });
                });
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .input-premium {
                width: 100%;
                background-color: #ffffff;
                border: 1px solid #bec9c9;
                border-radius: 1rem;
                padding: 12px 16px;
                font-family: 'Inter', sans-serif;
                font-size: 16px;
                color: #181c1c;
                transition: all 0.2s ease;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
            }

            .input-premium:focus {
                outline: none;
                ring: 2px solid #0d7377;
                border-color: transparent;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            }

            .input-premium:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            }

            .section-divider {
                border-top: 1px solid #e0e3e3;
                margin: 48px 0;
            }

            input,
            select,
            textarea,
            button,
            label,
            .cursor-pointer {
                touch-action: manipulation;
            }

            input[type="radio"]:checked+div {
                border-color: #0d7377;
            }

            @supports (-webkit-touch-callout: none) {

                input,
                select,
                textarea {
                    font-size: 16px !important;
                }
            }

            /* Select arrow custom styling */
            select.input-premium {
                background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%236e7979%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E");
                background-repeat: no-repeat;
                background-position: right 16px center;
                background-size: 20px;
                padding-right: 48px;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
            }

            select.input-premium::-ms-expand {
                display: none;
            }

            .input-error {
                border-color: #dc2626 !important;
            }

            .error-message {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
        </style>
    @endpush
@endsection