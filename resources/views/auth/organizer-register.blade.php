@extends('layouts.guest')

@section('title', 'Organizer Registration - 5ivezz')

@section('content')
<style>
    .input-premium {
        width: 100%;
        height: 56px;
        padding: 0 16px;
        background-color: #ffffff;
        border: 1px solid #bec9c9;
        border-radius: 0.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        color: #181c1c;
        transition: all 0.2s ease;
    }
    .input-premium:focus {
        outline: none;
        border-color: #0d7377;
        ring: 4px solid rgba(13, 115, 119, 0.1);
    }
    .input-premium::placeholder {
        color: #6e7979;
        opacity: 0.5;
    }
    .file-drop-zone {
        border: 2px dashed #bec9c9;
        transition: all 0.3s ease;
    }
    .file-drop-zone:hover {
        border-color: #0d7377;
        background-color: #f1f4f4;
    }
</style>

<!-- Main Workspace Canvas -->
<main class="flex-grow pt-24 pb-48 px-4 md:px-lg max-w-5xl mx-auto w-full">
    <!-- Editorial Introduction -->
    <div class="mb-16 md:mb-24 pt-8">
        <span class="inline-block px-3 py-1 mb-6 bg-secondary-container/30 text-primary-container rounded-full font-label-sm text-label-sm tracking-wider uppercase">
            Organizer Application
        </span>
        <h2 class="font-display-lg text-display-lg text-on-surface max-w-2xl leading-tight">
            Bring your tournament to 5ivezz.
        </h2>
    </div>

    <form class="flex flex-col gap-12 md:gap-24" method="POST" action="{{ route('organizer.register') }}">
        @csrf
        
        <!-- SECTION 01: ORGANIZER DETAILS -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-16 pb-12 md:pb-24 border-b border-outline-variant/30">
            <div class="md:col-span-4 flex flex-col">
                <span class="font-display-lg text-display-lg text-outline-variant/50 leading-none">01</span>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-4 mb-2">Organizer Details</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Tell us who will be responsible for the competition.
                </p>
            </div>
            <div class="md:col-span-8 flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-on-surface" for="full_name">Full Name</label>
                    <input class="input-premium @error('full_name') border-error @enderror" 
                           id="full_name" 
                           name="full_name" 
                           placeholder="John Doe" 
                           type="text" 
                           value="{{ old('full_name') }}" 
                           required />
                    @error('full_name')
                        <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface" for="email">Email Address</label>
                        <input class="input-premium @error('email') border-error @enderror" 
                               id="email" 
                               name="email" 
                               placeholder="you@example.com" 
                               type="email" 
                               value="{{ old('email') }}" 
                               required />
                        @error('email')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="font-label-md text-label-md text-on-surface" for="phone">Phone Number</label>
                        <input class="input-premium @error('phone') border-error @enderror" 
                               id="phone" 
                               name="phone" 
                               placeholder="+234 800 000 0000" 
                               type="tel" 
                               value="{{ old('phone') }}" 
                               required />
                        @error('phone')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-8 pt-8 border-t border-outline-variant/20">
                    <h4 class="font-headline-sm text-headline-sm text-on-surface mb-2">Organization</h4>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-6">Tell us about the organization behind your tournaments.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex flex-col gap-2">
                            <label class="font-label-md text-label-md text-on-surface" for="company_name">Company Name</label>
                            <input class="input-premium @error('company_name') border-error @enderror" 
                                   id="company_name" 
                                   name="company_name" 
                                   placeholder="Acme Sports Ltd." 
                                   type="text" 
                                   value="{{ old('company_name') }}" />
                            @error('company_name')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="font-label-md text-label-md text-on-surface" for="state">State</label>
                            <div class="relative">
                                <select class="input-premium appearance-none @error('state') border-error @enderror" 
                                        id="state" 
                                        name="state" 
                                        required>
                                    <option disabled selected value="">Select a State</option>
                                    <option value="Lagos" {{ old('state') == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Abuja" {{ old('state') == 'Abuja' ? 'selected' : '' }}>Abuja</option>
                                    <option value="Kano" {{ old('state') == 'Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Rivers" {{ old('state') == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Oyo" {{ old('state') == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Kaduna" {{ old('state') == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <option value="Enugu" {{ old('state') == 'Enugu' ? 'selected' : '' }}>Enugu</option>
                                    <option value="Benue" {{ old('state') == 'Benue' ? 'selected' : '' }}>Benue</option>
                                    <option value="Ogun" {{ old('state') == 'Ogun' ? 'selected' : '' }}>Ogun</option>
                                    <option value="Akwa Ibom" {{ old('state') == 'Akwa Ibom' ? 'selected' : '' }}>Akwa Ibom</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-outline pointer-events-none">expand_more</span>
                            </div>
                            @error('state')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 02: ORGANIZATION VERIFICATION -->
        <section class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-16 pb-12">
            <div class="md:col-span-4 flex flex-col">
                <span class="font-display-lg text-display-lg text-outline-variant/50 leading-none">02</span>
                <h3 class="font-headline-md text-headline-md text-on-surface mt-4 mb-2">Organization Verification</h3>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    A little verification helps keep the 5ivezz tournament ecosystem trusted.
                </p>
            </div>
            <div class="md:col-span-8 flex flex-col gap-8">
                <!-- CAC Upload -->
                <div class="flex flex-col gap-3">
                    <label class="font-label-md text-label-md text-on-surface" for="cac_document">Upload CAC Document</label>
                    <div class="relative group cursor-pointer file-drop-zone rounded-xl bg-surface-container-lowest hover:bg-surface-container p-8 flex flex-col items-center justify-center min-h-[200px] transition-all duration-300 @error('cac_document') border-error @enderror">
                        <span class="material-symbols-outlined text-4xl text-outline mb-4 group-hover:text-primary-container transition-colors">cloud_upload</span>
                        <p class="font-body-md text-body-md text-on-surface font-medium text-center">Click to upload or drag and drop</p>
                        <p class="font-body-md text-body-md text-on-surface-variant mt-1 text-sm text-center">PDF, JPG, or PNG (Max. 10MB)</p>
                        <input accept=".pdf,.jpg,.jpeg,.png" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                               id="cac_document" 
                               name="cac_document" 
                               type="file" />
                    </div>
                    @error('cac_document')
                        <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                    @enderror
                    <p class="font-label-sm text-label-sm text-on-surface-variant mt-1">Upload your Corporate Affairs Commission (CAC) registration document.</p>
                </div>

                <!-- Company Logo Upload -->
                <div class="flex flex-col gap-3">
                    <label class="font-label-md text-label-md text-on-surface" for="company_logo">Company Logo</label>
                    <div class="flex items-center gap-6">
                        <div class="relative group w-32 h-32 rounded-full border-2 border-dashed border-outline-variant bg-surface-container-lowest hover:bg-surface-container hover:border-primary-container flex items-center justify-center overflow-hidden transition-all duration-300 cursor-pointer @error('company_logo') border-error @enderror">
                            <span class="material-symbols-outlined text-3xl text-outline group-hover:text-primary-container transition-colors">add_photo_alternate</span>
                            <input accept=".jpg,.jpeg,.png,.webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                   id="company_logo" 
                                   name="company_logo" 
                                   type="file" />
                        </div>
                        <div class="flex flex-col">
                            <p class="font-body-md text-body-md text-on-surface font-medium">Upload Logo</p>
                            <p class="font-body-md text-body-md text-on-surface-variant text-sm mt-1">JPG, PNG, WEBP<br/>Recommended size: 512x512px</p>
                            @error('company_logo')
                                <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start gap-3 mt-4">
                    <input class="w-5 h-5 mt-0.5 rounded border-outline-variant text-primary focus:ring-primary focus:ring-2 focus:ring-offset-2 transition-colors @error('terms') border-error @enderror" 
                           id="terms" 
                           name="terms" 
                           type="checkbox" 
                           {{ old('terms') ? 'checked' : '' }} 
                           required />
                    <div>
                        <label class="font-body-md text-body-md text-on-surface-variant" for="terms">
                            I agree to the 
                            <a href="#" class="text-primary hover:text-primary-container transition-colors font-medium">Terms of Service</a> 
                            and 
                            <a href="#" class="text-primary hover:text-primary-container transition-colors font-medium">Privacy Policy</a>
                        </label>
                        @error('terms')
                            <p class="font-label-sm text-label-sm text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </section>

        <!-- Sticky Action Bar -->
        <div class="fixed bottom-24 left-0 w-full z-40 bg-surface/90 backdrop-blur-md border-t border-outline-variant/20 px-4 py-4 md:px-lg" style="margin-bottom: 80px;">
            <div class="max-w-5xl mx-auto flex flex-col-reverse md:flex-row items-center justify-between gap-4">
                <button type="button" class="w-full md:w-auto px-6 h-[52px] font-label-md text-label-md text-on-surface hover:bg-surface-container rounded-lg transition-colors">
                    Save and finish later
                </button>
                <button type="submit" class="w-full md:w-auto px-10 h-[52px] bg-primary text-on-primary rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 hover:bg-primary/90 hover:scale-[0.98] transition-all shadow-sm">
                    Continue
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>
    </form>
</main>

@push('scripts')
<script>
    // File upload preview (optional enhancement)
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const parent = this.closest('.relative');
                const fileType = this.accept.includes('image') ? 'image' : 'file';
                
                if (fileType === 'image') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        
                        // Clear existing content and add image
                        const container = parent.querySelector('.flex');
                        if (container) {
                            container.innerHTML = '';
                            container.appendChild(img);
                        }
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    // For non-image files, show file name
                    const container = parent.querySelector('.flex');
                    if (container) {
                        const fileName = this.files[0].name;
                        container.innerHTML = `
                            <span class="material-symbols-outlined text-3xl text-primary mb-2">description</span>
                            <p class="font-body-md text-body-md text-on-surface font-medium text-center">${fileName}</p>
                            <p class="font-body-md text-body-md text-on-surface-variant text-sm text-center">Click to change file</p>
                        `;
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection