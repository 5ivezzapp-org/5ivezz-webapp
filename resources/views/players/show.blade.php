@extends('layouts.guest')

@section('title', '5ivezz - Player Details')

@section('content')
    <style>
        body {
            background-color: #F7F8F6;
        }
    </style>

    <main class="w-full max-w-[1200px] mx-auto md:pt-4 md:px-lg md:pb-3xl pb-24">
        <!-- Hero Section -->
        <section class="relative w-full h-[60vh] md:h-[500px] md:mt-lg md:rounded-[32px] overflow-hidden bg-on-surface">
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('https://lh3.googleusercontent.com/aida/AEtjO1VoEhjtWs81YB2MmOs3rqA0WiyElGf_yLti24s9PXGB9UeIaNqAf7aUHwOu-Od1LppwB8pwwJRV42mVc-GUeVmqrVIlfHfmCu2JMHOFsc4y1-KrTh5_ObakFZHdk1ZS-kbm5DOhPTjgI1ANZSz9qg3hfJ3v7jSmWadxireH3L7EArPp3yrcDvYHa4ZazY_RnugcXlzcjhyhPAlixziHEfdPiHVuRd0Cz79n9dZuSSLmjUtMIs8WA4ZWRmyK');">
            </div>

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#000000] via-[#000000]/40 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-full p-md md:p-xl flex flex-col justify-end">
                <div class="flex items-center gap-sm mb-2">
                    <span
                        class="bg-secondary-container/20 text-secondary-container px-3 py-1 rounded-full font-label-sm text-label-sm border border-secondary-container/30 flex items-center gap-1 backdrop-blur-md">
                        <span class="material-symbols-outlined text-[14px]">verified</span> Verified
                    </span>
                    <span
                        class="bg-surface/10 text-on-secondary px-3 py-1 rounded-full font-label-sm text-label-sm backdrop-blur-md border border-white/10">
                        STRIKER · ST
                    </span>
                </div>
                <h1
                    class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-secondary uppercase tracking-tight">
                    JOHN DOE
                </h1>
            </div>
        </section>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-lg mt-lg px-md md:px-0">
            <!-- Left Column (Stats & Metadata) -->
            <div class="md:col-span-8 flex flex-col gap-lg">
                <!-- Massive Stats Bento -->
                <section
                    class="bg-surface-container-lowest rounded-[24px] p-lg border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)] flex flex-wrap justify-between items-center gap-md">
                    <div class="flex flex-col flex-1 min-w-[100px]">
                        <span class="font-label-md text-label-md text-outline mb-1 uppercase tracking-wider">Matches</span>
                        <span
                            class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tighter">18</span>
                    </div>
                    <div class="h-16 w-px bg-outline-variant/20 hidden md:block"></div>
                    <div class="flex flex-col flex-1 min-w-[100px]">
                        <span class="font-label-md text-label-md text-outline mb-1 uppercase tracking-wider">Goals</span>
                        <span
                            class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tighter">12</span>
                    </div>
                    <div class="h-16 w-px bg-outline-variant/20 hidden md:block"></div>
                    <div class="flex flex-col flex-1 min-w-[100px]">
                        <span class="font-label-md text-label-md text-outline mb-1 uppercase tracking-wider">Assists</span>
                        <span
                            class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary tracking-tighter">7</span>
                    </div>
                </section>

                <!-- Metadata Rows -->
                <section
                    class="bg-surface-container-lowest rounded-[24px] p-md md:p-lg border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <div class="flex justify-between items-center py-sm border-b border-outline-variant/10">
                        <span class="font-body-md text-body-md text-on-surface-variant">Position</span>
                        <span class="font-label-md text-label-md text-on-surface">Striker (ST)</span>
                    </div>
                    <div class="flex justify-between items-center py-sm border-b border-outline-variant/10">
                        <span class="font-body-md text-body-md text-on-surface-variant">Preferred Foot</span>
                        <span class="font-label-md text-label-md text-on-surface">Right</span>
                    </div>
                    <div class="flex justify-between items-center py-sm border-b border-outline-variant/10">
                        <span class="font-body-md text-body-md text-on-surface-variant">Level</span>
                        <span class="font-label-md text-label-md text-on-surface">Amateur First Division</span>
                    </div>
                    <div class="flex justify-between items-center pt-sm">
                        <span class="font-body-md text-body-md text-on-surface-variant">Location</span>
                        <span class="font-label-md text-label-md text-on-surface">Lagos, Nigeria</span>
                    </div>
                </section>

                <!-- Editorial Timeline -->
                <section
                    class="bg-surface-container-lowest rounded-[24px] p-md md:p-lg border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <h2 class="font-headline-sm text-headline-sm text-on-surface mb-md">Football History</h2>
                    <div class="relative pl-6 border-l-2 border-primary/20">
                        <div class="mb-lg relative">
                            <div
                                class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-primary border-4 border-surface-container-lowest">
                            </div>
                            <div class="font-label-sm text-label-sm text-primary mb-1">2026 - Present</div>
                            <div class="font-headline-sm-mobile text-headline-sm-mobile text-on-surface">Lagos United</div>
                            <div class="font-body-md text-body-md text-on-surface-variant mt-1">First Team · Striker</div>
                        </div>
                        <div class="relative">
                            <div
                                class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-outline-variant border-4 border-surface-container-lowest">
                            </div>
                            <div class="font-label-sm text-label-sm text-outline mb-1">2025</div>
                            <div class="font-headline-sm-mobile text-headline-sm-mobile text-on-surface">Mainland FC</div>
                            <div class="font-body-md text-body-md text-on-surface-variant mt-1">Youth Academy</div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column (Sidebar) -->
            <div class="md:col-span-4 flex flex-col gap-lg">
                <!-- Current Team Surface -->
                <section
                    class="bg-primary text-on-primary rounded-[24px] p-lg shadow-xl relative overflow-hidden group cursor-pointer active:scale-[0.98] transition-transform">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary-container/20 to-transparent"></div>
                    <div class="relative z-10 flex flex-col items-center text-center">
                        <div
                            class="w-20 h-20 rounded-full bg-on-primary/10 flex items-center justify-center mb-md border border-white/20">
                            <span class="material-symbols-outlined text-[40px] text-on-primary">shield</span>
                        </div>
                        <h3 class="font-headline-sm text-headline-sm text-on-primary mb-1">Lagos United</h3>
                        <p class="font-body-md text-body-md text-on-primary/80 mb-lg">Current Squad</p>
                        <button
                            class="w-full bg-on-primary text-primary font-label-md text-label-md py-3 rounded-xl hover:bg-on-primary/90 transition-colors">
                            View Team
                        </button>
                    </div>
                </section>

                <!-- Achievements -->
                <section
                    class="bg-surface-container-lowest rounded-[24px] p-md md:p-lg border border-outline-variant/10 shadow-[0_4px_12px_rgba(0,0,0,0.03)]">
                    <h2 class="font-headline-sm-mobile text-headline-sm-mobile text-on-surface mb-md">Achievements</h2>
                    <div
                        class="flex items-center gap-sm p-sm bg-surface-container-low rounded-xl border border-outline-variant/20">
                        <div class="w-12 h-12 rounded-lg bg-surface-variant flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">emoji_events</span>
                        </div>
                        <div>
                            <div class="font-label-sm text-label-sm text-outline">2026</div>
                            <div class="font-label-md text-label-md text-on-surface">League Winner</div>
                        </div>
                    </div>
                </section>

                <!-- Trust Surface -->
                <div
                    class="bg-surface-container-low rounded-xl p-sm flex items-center justify-center gap-2 border border-outline-variant/20">
                    <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">VERIFIED
                        FOOTBALL RECORD</span>
                </div>
            </div>
        </div>
    </main>
@endsection