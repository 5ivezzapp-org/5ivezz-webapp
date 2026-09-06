<?php
// app/Http/Controllers/Organizer/AuthController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show organizer login form.
     */
    public function showLoginForm()
    {
        return view('organizer.auth.login');
    }

    public function showRegistrationForm()
    {
        $states = json_decode(file_get_contents(resource_path('data/nigeria-states.json')), true);
        return view('organizer.auth.register', compact('states'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:organizers,email',
            'phone' => 'required|string|max:20|unique:organizers,phone',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100', 
            'cac_document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'terms' => 'accepted',
        ]);

        // Handle CAC document upload
        $cacPath = null;
        if ($request->hasFile('cac_document')) {
            $cacPath = $request->file('cac_document')->store('organizer/cac-documents', 'public');
        }

        // Handle company logo upload
        $logoPath = null;
        if ($request->hasFile('company_logo')) {
            $logoPath = $request->file('company_logo')->store('organizer/logos', 'public');
        }

        $organizer = Organizer::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'company_name' => $validated['company_name'] ?? null,
            'state' => $validated['state'],
            'city' => $validated['city'], // Add this
            'cac_document' => $cacPath,
            'company_logo' => $logoPath,
            'terms_accepted' => true,
            'verification_status' => 'pending',
        ]);

        // Log the organizer in
        Auth::guard('organizer')->login($organizer);

        return redirect()->route('organizer.dashboard')
            ->with('success', 'Registration successful! Your account is pending verification.');
    }

    /**
     * Handle organizer login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        if (
            Auth::guard('organizer')->attempt(
                ['email' => $credentials['email'], 'password' => $credentials['password']],
                $credentials['remember'] ?? false
            )
        ) {
            $request->session()->regenerate();

            $organizer = Auth::guard('organizer')->user();

            // Check verification status
            if (!$organizer->isVerified()) {
                Auth::guard('organizer')->logout();
                return back()->withErrors([
                    'email' => 'Your account is pending verification. Please wait for admin approval.',
                ]);
            }

            return redirect()->intended(route('organizer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle organizer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('organizer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('organizer.login');
    }

    /**
     * Show organizer dashboard.
     */
    public function dashboard()
    {
        $organizer = Auth::guard('organizer')->user();
        return view('organizer.dashboard', compact('organizer'));
    }

    /**
     * Show organizer profile.
     */
    public function profile()
    {
        $organizer = Auth::guard('organizer')->user();
        return view('organizer.profile', compact('organizer'));
    }

    /**
     * Update organizer profile.
     */
    public function updateProfile(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:organizers,phone,' . $organizer->id,
            'company_name' => 'nullable|string|max:255',
            'state' => 'required|string|max:100',
        ]);

        $organizer->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update organizer password.
     */
    public function updatePassword(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $organizer->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $organizer->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update company logo.
     */
    public function updateLogo(Request $request)
    {
        $organizer = Auth::guard('organizer')->user();

        $validated = $request->validate([
            'company_logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Delete old logo if exists
        if ($organizer->company_logo) {
            Storage::disk('public')->delete($organizer->company_logo);
        }

        $path = $request->file('company_logo')->store('organizer/logos', 'public');
        $organizer->update(['company_logo' => $path]);

        return back()->with('success', 'Logo updated successfully!');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('organizer.auth.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:organizers,email']);

        $status = Password::broker('organizers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('organizer.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:organizers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::broker('organizers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($organizer, $password) {
                $organizer->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $organizer->save();

                event(new PasswordReset($organizer));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('organizer.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}