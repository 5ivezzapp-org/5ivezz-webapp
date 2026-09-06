@extends('layouts.guest')

@section('title', 'Login - 5ivezz')

@section('content')
    <style>
        .text-shadow-sm {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>

    <!-- Left Side: Cinematic Visual Identity -->
    <div class="hidden md:flex md:w-1/2 lg:w-[55%] fixed left-0 top-0 h-full">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://lh3.googleusercontent.com/aida/AEtjO1VEWJ56494BAJUfUE4MnGzIEh43OdfKaaBij1hMAKRIB5oJK2aC3hQLJuip_BOt2oWhZr3-OsB1-2tFYnu_zjPTGh9x33Hmxth1_itNUDyRgijyQBfeB05Cg6th7SBq1o_19y78k-oe-Ueyy7ROcAug4Bn-6OyWyICA4qkGlZKkPrn85r3_KN2n5vpN8ngEB2EuGcth3999C3wkcynOWDcH9HGTz2LWkIu9d2unhTrvU-l4IgXtRpKKUPQ');">
        </div>
        <!-- Gradient Overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 via-transparent to-transparent"></div>
        <!-- Typography Overlay -->
        <div class="relative z-10 p-3xl flex flex-col justify-end h-full">
            <h1 class="font-display-lg text-display-lg text-white max-w-2xl text-shadow-sm leading-tight tracking-tighter">
                YOUR FOOTBALL.<br />
                YOUR RECORD.<br />
                YOUR FUTURE.
            </h1>
        </div>
    </div>

    <!-- Right Side: Authentication Surface -->
    <div
        class="w-full md:w-1/2 lg:w-[45%] min-h-screen bg-surface-container-lowest flex flex-col items-center justify-center p-md md:p-3xl relative md:ml-auto">
        <div class="w-full max-w-md flex flex-col space-y-xl">
            <!-- Branding -->
            <div class="flex items-center justify-center md:justify-start">
                <span
                    class="font-display-lg text-headline-lg md:text-display-lg tracking-tighter text-primary">5ivezz</span>
            </div>

            <!-- Header -->
            <div class="flex flex-col space-y-xs">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Welcome back.</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Sign in to continue to 5ivezz.</p>
            </div>

            <!-- Form -->
            <form class="flex flex-col space-y-lg" method="POST" action="{{ route('player.login') }}">
                @csrf

                <div class="flex flex-col space-y-md">
                    <!-- Email Input -->
                    <div class="flex flex-col space-y-base">
                        <label class="font-label-md text-label-md text-on-surface" for="email">Email</label>
                        <input
                            class="w-full h-[48px] px-md rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors font-body-md text-body-md shadow-sm @error('email') border-error @enderror"
                            id="email" name="email" placeholder="you@example.com" type="email" value="{{ old('email') }}"
                            required autofocus />
                        @error('email')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="flex flex-col space-y-base relative">
                        <div class="flex justify-between items-center">
                            <label class="font-label-md text-label-md text-on-surface" for="password">Password</label>
                            <a class="font-label-sm text-label-sm text-primary hover:text-primary-container transition-colors"
                                href="#">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <input
                                class="w-full h-[48px] px-md pr-[48px] rounded-lg border border-outline-variant bg-surface-container-lowest text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors font-body-md text-body-md shadow-sm @error('password') border-error @enderror"
                                id="password" name="password" placeholder="••••••••" type="password" required />
                            <button type="button" onclick="togglePassword()"
                                class="absolute right-md top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors"
                                aria-label="Toggle password visibility">
                                <span class="material-symbols-outlined text-[20px]" id="passwordIcon">visibility_off</span>
                            </button>
                            @error('password')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center space-x-sm">
                        <input
                            class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary focus:ring-2 focus:ring-offset-2 transition-colors"
                            id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} />
                        <label class="font-label-sm text-label-sm text-on-surface-variant" for="remember">Remember
                            me</label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    class="w-full h-[48px] bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:bg-primary/90 hover:shadow-md active:scale-95 transition-all flex items-center justify-center space-x-xs"
                    type="submit">
                    <span>Sign in</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>

            <!-- Secondary Actions -->
            <div class="flex flex-col items-center justify-center space-y-lg pt-md">
                <a class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors"
                    href="{{ route('player.register') }}">
                    Don't have a 5ivezz account? Create your football identity
                </a>
            </div>
        </div>

        <!-- Bottom Action -->
        <div class="absolute bottom-lg w-full flex justify-center pb-md md:pb-0">
            <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center space-x-base"
                href="{{ route('organizer.register') }}">
                <span>Running a tournament? Create an organizer account</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const passwordIcon = document.getElementById('passwordIcon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.textContent = 'visibility';
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.textContent = 'visibility_off';
                }
            }
        </script>
    @endpush
@endsection