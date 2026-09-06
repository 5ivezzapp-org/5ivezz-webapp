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
    </style>

    <!-- Main Workspace -->
    <main class="max-w-[800px] mx-auto px-md md:px-lg pt-4 pb-[140px]">
        <!-- Header -->
        <header class="mb-2xl">
            <h1 class="font-display-lg text-display-lg text-on-surface mb-sm">Create your team.</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                Build your squad, enter competitions and create your team's football record.
            </p>
        </header>

        <form class="space-y-2xl relative" method="POST" action="{{ route('teams.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Section 01: Team Identity -->
            <section class="group">
                <div class="flex items-center gap-sm mb-lg">
                    <span class="font-headline-sm text-headline-sm text-primary">01</span>
                    <h2 class="font-headline-sm text-headline-sm text-on-surface">Team Identity</h2>
                </div>
                <div class="space-y-lg">
                    <!-- Premium Image Uploader -->
                    <div
                        class="w-full h-[240px] bg-surface-container border-2 border-dashed border-outline-variant rounded-xl flex flex-col items-center justify-center cursor-pointer hover:bg-surface-container-high hover:border-primary transition-colors group relative">
                        <div
                            class="w-16 h-16 rounded-full bg-primary-container/20 flex items-center justify-center mb-sm group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary text-[32px]">add_photo_alternate</span>
                        </div>
                        <p class="font-label-md text-label-md text-on-surface font-medium">Upload Team Logo</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant mt-1">Recommended: 1024x1024px PNG</p>
                        <input type="file" name="logo" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        @error('logo')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Inputs -->
                    <div class="space-y-md">
                        <div class="relative">
                            <label class="block font-label-md text-label-md text-on-surface mb-xs" for="name">Team
                                Name</label>
                            <input
                                class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-primary px-4 py-3 rounded-t-lg font-body-md text-on-surface placeholder:text-outline transition-colors focus:ring-0"
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
                                class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-primary px-4 py-3 rounded-t-lg font-body-md text-on-surface placeholder:text-outline transition-colors focus:ring-0 resize-none"
                                id="description" name="description" placeholder="Tell us about your squad..."
                                rows="3">{{ old('description') }}</textarea>
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
                <div class="space-y-sm">
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-4 text-on-surface-variant">location_on</span>
                        <input
                            class="w-full bg-surface-container-low border border-outline-variant/50 focus:border-primary pl-12 pr-4 py-3 rounded-lg font-body-md text-on-surface placeholder:text-outline transition-colors focus:ring-0 shadow-sm"
                            id="location" name="location" placeholder="Search city or stadium..." type="text"
                            value="{{ old('location') }}" required />
                    </div>
                    @error('location')
                        <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                    @enderror

                    <!-- Map Visual -->
                    <div
                        class="w-full h-48 rounded-xl overflow-hidden relative shadow-sm border border-outline-variant/20 bg-surface-container">
                        <img class="w-full h-full object-cover opacity-80 mix-blend-multiply"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBfFgfhhuZc4wWHkBJOjRZdH-e9S6QuGLFN8tuizo6rRQL5qVZ7ywyHU06LWukGAzBAewOyjvDoRRWCRZcCoi1cr0Jo8e2itW5hXTPONvO2WyoVxHQG49U1H_HJgt-H2pbKbLIiQhU5yF10q2btgPQ909vXu4OdRtj5oNayq47D3Q_kdcLRXOSeT6HBcWjwM2BZpaTLo2Pz65pMv0nDHZl3dEqWNe9gWmEamzkx5LVAtOG7vw9YG9i-yA" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-surface-container/80 to-transparent flex items-end p-md">
                            <div
                                class="bg-surface/90 backdrop-blur-sm px-sm py-xs rounded-md shadow-sm flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-primary"></div>
                                <span class="font-label-sm text-label-sm text-on-surface">Location pending</span>
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
                        <img class="w-full h-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAd_aMTpX_omModoQs9UmcWnjGtiNduF6GkM2U14i4vTBGsnF-xo6JFYLJsIC6abpVhzu-vy8ZKDU72zlpg9YR3UZcb4Qqn4xigq2UvldKuJNNeqQNbUSyIDZVUOfbIrHCq7uPfr-U1llz-79YsQB2Djy8Pme1rSv77e1yxiWsHXgg2KMbINWxO-3dyKJsv1NFWquQeRGWuKUlAzl5GQbBbXoFPQAYPV1aZkanAYWsxJ6lzpXSguClzdw" />
                    </div>
                    <div class="flex-1">
                        <h3 class="font-label-md text-label-md text-on-surface">{{ Auth::user()->name ?? 'Alex Mercer' }}
                        </h3>
                        <p class="font-body-md text-sm text-on-surface-variant">{{ Auth::user()->email ??
                            'alex.mercer@example.com' }}</p>
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
                        class="font-label-sm text-label-sm text-on-surface-variant bg-surface-container px-sm py-1 rounded-full">0
                        Players</span>
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
                            class="font-headline-md text-headline-md font-mono text-primary tracking-widest pl-2">5VZ-7K92</span>
                        <button type="button" onclick="copyCode()"
                            class="p-2 rounded-md hover:bg-surface-variant transition-colors text-on-surface flex items-center justify-center group">
                            <span
                                class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">content_copy</span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Sticky Action Bar -->
            <div
                class="fixed bottom-0 left-0 w-full z-40 bg-surface/90 backdrop-blur-xl border-t border-outline-variant/20 pb-[100px] md:pb-lg pt-md px-md md:px-lg shadow-[0_-4px_24px_rgba(0,0,0,0.05)]">
                <div class="max-w-[800px] mx-auto flex justify-between items-center">
                    <span class="font-body-md text-on-surface-variant hidden sm:block">Ready to hit the pitch?</span>
                    <button type="submit"
                        class="bg-primary text-on-primary font-label-md text-label-md px-xl py-sm rounded-lg hover:bg-primary-container active:scale-95 transition-all shadow-md flex items-center gap-2 w-full sm:w-auto justify-center">
                        Create Team
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
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
        </script>
    @endpush
@endsection