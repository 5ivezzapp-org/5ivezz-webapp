@extends('layouts.guest')

@section('title', '5ivezz Wallet - Coming Soon')

@section('content')
<!-- Main Container -->
<main class="max-w-4xl mx-auto px-4 md:px-lg pt-16 pb-32 flex flex-col items-center">
    <!-- HERO SECTION -->
    <section class="w-full min-h-[819px] flex flex-col items-center justify-center text-center relative py-12">
        <!-- Ambient Glow Background -->
        <div class="absolute w-72 h-72 md:w-96 md:h-96 rounded-full bg-primary/10 blur-[120px] pointer-events-none -z-10 top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2"></div>
        
        <!-- Badge -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-container-lowest border border-primary/20 shadow-sm mb-8 backdrop-blur-md">
            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
            <span class="font-label-sm text-primary tracking-wider">COMING SOON</span>
        </div>
        
        <!-- Headline -->
        <h1 class="font-display-lg text-4xl md:text-6xl text-on-surface tracking-tight max-w-2xl mb-6">
            Your football wallet is coming.
        </h1>
        
        <!-- Supporting Text -->
        <p class="font-body-lg text-on-surface-variant max-w-xl mb-12">
            A new way to move, fund and support football through 5ivezz.
        </p>
        
        <!-- ABSTRACT WALLET VISUALIZATION -->
        <div class="w-full py-8 relative flex items-center justify-center my-6">
            <div class="absolute inset-0 bg-gradient-to-b from-primary/5 via-transparent to-transparent rounded-3xl -z-10"></div>
            <div class="w-full max-w-lg h-64 md:h-80 rounded-3xl bg-surface-container-lowest/80 border border-black/5 backdrop-blur-2xl shadow-xl relative overflow-hidden flex items-center justify-center group">
                <!-- Glass Card Elements simulating Financial Primitives -->
                <div class="absolute w-48 h-28 rounded-2xl bg-gradient-to-tr from-primary/20 to-secondary/15 border border-black/5 backdrop-blur-md shadow-lg transform -rotate-6 -translate-x-6 group-hover:rotate-0 transition-transform duration-700"></div>
                <div class="absolute w-48 h-28 rounded-2xl bg-gradient-to-br from-surface-container-lowest to-surface-container border border-black/5 backdrop-blur-md shadow-lg transform rotate-6 translate-x-6 group-hover:rotate-0 transition-transform duration-700 flex flex-col justify-between p-4">
                    <div class="flex justify-between items-center">
                        <span class="w-6 h-6 rounded-full bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-xs text-primary">sports_soccer</span>
                        </span>
                        <span class="text-xs font-label-sm text-primary">5ivezz</span>
                    </div>
                    <div class="space-y-1">
                        <div class="w-16 h-2 bg-black/10 rounded"></div>
                        <div class="w-24 h-3 bg-black/20 rounded"></div>
                    </div>
                </div>
                <!-- Central Glowing Node -->
                <div class="absolute w-16 h-16 rounded-full bg-primary/20 border border-primary/40 blur-sm flex items-center justify-center animate-pulse"></div>
                <div class="absolute w-12 h-12 rounded-full bg-surface-container-lowest border border-primary/30 flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                </div>
                <!-- Connection Particles -->
                <div class="absolute top-1/4 left-1/4 w-1.5 h-1.5 rounded-full bg-primary animate-ping"></div>
                <div class="absolute bottom-1/4 right-1/4 w-1.5 h-1.5 rounded-full bg-secondary animate-ping" style="animation-delay: 1s;"></div>
            </div>
        </div>
    </section>

    <!-- PRIMARY MESSAGE SECTION -->
    <section class="w-full py-16 text-center flex flex-col items-center">
        <h2 class="font-headline-lg text-on-surface mb-4">
            Football is more than the game.
        </h2>
        <p class="font-body-lg text-on-surface-variant max-w-lg">
            Participation costs money. Support should move easily. The future of football finance is coming to 5ivezz.
        </p>
    </section>

    <!-- WHAT'S COMING (Visual Journey) -->
    <section class="w-full py-16">
        <div class="text-center mb-12">
            <span class="font-label-sm text-primary uppercase tracking-wider">Visual Journey</span>
            <h3 class="font-headline-md text-on-surface mt-2">What's coming</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
            <!-- PAY -->
            <div class="bg-surface-container-lowest border border-black/5 rounded-2xl p-6 shadow-sm backdrop-blur-xl flex flex-col justify-between relative overflow-hidden group hover:border-primary/30 transition-colors">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <h4 class="font-headline-sm text-on-surface mb-2">PAY</h4>
                    <p class="font-body-md text-on-surface-variant">
                        Football payments: Participation and tournament payments designed around football.
                    </p>
                </div>
            </div>
            
            <!-- SUPPORT -->
            <div class="bg-surface-container-lowest border border-black/5 rounded-2xl p-6 shadow-sm backdrop-blur-xl flex flex-col justify-between relative overflow-hidden group hover:border-primary/30 transition-colors">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined">volunteer_activism</span>
                    </div>
                    <h4 class="font-headline-sm text-on-surface mb-2">SUPPORT</h4>
                    <p class="font-body-md text-on-surface-variant">
                        Receive support: Community funding can move directly toward football participation.
                    </p>
                </div>
            </div>
            
            <!-- MANAGE -->
            <div class="bg-surface-container-lowest border border-black/5 rounded-2xl p-6 shadow-sm backdrop-blur-xl flex flex-col justify-between relative overflow-hidden group hover:border-primary/30 transition-colors">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full blur-2xl group-hover:bg-primary/10 transition-colors"></div>
                <div>
                    <div class="w-12 h-12 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-primary mb-6">
                        <span class="material-symbols-outlined">account_balance</span>
                    </div>
                    <h4 class="font-headline-sm text-on-surface mb-2">MANAGE</h4>
                    <p class="font-body-md text-on-surface-variant">
                        One football wallet: A simpler financial layer for the 5ivezz ecosystem.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTBALL CONNECTION -->
    <section class="w-full py-16">
        <div class="bg-surface-container-lowest border border-black/5 rounded-3xl p-8 shadow-sm backdrop-blur-xl flex flex-col items-center text-center">
            <span class="font-label-sm text-primary mb-2">ECOSYSTEM FLOW</span>
            <h3 class="font-headline-md text-on-surface mb-8">Football Connection</h3>
            <!-- Flow Steps -->
            <div class="flex flex-wrap items-center justify-center gap-3 md:gap-4 text-sm font-label-md">
                <div class="px-4 py-2 rounded-xl bg-surface-container border border-black/5 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-primary">person</span>
                    Player
                </div>
                <span class="material-symbols-outlined text-outline-variant text-sm">arrow_forward</span>
                <div class="px-4 py-2 rounded-xl bg-surface-container border border-black/5 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-primary">emoji_events</span>
                    Tournament
                </div>
                <span class="material-symbols-outlined text-outline-variant text-sm">arrow_forward</span>
                <div class="px-4 py-2 rounded-xl bg-surface-container border border-black/5 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-primary">sports_soccer</span>
                    Participation
                </div>
                <span class="material-symbols-outlined text-outline-variant text-sm">arrow_forward</span>
                <div class="px-4 py-2 rounded-xl bg-surface-container border border-black/5 text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-xs text-primary">favorite</span>
                    Support
                </div>
                <span class="material-symbols-outlined text-outline-variant text-sm">arrow_forward</span>
                <div class="px-4 py-2 rounded-xl bg-primary text-white font-semibold flex items-center gap-2 shadow-md">
                    <span class="material-symbols-outlined text-xs">wallet</span>
                    Wallet
                </div>
            </div>
        </div>
    </section>

    <!-- COMING SOON STATEMENT -->
    <section class="w-full py-20 text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-surface-container-lowest border border-black/5 shadow-sm flex items-center justify-center text-primary mb-6">
            <span class="material-symbols-outlined">hourglass_top</span>
        </div>
        <h3 class="font-headline-lg text-on-surface mb-4">
            Something important is on the way.
        </h3>
        <p class="font-body-lg text-on-surface-variant max-w-md">
            We're building the financial layer that will make participating in football simpler.
        </p>
    </section>
</main>
@endsection