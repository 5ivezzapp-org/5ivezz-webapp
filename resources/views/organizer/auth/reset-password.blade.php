{{-- resources/views/organizer/auth/reset-password.blade.php --}}
@extends('layouts.guest')

@section('title', 'Reset Password - 5ivezz')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Set New Password
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your new password below.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="bg-white shadow-lg rounded-lg p-8" action="{{ route('organizer.password.update') }}" method="POST">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                        New Password
                    </label>
                    <input id="password" name="password" type="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors" 
                           placeholder="Min. 8 characters">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-colors" 
                           placeholder="Confirm your password">
                </div>

                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg text-sm font-medium text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection