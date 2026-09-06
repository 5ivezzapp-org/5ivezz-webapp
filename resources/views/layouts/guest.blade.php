<!DOCTYPE html>
<html class="light scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <title>@yield('title', config('app.name', '5ivezz'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-tertiary-fixed-variant": "#003ea8",
                        "on-secondary-fixed": "#002115",
                        "secondary-fixed": "#70fbc4",
                        "primary-fixed": "#9df0f4",
                        "primary": "#00595c",
                        "tertiary-fixed-dim": "#b4c5ff",
                        "surface-dim": "#d7dbda",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed-variant": "#005139",
                        "on-primary-fixed": "#002021",
                        "primary-fixed-dim": "#81d4d8",
                        "on-secondary-container": "#007150",
                        "outline": "#6e7979",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#1a5de5",
                        "secondary": "#006c4d",
                        "on-tertiary-container": "#e2e6ff",
                        "inverse-primary": "#81d4d8",
                        "surface-variant": "#e0e3e3",
                        "surface-bright": "#f7fafa",
                        "outline-variant": "#bec9c9",
                        "surface-tint": "#00696d",
                        "inverse-on-surface": "#eef1f1",
                        "on-background": "#181c1c",
                        "background": "#f7fafa",
                        "tertiary": "#0046bb",
                        "on-error": "#ffffff",
                        "on-primary-container": "#a2f5f9",
                        "surface-container-low": "#f1f4f4",
                        "secondary-container": "#6df8c1",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "surface-container-high": "#e5e9e8",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#3e4949",
                        "on-primary-fixed-variant": "#004f52",
                        "surface-container": "#ebeeee",
                        "on-surface": "#181c1c",
                        "secondary-fixed-dim": "#50dea9",
                        "surface": "#f7fafa",
                        "primary-container": "#0d7377",
                        "surface-container-highest": "#e0e3e3",
                        "tertiary-fixed": "#dbe1ff",
                        "surface-container-lowest": "#ffffff",
                        "inverse-surface": "#2d3131",
                        "error-container": "#ffdad6",
                        "on-tertiary-fixed": "#00174b"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "lg": "24px",
                        "md": "16px",
                        "xl": "32px",
                        "sm": "12px",
                        "3xl": "64px",
                        "base": "4px",
                        "2xl": "48px",
                        "xs": "8px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-sm": ["Inter"],
                        "label-sm": ["Inter"],
                        "headline-lg": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["16px", { "lineHeight": "24px", "letterSpacing": "0", "fontWeight": "400" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "letterSpacing": "0", "fontWeight": "400" }],
                        "display-lg": ["48px", { "lineHeight": "52px", "letterSpacing": "-0.04em", "fontWeight": "700" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500" }],
                        "headline-sm": ["20px", { "lineHeight": "28px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "600" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700" }]
                    }
                },
            },
        }
    </script>

    <style>
        body {
            -webkit-tap-highlight-color: transparent;
        }

        .hide-scroll::-webkit-scrollbar {
            display: none;
        }

        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Navbar glassmorphism enhancement */
        .glass-nav {
            background: rgba(247, 250, 250, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-nav {
            background: rgba(30, 30, 30, 0.7);
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* Bottom nav glass enhancement */
        .glass-bottom-nav {
            background: rgba(247, 250, 250, 0.8);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-bottom-nav {
            background: rgba(30, 30, 30, 0.8);
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* Search modal animation */
        .search-modal-enter {
            opacity: 0;
            transform: scale(0.95);
        }

        .search-modal-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: all 0.3s ease;
        }

        .search-modal-exit {
            opacity: 1;
            transform: scale(1);
        }

        .search-modal-exit-active {
            opacity: 0;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
    </style>

    @stack('styles')
</head>

<body
    class="bg-background text-on-background font-body-md antialiased pb-3xl selection:bg-primary selection:text-on-primary">

    <!-- ============================================ -->
    <!-- TOP NAVBAR WITH GLASSMORPHISM -->
    <!-- ============================================ -->
    <nav class="fixed top-0 left-0 right-0 z-50 px-4 md:px-8 py-3 pointer-events-none">
        <div class="max-w-7xl mx-auto pointer-events-auto">
            <div
                class="glass-nav rounded-2xl shadow-2xl shadow-black/5 px-4 md:px-6 py-2 flex items-center justify-between transition-all duration-300 hover:shadow-black/10">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    {{-- <div
                        class="rounded-xl  flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                        --}}
                        <img src="{{ asset('images/5ivezz official Logo.png') }}" alt="5ivezz"
                            class="w-20 h-15 object-contain" />
                        {{--
                    </div> --}}
                </a>

                <!-- Right Side: Search + Actions -->
                <div class="flex items-center gap-2 md:gap-3">
                    <!-- Search Button -->
                    <button onclick="openSearch()" class="relative group/search">
                        <div
                            class="absolute inset-0 bg-primary/10 rounded-full blur-md opacity-0 group-hover/search:opacity-100 transition-opacity duration-300">
                        </div>
                        <div
                            class="relative w-10 h-10 rounded-full bg-white/5 dark:bg-white/5 border border-white/10 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 flex items-center justify-center cursor-pointer group-hover/search:scale-105">
                            <span
                                class="material-symbols-outlined text-on-surface-variant/80 text-2xl group-hover/search:text-primary transition-colors duration-300">
                                search
                            </span>
                        </div>
                    </button>

                    <!-- Notification Bell -->
                    <button
                        class="relative hidden md:flex w-10 h-10 rounded-full bg-white/5 dark:bg-white/5 border border-white/10 hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 items-center justify-center group">
                        <span
                            class="material-symbols-outlined text-on-surface-variant/80 text-2xl group-hover:text-primary transition-colors duration-300">
                            notifications
                        </span>
                        <span
                            class="absolute -top-1 -right-1 w-3 h-3 bg-error rounded-full border-2 border-surface animate-pulse"></span>
                    </button>

                    <!-- User Avatar / Login -->
                    @auth
                        <button
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primary-container border-2 border-white/20 shadow-lg hover:shadow-primary/20 transition-all duration-300 hover:scale-105 flex items-center justify-center text-on-primary font-bold text-sm overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}"
                                    class="w-full h-full object-cover" />
                            @else
                                {{ substr(Auth::user()->name, 0, 2) }}
                            @endif
                        </button>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}"
                                class="hidden sm:block text-sm font-medium text-on-surface-variant hover:text-primary transition-colors duration-300 px-3 py-1.5 rounded-full hover:bg-primary/5">
                                Log in
                            </a>
                            <a href="{{ route('player.register') }}"
                                class="text-sm font-medium bg-primary text-on-primary px-4 py-1.5 rounded-full hover:bg-primary/90 transition-all duration-300 hover:scale-105 shadow-lg shadow-primary/20">
                                Sign up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================================ -->
    <!-- MAIN CONTENT -->
    <!-- ============================================ -->
    {{-- <main class="pt-16 md:pt-20 pb-3xl max-w-7xl mx-auto px-4 md:px-8"> --}}
        <main class="pt-16"></main>
        @yield('content')
    </main>

    <!-- ============================================ -->
    <!-- BOTTOM NAVIGATION WITH GLASSMORPHISM -->
    <!-- ============================================ -->
    <nav class="fixed bottom-0 w-full z-50 flex justify-center pb-4 md:pb-6 px-4 pointer-events-none">
        <div
            class="fixed bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 w-[calc(100%-32px)] max-w-[480px] rounded-2xl glass-bottom-nav shadow-2xl flex items-center justify-around px-1.5 md:px-2 py-1.5 pointer-events-auto transition-all duration-300">

            @guest
                <!-- Home -->
                <a href="{{ route('home') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('home') ? '1' : '0' }};">home</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Home</span>
                </a>

                <a href="{{ route('explore.index') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('explore.index') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('explore.index') ? '1' : '0' }};">explore</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Explore</span>
                </a>

                <!-- Tournaments -->
                <a href="{{ route('tournaments.index') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('tournaments.*') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('tournaments.*') ? '1' : '0' }};">emoji_events</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Tournaments</span>
                </a>

                <!-- Teams -->
                <a href="{{ route('teams.index') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('teams.*') || request()->routeIs('public.team.show') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('teams.*') || request()->routeIs('public.team.show') ? '1' : '0' }};">groups</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Teams</span>
                </a>

                <a href="{{ route('wallet') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('wallet') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('wallet') ? '1' : '0' }};">wallet</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Wallet</span>
                </a>

            @endguest

            <!-- Players (only for logged-in users) -->
            @auth
                <!-- Home/Dashboard -->
                <a href="{{ route('player.dashboard') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('player.dashboard') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('player.dashboard') ? '1' : '0' }};">home</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Home</span>
                </a>

                <a href="{{ route('explore.index') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('explore.index') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('explore.index') ? '1' : '0' }};">explore</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Explore</span>
                </a>

                <!-- Teams -->
                <a href="{{ route('teams.index') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('teams.*') || request()->routeIs('public.team.show') || request()->routeIs('player.teams.*') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('teams.*') || request()->routeIs('public.team.show') || request()->routeIs('player.teams.*') ? '1' : '0' }};">groups</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Teams</span>
                </a>

                <a href="{{ route('wallet') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('wallet') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('wallet') ? '1' : '0' }};">wallet</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Wallet</span>
                </a>

                <!-- Profile -->
                <a href="{{ route('player.profile') }}"
                    class="flex flex-col items-center justify-center min-w-[48px] h-12 flex-1 group transition-all duration-300 {{ request()->routeIs('player.profile') || request()->routeIs('player.profile.*') ? 'text-primary dark:text-primary-fixed-dim scale-110' : 'text-on-surface-variant/60 dark:text-on-surface-variant/40 hover:text-primary dark:hover:text-primary-fixed-dim' }} active:scale-95">
                    <span
                        class="material-symbols-outlined text-xl md:text-2xl group-hover:scale-110 transition-transform duration-200"
                        style="font-variation-settings: 'FILL' {{ request()->routeIs('player.profile') || request()->routeIs('player.profile.*') ? '1' : '0' }};">account_circle</span>
                    <span class="font-label-sm text-[10px] md:text-label-sm mt-0.5">Profile</span>
                </a>
            @endauth

        </div>
    </nav>

    <!-- ============================================ -->
    <!-- SEARCH MODAL -->
    <!-- ============================================ -->
    <div id="searchModal"
        class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-md flex items-start justify-center pt-20 px-4 opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="w-full max-w-2xl bg-surface rounded-2xl border border-white/20 shadow-2xl p-4 transform scale-95 transition-all duration-300">
            <div class="flex items-center gap-3 border-b border-outline-variant/30 pb-3">
                <span class="material-symbols-outlined text-on-surface-variant">search</span>
                <input type="text" placeholder="Search tournaments, teams, players..."
                    class="w-full bg-transparent border-none outline-none text-on-surface placeholder:text-on-surface-variant/60 font-body-md"
                    id="searchInput" autofocus />
                <button onclick="closeSearch()"
                    class="p-1 hover:bg-surface-container-high rounded-full transition-colors">
                    <span class="material-symbols-outlined text-on-surface-variant">close</span>
                </button>
            </div>
            <div class="mt-4 space-y-2">
                <p class="font-label-sm text-label-sm text-on-surface-variant/60 px-2">Recent searches</p>
                <div class="space-y-1">
                    <div
                        class="flex items-center gap-3 px-2 py-2 hover:bg-surface-container-high rounded-lg transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-on-surface-variant/60">history</span>
                        <span class="font-body-md text-sm text-on-surface">Lagos Community Cup</span>
                    </div>
                    <div
                        class="flex items-center gap-3 px-2 py-2 hover:bg-surface-container-high rounded-lg transition-colors cursor-pointer">
                        <span class="material-symbols-outlined text-sm text-on-surface-variant/60">history</span>
                        <span class="font-body-md text-sm text-on-surface">Genesis FC</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search Modal Functions
        function openSearch() {
            const modal = document.getElementById('searchModal');
            const modalContent = modal.querySelector('div');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modalContent.classList.remove('scale-95');
            setTimeout(() => {
                document.getElementById('searchInput').focus();
            }, 100);
        }

        function closeSearch() {
            const modal = document.getElementById('searchModal');
            const modalContent = modal.querySelector('div');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modalContent.classList.add('scale-95');
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeSearch();
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                openSearch();
            }
        });

        // Close on backdrop click
        document.getElementById('searchModal').addEventListener('click', function (e) {
            if (e.target === this) closeSearch();
        });
    </script>

    @stack('scripts')
</body>

</html>