<?php
// app/Http/Middleware/OrganizerAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('organizer')->check()) {
            return redirect()->route('organizer.login');
        }

        $organizer = Auth::guard('organizer')->user();
        
        // Check if organizer is verified
        if (!$organizer->isVerified()) {
            Auth::guard('organizer')->logout();
            return redirect()->route('organizer.login')
                ->with('error', 'Your account is pending verification. Please wait for admin approval.');
        }

        return $next($request);
    }
}

