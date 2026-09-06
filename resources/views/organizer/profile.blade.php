{{-- resources/views/organizer/profile.blade.php --}}
@extends('layouts.guest')

@section('title', 'Organizer Profile - 5ivezz')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Profile Settings</h1>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Profile Information -->
        <form action="{{ route('organizer.profile.update') }}" method="POST" class="mb-8">
            @csrf
            @method('PUT')
            
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="full_name">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('full_name') border-red-500 @enderror" 
                           id="full_name" 
                           name="full_name" 
                           type="text" 
                           value="{{ old('full_name', $organizer->full_name) }}" 
                           required />
                    @error('full_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror" 
                           id="phone" 
                           name="phone" 
                           type="tel" 
                           value="{{ old('phone', $organizer->phone) }}" 
                           required />
                    @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="company_name">
                        Company Name
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('company_name') border-red-500 @enderror" 
                           id="company_name" 
                           name="company_name" 
                           type="text" 
                           value="{{ old('company_name', $organizer->company_name) }}" />
                    @error('company_name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="state">
                        State <span class="text-red-500">*</span>
                    </label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('state') border-red-500 @enderror" 
                            id="state" 
                            name="state" 
                            required>
                        <option value="Lagos" {{ $organizer->state == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                        <option value="Abuja" {{ $organizer->state == 'Abuja' ? 'selected' : '' }}>Abuja</option>
                        <option value="Kano" {{ $organizer->state == 'Kano' ? 'selected' : '' }}>Kano</option>
                        <option value="Rivers" {{ $organizer->state == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                        <option value="Oyo" {{ $organizer->state == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                        <option value="Kaduna" {{ $organizer->state == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                        <option value="Enugu" {{ $organizer->state == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                        <option value="Benue" {{ $organizer->state == 'Benue' ? 'selected' : '' }}>Benue</option>
                        <option value="Ogun" {{ $organizer->state == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                        <option value="Akwa Ibom" {{ $organizer->state == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                    </select>
                    @error('state')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" 
                    class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                Update Profile
            </button>
        </form>

        <!-- Company Logo -->
        <form action="{{ route('organizer.profile.logo') }}" method="POST" enctype="multipart/form-data" class="border-t border-gray-200 pt-8 mb-8">
            @csrf
            
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Company Logo</h2>
            <div class="flex items-center gap-8">
                <div class="relative group w-32 h-32 rounded-full border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-primary flex items-center justify-center overflow-hidden transition-all duration-300 cursor-pointer">
                    @if($organizer->company_logo)
                        <img src="{{ asset('storage/' . $organizer->company_logo) }}" 
                             alt="{{ $organizer->company_name }}" 
                             class="w-full h-full object-cover" />
                    @else
                        <span class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">
                            add_photo_alternate
                        </span>
                    @endif
                    <input accept=".jpg,.jpeg,.png,.webp" 
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                           id="company_logo" 
                           name="company_logo" 
                           type="file" />
                </div>
                <div>
                    <p class="text-sm text-gray-700">Click the image to upload a new logo</p>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP • Max: 2MB</p>
                    @error('company_logo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" 
                    class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                Update Logo
            </button>
        </form>

        <!-- Password Change -->
        <form action="{{ route('organizer.profile.password') }}" method="POST" class="border-t border-gray-200 pt-8">
            @csrf
            @method('PUT')
            
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="current_password">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('current_password') border-red-500 @enderror" 
                           id="current_password" 
                           name="current_password" 
                           type="password" 
                           required />
                    @error('current_password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror" 
                           id="password" 
                           name="password" 
                           type="password" 
                           required />
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password_confirmation') border-red-500 @enderror" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required />
                    @error('password_confirmation')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <button type="submit" 
                    class="mt-4 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                Update Password
            </button>
        </form>
    </div>
</div>
@endsection