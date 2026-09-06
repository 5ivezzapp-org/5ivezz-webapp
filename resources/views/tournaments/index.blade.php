@extends('layouts.guest')

@section('title', '5IVEZZ - Tournaments')

@section('content')
<!-- Atmospheric Background -->
<div class="fixed inset-0 pointer-events-none z-0 ambient-glow-1"></div>
<div class="fixed inset-0 pointer-events-none z-0 ambient-glow-2"></div>

<!-- Main Canvas -->
<main class="relative z-10 px-md md:px-lg pb-[100px] max-w-7xl mx-auto flex flex-col gap-xl">
    <!-- Intro Section -->
    <section class="flex flex-col gap-xs mt-md">
        <span class="font-label-sm text-label-sm text-primary tracking-widest uppercase">5IVEZZ / COMPETITIONS</span>
        <h2 class="font-display-lg text-display-lg text-on-surface tracking-tight leading-tight">
            Find your next <br class="hidden md:block"/>tournament.
        </h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mt-xs">
            Grassroots football, organized. Discover local leagues, cups, and knockout series happening around you.
        </p>
    </section>

    <!-- Filters & Controls -->
    <section class="flex flex-col md:flex-row md:items-center justify-between gap-md sticky top-0 z-20 py-sm bg-background/80 backdrop-blur-md">
        <!-- Location Selector -->
        <button class="flex items-center gap-xs font-label-md text-label-md text-on-surface hover:text-primary transition-colors group">
            <span class="material-symbols-outlined text-[20px] text-primary group-hover:scale-110 transition-transform">location_on</span>
            Lagos · Nigeria
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant">keyboard_arrow_down</span>
        </button>
        
        <!-- Pill Filters & Create Button -->
        <div class="flex items-center gap-sm w-full md:w-auto">
            <div class="flex overflow-x-auto hide-scrollbar gap-sm pb-xs md:pb-0 -mx-md px-md md:mx-0 md:px-0 flex-1">
                <button class="whitespace-nowrap px-md py-xs rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-colors shadow-sm active:scale-95">All</button>
                <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-95">Registration Open</button>
                <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-95">Upcoming</button>
                <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-95 flex items-center gap-xs">
                    <span class="w-[8px] h-[8px] rounded-full bg-error"></span> Live
                </button>
                <button class="whitespace-nowrap px-md py-xs rounded-full bg-surface-container border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container-high transition-colors active:scale-95">Completed</button>
            </div>
            
            <!-- Create Tournament Button -->
            <a href="{{ route('tournaments.create') }}" 
               class="flex-shrink-0 flex items-center gap-xs px-md py-xs rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-primary-fixed-variant transition-all shadow-sm active:scale-95 hover:shadow-md">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span class="hidden sm:inline">Create</span>
            </a>
        </div>
    </section>

    <!-- Editorial Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-12 gap-md md:gap-lg auto-rows-[minmax(180px,_auto)]">
        <!-- 1. Featured (Cinematic) - Spans 8 cols on desktop -->
        <article class="md:col-span-8 row-span-2 rounded-xl overflow-hidden relative group cursor-pointer shadow-sm hover:shadow-lg transition-shadow duration-300 bg-surface-container">
            <div class="absolute inset-0 z-0 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-t from-[#002021]/90 via-[#002021]/40 to-transparent z-10"></div>
                <img alt="5ivezz Community Cup" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out" 
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5EIEHLgt_TBtgSPwyrivTz59HxWDCxnR_-12iGEjYqauUzlY9qDQp-NzngOBmtYFXJYRPMmhr6ZO1S0180plLOilc2LNp8m_FM-U7I6wJGNEvQ4MrIdUsvupb6TKhN4jAgrOg9KgOMoB6UobBiuxN0r_QsLFfNpffPGaSEz_G-lYkIPgTMwCMe-hTiJLVo2syEOC_Xd-iAH9eefg2SAdEyAoI9gwH4e24LvuSJSsrhm0GxWAq0jJ6OQ"/>
            </div>
            <div class="absolute inset-0 z-20 flex flex-col justify-between p-lg">
                <div class="flex justify-between items-start">
                    <div class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-secondary-container/90 backdrop-blur-md text-on-secondary-container font-label-sm text-label-sm shadow-sm">
                        <span class="w-[6px] h-[6px] rounded-full bg-primary animate-pulse"></span>
                        REGISTRATION OPEN
                    </div>
                    <button class="w-[40px] h-[40px] rounded-full bg-surface/20 backdrop-blur-md flex items-center justify-center text-on-primary hover:bg-surface/40 transition-colors">
                        <span class="material-symbols-outlined">bookmark_border</span>
                    </button>
                </div>
                <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                    <div class="flex items-center gap-sm text-on-primary/80 font-label-md text-label-md mb-xs">
                        <span class="flex items-center gap-base">
                            <span class="material-symbols-outlined text-[16px]">location_on</span> Lagos
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-base">
                            <span class="material-symbols-outlined text-[16px]">groups</span> 24 Teams
                        </span>
                        <span>•</span>
                        <span class="flex items-center gap-base">
                            <span class="material-symbols-outlined text-[16px]">sports_soccer</span> 36 Matches
                        </span>
                    </div>
                    <h3 class="font-headline-lg text-headline-lg text-on-primary mb-xs drop-shadow-md">5ivezz Community Cup</h3>
                    <div class="w-[32px] h-[32px] rounded-full bg-primary text-on-primary flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </div>
                </div>
            </div>
        </article>

        <!-- 2. Editorial Card - Spans 4 cols on desktop -->
        <article class="md:col-span-4 row-span-2 rounded-xl border border-outline-variant/30 bg-surface flex flex-col overflow-hidden group cursor-pointer hover:shadow-md transition-shadow duration-300 hover:-translate-y-1">
            <div class="h-[200px] w-full relative overflow-hidden bg-surface-container-high">
                <img alt="Lagos Grassroots Championship" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmonc6u2kG-e8G_esHYWDWVTjD8ZdAzZL7ljj5odut-1P_LzQWrYtRdq1QjB6r91QmDps04Sg0C6Nfoik867R9DuY8szg6l2VV-D91g-yNEHdta4b0wTRYf9VECqQr-aJJBDu0i6-lzP6SePURa7T-eflY44Wu6l8YNgIHlma8GV82s-Vppaa8WZWrJ3CFPdnVVLohRtKMlP249p4wNi_Ym9RTTWHgptPUq0xphyS2EgFg8LvzC8McKw"/>
                <div class="absolute top-sm right-sm px-xs py-base rounded-lg bg-surface/90 backdrop-blur-sm text-primary font-label-sm text-label-sm border border-primary/20">
                    REGISTRATION OPEN
                </div>
            </div>
            <div class="p-md flex-1 flex flex-col justify-between">
                <div>
                    <span class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-xs mb-xs">
                        <span class="material-symbols-outlined text-[16px]">map</span> Ikeja
                    </span>
                    <h3 class="font-headline-md text-headline-md text-on-surface leading-tight mb-sm group-hover:text-primary transition-colors">Lagos Grassroots Championship</h3>
                </div>
                <div class="flex items-center justify-between border-t border-outline-variant/20 pt-sm mt-sm">
                    <div class="flex gap-sm">
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Teams</span>
                            <span class="font-label-md text-label-md text-on-surface font-semibold">16</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Matches</span>
                            <span class="font-label-md text-label-md text-on-surface font-semibold">24</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-outline group-hover:text-primary transform group-hover:translate-x-1 transition-all">arrow_forward</span>
                </div>
            </div>
        </article>

        <!-- 3. Dark Mode Card - Spans 4 cols -->
        <article class="md:col-span-4 rounded-xl bg-inverse-surface text-inverse-on-surface p-md flex flex-col justify-between group cursor-pointer shadow-sm hover:shadow-lg transition-all duration-300 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary to-transparent z-0"></div>
            <div class="relative z-10 flex justify-between items-start mb-xl">
                <div class="inline-flex items-center gap-xs px-sm py-xs rounded-full bg-surface/10 text-on-primary font-label-sm text-label-sm border border-surface/20">
                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                    Starts Sept 14
                </div>
                <button class="text-on-primary/60 hover:text-on-primary transition-colors">
                    <span class="material-symbols-outlined">more_horiz</span>
                </button>
            </div>
            <div class="relative z-10 mt-auto">
                <h3 class="font-headline-md text-headline-md text-on-primary mb-sm leading-tight">Ikeja Community League</h3>
                <div class="flex gap-md font-label-md text-label-md text-on-primary/80">
                    <span class="flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">groups</span> 12 Teams
                    </span>
                    <span class="flex items-center gap-xs">
                        <span class="material-symbols-outlined text-[18px]">sports_soccer</span> 18 Matches
                    </span>
                </div>
            </div>
        </article>

        <!-- 4. Data Card - Spans 4 cols -->
        <article class="md:col-span-4 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-md flex flex-col justify-between group cursor-pointer hover:shadow-md transition-shadow duration-300">
            <div class="flex justify-between items-start mb-md">
                <div class="px-sm py-xs rounded-md bg-surface-container-high text-on-surface-variant font-label-sm text-label-sm flex items-center gap-xs">
                    <span class="w-[6px] h-[6px] rounded-full bg-outline"></span> Closed
                </div>
                <div class="w-[40px] h-[40px] rounded-full bg-tertiary-container/30 flex items-center justify-center text-tertiary">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
            </div>
            <div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-xs">Lekki Football Series</h3>
                <div class="flex items-end gap-sm mt-md">
                    <div class="flex flex-col">
                        <span class="font-display-lg text-display-lg text-primary leading-none">20</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider mt-base">Teams Registered</span>
                    </div>
                </div>
            </div>
            <div class="mt-md pt-sm border-t border-outline-variant/20 flex items-center text-primary font-label-md text-label-md group-hover:gap-sm transition-all">
                View Results <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </div>
        </article>

        <!-- 5. Minimal Card - Spans 4 cols -->
        <article class="md:col-span-4 rounded-xl border border-outline-variant/20 bg-surface-bright p-md flex flex-col justify-center group cursor-pointer hover:bg-surface-container hover:border-primary/30 transition-colors duration-300">
            <div class="flex items-center gap-sm mb-sm text-on-surface-variant font-label-sm text-label-sm">
                <span class="px-xs py-base rounded-sm bg-secondary-container/50 text-on-secondary-container border border-secondary-container">Upcoming</span>
                <span>•</span>
                <span class="flex items-center gap-base">
                    <span class="material-symbols-outlined text-[14px]">map</span> Yaba
                </span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-surface mb-xs group-hover:text-primary transition-colors">Mainland Community Cup</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">16 Teams format. Registration opens next week.</p>
        </article>
    </section>
</main>

@push('styles')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .fill-icon {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    
    /* Subtle atmospheric glows */
    .ambient-glow-1 {
        background: radial-gradient(circle at top left, rgba(13, 115, 119, 0.08) 0%, transparent 40%);
    }
    .ambient-glow-2 {
        background: radial-gradient(circle at bottom right, rgba(109, 248, 193, 0.05) 0%, transparent 40%);
    }
    
    /* Smooth scrolling for horizontal lists */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .py-sm {
    padding-top: 42px !important;
    padding-bottom: 12px;
}
</style>
@endpush
@endsection