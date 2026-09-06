@extends('layouts.guest')

@section('title', '5ivezz - Team Details')

@section('content')
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .pulse-dot::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            border-radius: 50%;
            background-color: #00595c;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
    </style>

    <!-- Main Canvas -->
    <main class="pt-[20px] pb-[100px] max-w-[1200px] mx-auto px-md md:px-lg space-y-xl">
        <!-- Hero: Verified Team Profile Surface -->
        <section
            class="bg-surface-container-lowest shadow-[0_4px_12px_rgba(0,0,0,0.03)] rounded-xl border border-black/5 p-lg md:p-xl flex flex-col md:flex-row gap-lg md:items-center relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10 translate-x-1/2 -translate-y-1/2">
            </div>

            <div class="flex-shrink-0 flex justify-center md:justify-start">
                <div class="relative">
                    <img class="w-32 h-32 md:w-40 md:h-40 rounded-full border border-outline-variant/20 bg-surface-container-low object-cover p-2 shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQ-w0KT7c4Hpb46fAjyBFYymIRcE_lfNzKuWsh6gsmje2-hh6cimUSNmQBvua11beM0Djc4ArRn72Fxi-Ur8Jz2IbdGEWnfjaRC4rGM6itataEPNMz_g9EbNhjiClCLR5L7MO66ni6l9cTO2nZK6KsI5pywI0wNi4qI0wAs1NgmRrFRpwQIM_5rwjHUjfGvZ2VB0JXcXN7s-mtdyGjTFSz90M_Mu5ErMJ6Y3iSMiPElBoYVRvsoBXFsA" />
                    <div
                        class="absolute bottom-2 right-2 bg-surface-container-lowest rounded-full p-1 shadow-sm border border-black/5">
                        <span class="material-symbols-outlined text-tertiary"
                            style="font-variation-settings: 'FILL' 1;">verified</span>
                    </div>
                </div>
            </div>

            <div class="flex-grow flex flex-col gap-sm text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-sm md:gap-md">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Lagos Metropolitans</h2>
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-secondary-container/20 text-on-secondary-container rounded-full font-label-sm text-label-sm border border-secondary-container/30">
                        <span class="w-2 h-2 rounded-full bg-secondary"></span>
                        Active Roster
                    </span>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-xl">
                    Established 2021. Competing in the Premier Amateur League and Regional Cups. A digital-first squad
                    managing operations seamlessly.
                </p>

                <div class="mt-md flex justify-center md:justify-start gap-xl">
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-primary tracking-tighter">24</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Wins</span>
                    </div>
                    <div class="w-px h-12 bg-outline-variant/30 self-center"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-on-surface-variant tracking-tighter">7</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Draws</span>
                    </div>
                    <div class="w-px h-12 bg-outline-variant/30 self-center"></div>
                    <div class="flex flex-col items-center md:items-start">
                        <span class="font-display-lg text-display-lg text-error tracking-tighter">5</span>
                        <span class="font-label-sm text-label-sm text-outline uppercase tracking-widest">Losses</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Actions & Admin Grid -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-md">
            <button
                class="md:col-span-2 bg-primary text-on-primary rounded-xl px-lg py-4 flex items-center justify-between shadow-[0_4px_12px_rgba(0,0,0,0.1)] hover:bg-primary-container transition-colors active:scale-[0.98] duration-200 group">
                <span class="font-headline-sm text-headline-sm">Register for Tournament</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>

            <div
                class="bg-surface-container-low border border-outline-variant/20 rounded-xl p-md flex flex-col justify-center">
                <span class="font-label-sm text-label-sm text-on-surface-variant mb-xs uppercase tracking-wider">Team Admin
                    Access</span>
                <div
                    class="flex items-center justify-between bg-surface-container-lowest rounded-lg border border-outline-variant/30 p-sm">
                    <span class="font-label-md text-label-md text-on-surface font-mono">5VZ-LAGOS-92</span>
                    <button onclick="copyInviteCode()"
                        class="text-primary hover:bg-primary/10 p-1 rounded transition-colors" title="Copy Invite Code">
                        <span class="material-symbols-outlined text-[20px]">content_copy</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Currently Competing Card -->
        <section class="space-y-md">
            <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">swords</span>
                Currently Competing
            </h3>
            <div
                class="bg-surface-container-lowest shadow-sm rounded-xl border border-black/5 p-lg flex flex-col md:flex-row items-center justify-between gap-lg relative overflow-hidden group hover:shadow-md transition-shadow">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                <div class="flex flex-col text-center md:text-left w-full md:w-auto">
                    <span class="font-label-sm text-label-sm text-primary mb-1 uppercase tracking-wider">Upcoming Match •
                        Quarter Finals</span>
                    <h4 class="font-headline-sm text-headline-sm text-on-surface">Lagos City Cup 2024</h4>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-1 mt-2">
                        <span class="material-symbols-outlined text-[16px]">calendar_today</span> Oct 24 • 15:00
                    </p>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant flex items-center justify-center md:justify-start gap-1 mt-1">
                        <span class="material-symbols-outlined text-[16px]">location_on</span> National Stadium, Surulere
                    </p>
                </div>
                <div
                    class="flex items-center gap-md w-full md:w-auto justify-center md:justify-end border-t md:border-t-0 md:border-l border-outline-variant/20 pt-md md:pt-0 md:pl-lg mt-sm md:mt-0">
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-12 h-12 rounded-full bg-surface-container border border-outline-variant/30 flex items-center justify-center">
                            <span class="font-label-md text-label-md text-on-surface-variant font-bold">LM</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Lagos Metro</span>
                    </div>
                    <span class="font-body-md text-body-md text-outline font-bold">VS</span>
                    <div class="flex flex-col items-center gap-2">
                        <div
                            class="w-12 h-12 rounded-full bg-surface-container-high border border-outline-variant/30 flex items-center justify-center">
                            <span class="font-label-md text-label-md text-on-surface-variant font-bold">IE</span>
                        </div>
                        <span class="font-label-sm text-label-sm text-on-surface-variant">Island Eagles</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- The Squad (Horizontal Scroll) -->
        <section class="space-y-md">
            <div class="flex items-center justify-between">
                <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                    <span class="material-symbols-outlined text-primary">groups</span>
                    The Squad
                </h3>
                <button class="font-label-md text-label-md text-primary hover:underline">View All</button>
            </div>
            <div class="flex overflow-x-auto gap-md pb-md no-scrollbar snap-x snap-mandatory px-1">
                <!-- Player Cards -->
                <div
                    class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center bg-surface-container-lowest p-md rounded-xl border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:-translate-y-1 transition-transform">
                    <img class="w-16 h-16 rounded-full object-cover border-2 border-surface bg-surface-container-high mb-sm shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBwXTG2pchmkRwIqEPv53haEwCLSCFsMvuOTxy3O3RosaUG7wAV8F5ONFCFosdC2VV31xXJwB67jPP1z_4KO7eG5FBR1TOsHy33dW4jk9Yj5HBTaQkmmlr8DvR0M4gqlgynNpHNGBC9In7VCUBpHzHSSO1AEu1LcyClwYbieIP1Dmgn7mwe_jSCGS6jE_2ANCn-Ont2oCeOkkwAvOcoPbKnB69HaprFomjt7bzBWduhR9hC4ENL7RzhWg" />
                    <span class="font-label-md text-label-md text-on-surface text-center line-clamp-1">David O.</span>
                    <span
                        class="font-label-sm text-label-sm text-on-surface-variant mt-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] uppercase">Forward</span>
                </div>

                <div
                    class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center bg-surface-container-lowest p-md rounded-xl border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:-translate-y-1 transition-transform">
                    <img class="w-16 h-16 rounded-full object-cover border-2 border-surface bg-surface-container-high mb-sm shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEtqGKfWws1XW5mKBQExfo_az_O_rdatYOUBciEavI4FyNHqzLx-T1wasyJ7mVeOreNd1GiD4NSY3khMEdtqI4ylQ6w0MdGzFCm8eCYqquNHeCprLUgPYEa-YiPGYZCX8lPO_6a5gntniGzy2yXBD8EI6QoJn3jwpi9R8xQq-akLE2ckmtkG5jEpfMRE36vCVn8WXU5wxV2PF2KUv5tynAZf5PCRNv-LxnPi79XR9kYrJRkL_TWh9OBg" />
                    <span class="font-label-md text-label-md text-on-surface text-center line-clamp-1">Samuel K.</span>
                    <span
                        class="font-label-sm text-label-sm text-on-surface-variant mt-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] uppercase">Midfielder</span>
                </div>

                <div
                    class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center bg-surface-container-lowest p-md rounded-xl border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:-translate-y-1 transition-transform">
                    <div
                        class="w-16 h-16 rounded-full border-2 border-surface bg-surface-container-high mb-sm shadow-sm flex items-center justify-center text-outline">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <span class="font-label-md text-label-md text-on-surface text-center line-clamp-1">Idris A.</span>
                    <span
                        class="font-label-sm text-label-sm text-on-surface-variant mt-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] uppercase">Defender</span>
                </div>

                <div
                    class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center bg-surface-container-lowest p-md rounded-xl border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:-translate-y-1 transition-transform">
                    <img class="w-16 h-16 rounded-full object-cover border-2 border-surface bg-surface-container-high mb-sm shadow-sm"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3pSFUx-MuXkupQITwY1JNAxH4DxQv8nmdWuDRfbb2BsYIpRWoBFkHJFHCf4_8e4QYZMO1J9qAQXAnxj7C5m6XjOld_syBz7rJizuZ8PvDDXyj8ojZrDeJQMzkaCReHeZcebppt6L1fs6pclMC5x6qGjNsF160pR5cxj2iPiUp2wIV5YPtR6UI3ndlX7nJ62BXsAg6TER4C6C1XEK_TfPMtUHAVWmd-92bMnEi3Dw3E1vMXp0oEM_R-w" />
                    <span class="font-label-md text-label-md text-on-surface text-center line-clamp-1">Chike B.</span>
                    <span
                        class="font-label-sm text-label-sm text-on-surface-variant mt-1 bg-surface-container-low px-2 py-0.5 rounded text-[10px] uppercase">Goalkeeper</span>
                </div>

                <!-- Add Player Action -->
                <button
                    class="flex-shrink-0 w-[140px] snap-start flex flex-col items-center justify-center bg-surface-container-low/50 p-md rounded-xl border border-dashed border-outline-variant/50 hover:bg-surface-container-low transition-colors group">
                    <div
                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform mb-sm">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <span class="font-label-md text-label-md text-primary">Invite Player</span>
                </button>
            </div>
        </section>

        <!-- Tournament History (Timeline) -->
        <section class="space-y-md">
            <h3 class="font-headline-md text-headline-md text-on-surface flex items-center gap-sm">
                <span class="material-symbols-outlined text-primary">history</span>
                Tournament History
            </h3>
            <div class="relative pl-6 ml-2 space-y-lg border-l-2 border-surface-container-high pb-md">
                <!-- Timeline Item 1 -->
                <div class="relative">
                    <div
                        class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-primary border-4 border-surface shadow-sm pulse-dot">
                    </div>
                    <div
                        class="bg-surface-container-lowest rounded-xl p-md border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:shadow-md transition-shadow cursor-default">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-label-md text-label-md text-on-surface font-bold">Mainland Invitational</h4>
                            <span class="font-label-sm text-label-sm text-outline">Aug 2024</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-3">Reached Semi-Finals.
                            Eliminated by penalties.</p>
                        <div class="flex items-center gap-sm">
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container-high text-on-surface-variant rounded font-label-sm text-[10px] uppercase tracking-wide">
                                <span class="material-symbols-outlined text-[14px]">sports_soccer</span> 6 Matches
                            </span>
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-surface-container-high text-on-surface-variant rounded font-label-sm text-[10px] uppercase tracking-wide">
                                <span class="material-symbols-outlined text-[14px]">star</span> 3 Clean Sheets
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="relative">
                    <div
                        class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface shadow-sm">
                    </div>
                    <div
                        class="bg-surface-container-lowest rounded-xl p-md border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:shadow-md transition-shadow cursor-default">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-label-md text-label-md text-on-surface font-bold">5ivezz Summer League</h4>
                            <span class="font-label-sm text-label-sm text-outline">Jun 2024</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-3">Champions of the inaugural
                            summer league division.</p>
                        <div class="flex items-center gap-sm">
                            <span
                                class="inline-flex items-center gap-1 px-2 py-1 bg-secondary-container/20 text-on-secondary-container rounded font-label-sm text-[10px] uppercase tracking-wide border border-secondary-container/30">
                                <span class="material-symbols-outlined text-[14px]">emoji_events</span> Winners
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="relative">
                    <div
                        class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface shadow-sm">
                    </div>
                    <div
                        class="bg-surface-container-lowest rounded-xl p-md border border-black/5 shadow-[0_2px_8px_rgba(0,0,0,0.02)] hover:shadow-md transition-shadow cursor-default">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-label-md text-label-md text-on-surface font-bold">Community Shield Cup</h4>
                            <span class="font-label-sm text-label-sm text-outline">Mar 2024</span>
                        </div>
                        <p class="font-body-md text-body-md text-on-surface-variant text-sm">Group stage exit. 1 Win, 2
                            Losses.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            function copyInviteCode() {
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

            // Simple script to handle scroll events for TopAppBar styling
            window.addEventListener('scroll', () => {
                const header = document.querySelector('header');
                if (header) {
                    if (window.scrollY > 10) {
                        header.classList.add('shadow-md');
                        header.classList.remove('shadow-sm');
                    } else {
                        header.classList.add('shadow-sm');
                        header.classList.remove('shadow-md');
                    }
                }
            });
        </script>
    @endpush
@endsection