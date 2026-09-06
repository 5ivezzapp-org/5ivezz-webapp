@extends('layouts.guest')

@section('title', '5ivezz - Tournament Details')

@section('content')
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .filled-icon {
        font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
</style>

<!-- Main Content -->
<main class="md:pt-4">
    <!-- Hero Section -->
    <section class="relative w-full h-[60vh] min-h-[500px] max-h-[700px] overflow-hidden">
        <div class="absolute inset-0 bg-surface-variant">
            <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBYUqbq4Li8wdQzraAGSfd7IjmlIzX5u0bLNtMchI73OMuk_PzUpj-C9axraDqB7bHFlo0Chy0qB13wua5AfgdDbV5s_wALD-b8cvUPueqBD1esUfvP8SAYb1WzQo-kxEvHrUONPZ3PM4MxF4ziwCzsTZCtU8hG-EBecSEHu1HzySE4kznJyszWC0qFQQ8dqRcwGxaZHgYpfU1iupWFXFuabdLs3D0KlmLyLtOa-3kBRrdwklPhamOq8g')"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/10"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-primary/30 to-transparent"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="absolute bottom-0 left-0 w-full p-md md:p-xl lg:px-2xl pb-xl z-20 max-w-[1200px] mx-auto left-1/2 -translate-x-1/2">
            <div class="flex items-center gap-xs mb-sm">
                <span class="px-sm py-xs bg-secondary-container/20 border border-secondary-container/30 text-secondary-container rounded-full font-label-sm text-label-sm flex items-center gap-base backdrop-blur-md shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-secondary-container animate-pulse"></span>
                    REGISTRATION OPEN
                </span>
                <span class="px-sm py-xs bg-white/10 border border-white/20 text-white rounded-full font-label-sm text-label-sm backdrop-blur-md flex items-center gap-base">
                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                    LAGOS, NIGERIA
                </span>
            </div>
            <h1 class="font-display-lg text-[40px] md:text-display-lg text-white mb-lg max-w-3xl drop-shadow-lg tracking-tight leading-tight">Lagos Community Cup — 2026 EDITION</h1>
            
            <!-- Floating Metadata -->
            <div class="flex flex-wrap gap-sm md:gap-md mb-xl">
                <div class="flex items-center gap-sm bg-black/30 backdrop-blur-xl border border-white/10 px-md py-sm rounded-xl text-white shadow-sm">
                    <span class="material-symbols-outlined text-outline-variant">groups</span>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline-variant uppercase">Teams</span>
                        <span class="font-label-md text-label-md font-bold">24 Teams</span>
                    </div>
                </div>
                <div class="flex items-center gap-sm bg-black/30 backdrop-blur-xl border border-white/10 px-md py-sm rounded-xl text-white shadow-sm">
                    <span class="material-symbols-outlined text-outline-variant">sports_soccer</span>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline-variant uppercase">Matches</span>
                        <span class="font-label-md text-label-md font-bold">36 Matches</span>
                    </div>
                </div>
                <div class="flex items-center gap-sm bg-black/30 backdrop-blur-xl border border-white/10 px-md py-sm rounded-xl text-white shadow-sm">
                    <span class="material-symbols-outlined text-outline-variant">straighten</span>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline-variant uppercase">Format</span>
                        <span class="font-label-md text-label-md font-bold">11-a-side</span>
                    </div>
                </div>
                <div class="flex items-center gap-sm bg-black/30 backdrop-blur-xl border border-white/10 px-md py-sm rounded-xl text-white shadow-sm">
                    <span class="material-symbols-outlined text-outline-variant">person</span>
                    <div class="flex flex-col">
                        <span class="font-label-sm text-label-sm text-outline-variant uppercase">Age Category</span>
                        <span class="font-label-md text-label-md font-bold">U-21</span>
                    </div>
                </div>
            </div>
            <button class="bg-primary hover:bg-primary/90 text-white font-label-md text-label-md px-xl py-md rounded-xl shadow-lg active:scale-95 transition-all flex items-center justify-center gap-sm w-full md:w-auto font-bold border border-primary-fixed-dim/20">
                Register Your Team 
                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
            </button>
        </div>
    </section>

    <!-- Information Strip -->
    <div class="bg-surface border-b border-outline-variant/20 sticky top-0 md:top-16 z-30 shadow-sm">
        <div class="max-w-[1200px] mx-auto px-md md:px-lg overflow-x-auto hide-scrollbar">
            <div class="flex min-w-max py-sm md:py-md">
                <div class="flex-1 min-w-[200px] px-md border-r border-outline-variant/20 last:border-r-0">
                    <div class="text-outline font-label-sm text-label-sm mb-base uppercase">Registration</div>
                    <div class="font-label-md text-label-md text-on-surface">Closes Oct 15, 2025</div>
                </div>
                <div class="flex-1 min-w-[200px] px-md border-r border-outline-variant/20 last:border-r-0">
                    <div class="text-outline font-label-sm text-label-sm mb-base uppercase">Starts</div>
                    <div class="font-label-md text-label-md text-on-surface">Nov 1, 2025</div>
                </div>
                <div class="flex-1 min-w-[200px] px-md border-r border-outline-variant/20 last:border-r-0">
                    <div class="text-outline font-label-sm text-label-sm mb-base uppercase">Venue</div>
                    <div class="font-label-md text-label-md text-on-surface truncate">Legacy Pitch, Surulere</div>
                </div>
                <div class="flex-1 min-w-[200px] px-md border-r border-outline-variant/20 last:border-r-0">
                    <div class="text-outline font-label-sm text-label-sm mb-base uppercase">Format</div>
                    <div class="font-label-md text-label-md text-on-surface">Group + Knockout</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-[1200px] mx-auto px-md md:px-lg py-lg md:py-xl grid grid-cols-1 lg:grid-cols-12 gap-lg md:gap-xl">
        <!-- Left Column: Main Content -->
        <div class="lg:col-span-8 flex flex-col gap-xl">
            <!-- Tab System -->
            <div class="flex border-b border-outline-variant/20 overflow-x-auto hide-scrollbar gap-lg">
                <button class="pb-sm border-b-2 border-primary text-primary font-label-md text-label-md font-bold whitespace-nowrap">Overview</button>
                <button class="pb-sm border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-label-md text-label-md whitespace-nowrap transition-colors">Fixtures</button>
                <button class="pb-sm border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-label-md text-label-md whitespace-nowrap transition-colors">Standings</button>
                <button class="pb-sm border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-label-md text-label-md whitespace-nowrap transition-colors">Teams</button>
                <button class="pb-sm border-b-2 border-transparent text-on-surface-variant hover:text-on-surface font-label-md text-label-md whitespace-nowrap transition-colors">Matches</button>
            </div>
            
            <!-- Overview Content -->
            <div class="flex flex-col gap-lg animate-fade-in">
                <div class="prose prose-sm md:prose-base text-on-surface-variant font-body-md text-body-md leading-relaxed">
                    <p class="mb-sm">The Lagos Community Cup is the premier grassroots football tournament in Nigeria, bringing together the finest U-21 talent from across the state. Designed to foster community spirit and showcase emerging athletic prowess, the 2026 edition promises unprecedented competitive intensity.</p>
                    <p>Teams will battle through a rigorous group stage before advancing to the high-stakes knockout rounds, culminating in a grand final at the historic Legacy Pitch.</p>
                </div>
                
                <!-- Competition Format Visual -->
                <div class="bg-surface-container-low rounded-2xl p-md md:p-lg border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface mb-md">Competition Format</h3>
                    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-sm md:gap-lg relative">
                        <div class="hidden md:block absolute top-1/2 left-0 w-full h-[2px] bg-outline-variant/20 -translate-y-1/2 z-0"></div>
                        
                        <!-- Stage 1 -->
                        <div class="flex-1 bg-surface border border-outline-variant/20 rounded-xl p-md relative z-10 flex flex-col items-center text-center shadow-sm">
                            <div class="w-10 h-10 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center mb-sm">
                                <span class="material-symbols-outlined">grid_view</span>
                            </div>
                            <div class="font-label-md text-label-md font-bold mb-base text-on-surface">Group Stage</div>
                            <div class="font-label-sm text-label-sm text-outline">6 Groups of 4 Teams</div>
                        </div>
                        
                        <div class="md:hidden flex justify-center text-outline-variant">
                            <span class="material-symbols-outlined">arrow_downward</span>
                        </div>
                        
                        <!-- Stage 2 -->
                        <div class="flex-1 bg-surface border border-outline-variant/20 rounded-xl p-md relative z-10 flex flex-col items-center text-center shadow-sm">
                            <div class="w-10 h-10 rounded-full bg-surface-variant text-on-surface flex items-center justify-center mb-sm">
                                <span class="material-symbols-outlined">account_tree</span>
                            </div>
                            <div class="font-label-md text-label-md font-bold mb-base text-on-surface">Knockouts</div>
                            <div class="font-label-sm text-label-sm text-outline">Round of 16 to Semis</div>
                        </div>
                        
                        <div class="md:hidden flex justify-center text-outline-variant">
                            <span class="material-symbols-outlined">arrow_downward</span>
                        </div>
                        
                        <!-- Stage 3 -->
                        <div class="flex-1 bg-surface border border-primary/30 rounded-xl p-md relative z-10 flex flex-col items-center text-center shadow-sm bg-primary/5">
                            <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center mb-sm shadow-md">
                                <span class="material-symbols-outlined">emoji_events</span>
                            </div>
                            <div class="font-label-md text-label-md font-bold mb-base text-on-surface">The Final</div>
                            <div class="font-label-sm text-label-sm text-outline">Legacy Pitch</div>
                        </div>
                    </div>
                </div>
                
                <!-- Editorial Details Rows -->
                <div class="flex flex-col gap-0 border-y border-outline-variant/20">
                    <div class="flex flex-col md:flex-row md:items-center py-md border-b border-outline-variant/10 last:border-b-0 gap-xs md:gap-xl">
                        <div class="font-label-sm text-label-sm text-outline w-32 uppercase tracking-wide">Location</div>
                        <div class="font-body-md text-body-md text-on-surface font-medium flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[18px] text-primary">pin_drop</span>
                            Legacy Pitch, National Stadium, Surulere, Lagos
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center py-md border-b border-outline-variant/10 last:border-b-0 gap-xs md:gap-xl">
                        <div class="font-label-sm text-label-sm text-outline w-32 uppercase tracking-wide">Eligibility</div>
                        <div class="font-body-md text-body-md text-on-surface font-medium">Players born after Jan 1, 2005. Amateur status only.</div>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center py-md border-b border-outline-variant/10 last:border-b-0 gap-xs md:gap-xl">
                        <div class="font-label-sm text-label-sm text-outline w-32 uppercase tracking-wide">Registration Fee</div>
                        <div class="font-body-md text-body-md text-on-surface font-medium">₦50,000 per team</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Sidebar -->
        <div class="lg:col-span-4 flex flex-col gap-lg">
            <!-- Organizer Profile -->
            <div class="bg-surface rounded-2xl p-md border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-sm mb-md">
                    <div class="w-12 h-12 rounded-full bg-surface-variant overflow-hidden border border-outline-variant/20 shrink-0">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqcWPIwvF61k9SYvj7CH0QBeDD_n2uOP3faFakMr4elK3aDXZUW6RMB9aCR58X_p_4RFHUdN123DjU6ixIN2zJR7_hoAJ8mm-BRGWJe2xA5YD2HaKaflkEFShVe1Y2tWWnQt190_fxEgoEaBE8Fs4sFyazDIuggr2O1XDm83R5hBziOtAm6yzUQXmSES5iSb9xEFewC2bQMLAx_4RA59Jjt8zZ_zNZlWpkMHUiD9TuIyGvmmiTnU2ISg"/>
                    </div>
                    <div>
                        <div class="font-label-md text-label-md font-bold text-on-surface flex items-center gap-xs">
                            Lagos FA Sub-Committee
                            <span class="material-symbols-outlined text-[16px] text-tertiary filled-icon">verified</span>
                        </div>
                        <div class="font-label-sm text-label-sm text-outline">Verified Organizer • 12 Tournaments</div>
                    </div>
                </div>
                <button class="w-full py-sm px-md border border-outline-variant rounded-lg text-on-surface font-label-md text-label-md hover:bg-surface-variant/30 transition-colors active:scale-95">Contact Organizer</button>
            </div>
            
            <!-- Prize Pool -->
            <div class="bg-surface rounded-2xl p-md border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-col gap-md relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full -z-10"></div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-xs">
                    <span class="material-symbols-outlined text-primary">monetization_on</span>
                    Prize Pool
                </h3>
                <div class="flex flex-col gap-sm">
                    <div class="flex items-center justify-between p-sm rounded-xl border border-[#D4AF37]/30 bg-gradient-to-r from-[#D4AF37]/10 to-transparent relative overflow-hidden group">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#D4AF37]"></div>
                        <div class="flex items-center gap-sm pl-xs">
                            <span class="material-symbols-outlined text-[#D4AF37] filled-icon">trophy</span>
                            <span class="font-label-md text-label-md font-bold text-on-surface">Winner</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-[#D4AF37]">₦500,000</div>
                    </div>
                    <div class="flex items-center justify-between p-sm rounded-xl border border-[#C0C0C0]/30 bg-gradient-to-r from-[#C0C0C0]/10 to-transparent relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#C0C0C0]"></div>
                        <div class="flex items-center gap-sm pl-xs">
                            <span class="material-symbols-outlined text-[#C0C0C0] filled-icon">test_clone</span>
                            <span class="font-label-md text-label-md font-bold text-on-surface">Runner-Up</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-on-surface">₦250,000</div>
                    </div>
                    <div class="flex items-center justify-between p-sm rounded-xl border border-[#CD7F32]/30 bg-gradient-to-r from-[#CD7F32]/10 to-transparent relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#CD7F32]"></div>
                        <div class="flex items-center gap-sm pl-xs">
                            <span class="material-symbols-outlined text-[#CD7F32] filled-icon">military_tech</span>
                            <span class="font-label-md text-label-md font-bold text-on-surface">3rd Place</span>
                        </div>
                        <div class="font-headline-sm text-headline-sm font-bold text-on-surface">₦100,000</div>
                    </div>
                </div>
            </div>
            
            <!-- Location Map -->
            <div class="bg-surface rounded-2xl border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)] overflow-hidden">
                <div class="p-md border-b border-outline-variant/10">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface">Location</h3>
                </div>
                <div class="h-48 w-full bg-surface-variant relative">
                    <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCyDzj3mida3Ta6eS7Ghk1wmYa2YzrUnOZa2Mn4QqhnWPrqTAYG7yk63KM7_tAzcAcv3CfIlk_arkDR-SSl8vasZTSm00xHLFC7Ulie4A3Mr5tH-o3P9-SQVRal_IG72j44NEXBB5OQW4LsweQf4KSvYn4qWfPuaSHle2qHY8eYeGXyZ12xmupPF1n_0_yL3AFpgc3RKYVGsydNBaS5AgQ-hwIH1sL1V_-Y8NOFYgTYeAfUqSonn76Kng')"></div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection