{{-- resources/views/organizer/auth/register.blade.php --}}
@extends('layouts.guest')

@section('title', 'Organizer Registration - 5ivezz')

@section('content')
    <style>
        .input-premium {
            width: 100%;
            height: 56px;
            padding: 0 16px;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: #181c1c;
            transition: all 0.2s ease;
        }

        .input-premium:focus {
            outline: none;
            border-color: #0d7377;
            box-shadow: 0 0 0 3px rgba(13, 115, 119, 0.1);
        }

        .input-premium::placeholder {
            color: #9ca3af;
        }

        .input-premium-error {
            border-color: #dc2626 !important;
        }

        .file-drop-zone {
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
            min-height: 200px;
        }

        .file-drop-zone:hover {
            border-color: #0d7377;
            background-color: #f9fafb;
        }

        .file-drop-zone-error {
            border-color: #dc2626 !important;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Organizer Registration
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('organizer.login') }}" class="font-medium text-primary hover:text-primary/80">
                        Sign in here
                    </a>
                </p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Registration Form -->
            <form method="POST" action="{{ route('organizer.register') }}" enctype="multipart/form-data"
                class="bg-white shadow-lg rounded-lg p-8">
                @csrf

                <!-- Personal Information -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="full_name">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input class="input-premium @error('full_name') input-premium-error @enderror" id="full_name"
                                name="full_name" placeholder="John Doe" type="text" value="{{ old('full_name') }}"
                                required />
                            @error('full_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="email">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input class="input-premium @error('email') input-premium-error @enderror" id="email"
                                name="email" placeholder="you@example.com" type="email" value="{{ old('email') }}"
                                required />
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input class="input-premium @error('phone') input-premium-error @enderror" id="phone"
                                name="phone" placeholder="+234 800 000 0000" type="tel" value="{{ old('phone') }}"
                                required />
                            @error('phone')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="state">
                                State <span class="text-red-500">*</span>
                            </label>
                            <select class="input-premium appearance-none @error('state') input-premium-error @enderror"
                                id="state" name="state" required>
                                <option value="">Select a State</option>
                                @foreach($states as $stateName => $lgas)
                                    <option value="{{ $stateName }}" {{ old('state') == $stateName ? 'selected' : '' }}>
                                        {{ $stateName }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="city">
                                City/LGA <span class="text-red-500">*</span>
                            </label>
                            <select class="input-premium appearance-none @error('city') input-premium-error @enderror"
                                id="city" name="city" required>
                                <option value="">Select City/LGA</option>
                                @if(old('state') && isset($states[old('state')]))
                                    @foreach($states[old('state')] as $lga)
                                        <option value="{{ $lga }}" {{ old('city') == $lga ? 'selected' : '' }}>
                                            {{ $lga }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('city')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Organization Information -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Organization Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="company_name">
                                Company Name
                            </label>
                            <input class="input-premium @error('company_name') input-premium-error @enderror"
                                id="company_name" name="company_name" placeholder="Acme Sports Ltd." type="text"
                                value="{{ old('company_name') }}" />
                            @error('company_name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="cac_document">
                                CAC Document <span class="text-red-500">*</span>
                            </label>
                            <div
                                class="relative group cursor-pointer file-drop-zone rounded-lg bg-gray-50 hover:bg-gray-100 p-6 flex flex-col items-center justify-center transition-all duration-300 @error('cac_document') file-drop-zone-error @enderror">
                                <span
                                    class="material-symbols-outlined text-4xl text-gray-400 mb-3 group-hover:text-primary transition-colors">
                                    cloud_upload
                                </span>
                                <p class="text-sm font-medium text-gray-700 text-center">Click to upload or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1 text-center">PDF, JPG, or PNG (Max. 10MB)</p>
                                <input accept=".pdf,.jpg,.jpeg,.png"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="cac_document"
                                    name="cac_document" type="file" required />
                                <div id="cacPreview" class="absolute inset-0 rounded-lg overflow-hidden hidden">
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                        <span class="material-symbols-outlined text-6xl text-primary">description</span>
                                        <span class="ml-2 text-sm text-gray-600" id="cacFileName"></span>
                                    </div>
                                </div>
                            </div>
                            @error('cac_document')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2">Upload your Corporate Affairs Commission (CAC)
                                registration document.</p>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Password</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="password">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input class="input-premium @error('password') input-premium-error @enderror" id="password"
                                name="password" placeholder="Min. 8 characters" type="password" required />
                            @error('password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <input class="input-premium @error('password_confirmation') input-premium-error @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Confirm your password"
                                type="password" required />
                            @error('password_confirmation')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Company Logo -->
                <div class="border-b border-gray-200 pb-8 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Logo</h3>
                    <div class="flex items-center gap-8">
                        <div
                            class="relative group w-32 h-32 rounded-full border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-primary flex items-center justify-center overflow-hidden transition-all duration-300 cursor-pointer @error('company_logo') border-red-500 @enderror">
                            <span
                                class="material-symbols-outlined text-4xl text-gray-400 group-hover:text-primary transition-colors">
                                add_photo_alternate
                            </span>
                            <input accept=".jpg,.jpeg,.png,.webp"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="company_logo"
                                name="company_logo" type="file" />
                            <div id="logoPreview" class="absolute inset-0 hidden">
                                <img src="" alt="Logo preview" class="w-full h-full object-cover" />
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Upload Logo</p>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP<br />Recommended size: 512x512px</p>
                            @error('company_logo')
                                <p class="error-message mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="mb-8">
                    <div class="flex items-start gap-3">
                        <input
                            class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary @error('terms') border-red-500 @enderror"
                            id="terms" name="terms" type="checkbox" {{ old('terms') ? 'checked' : '' }} required />
                        <div>
                            <label class="text-sm text-gray-700" for="terms">
                                I agree to the
                                <a href="#" class="text-primary hover:text-primary/80 font-medium">Terms of Service</a>
                                and
                                <a href="#" class="text-primary hover:text-primary/80 font-medium">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </label>
                            @error('terms')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('organizer.login') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        Already have an account? Sign in
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 transition-all shadow-sm">
                        Register as Organizer
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // State and City/LGA dynamic dropdown
            document.addEventListener('DOMContentLoaded', function () {
                const stateSelect = document.getElementById('state');
                const citySelect = document.getElementById('city');
                const statesData = @json($states);

                stateSelect.addEventListener('change', function () {
                    const selectedState = this.value;
                    const lgas = statesData[selectedState] || [];

                    citySelect.innerHTML = '<option value="">Select City/LGA</option>';

                    lgas.forEach(function (lga) {
                        const option = document.createElement('option');
                        option.value = lga;
                        option.textContent = lga;
                        citySelect.appendChild(option);
                    });
                });

                // File upload preview for CAC document
                document.getElementById('cac_document').addEventListener('change', function (e) {
                    if (this.files && this.files[0]) {
                        const preview = document.getElementById('cacPreview');
                        const fileName = document.getElementById('cacFileName');
                        const file = this.files[0];

                        fileName.textContent = file.name;
                        preview.classList.remove('hidden');

                        // If it's an image, show preview
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'w-full h-full object-cover';
                                const container = preview.querySelector('div');
                                container.innerHTML = '';
                                container.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                });

                // Logo preview
                document.getElementById('company_logo').addEventListener('change', function (e) {
                    if (this.files && this.files[0]) {
                        const preview = document.getElementById('logoPreview');
                        const img = preview.querySelector('img');
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            img.src = e.target.result;
                            preview.classList.remove('hidden');
                        };

                        reader.readAsDataURL(this.files[0]);
                    }
                });
            });
        </script>
    @endpush
@endsection