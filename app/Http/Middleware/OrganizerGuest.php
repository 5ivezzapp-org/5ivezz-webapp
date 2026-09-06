<?php
// app/Http/Middleware/OrganizerGuest.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerGuest
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('organizer')->check()) {
            return redirect()->route('organizer.dashboard');
        }

        return $next($request);
    }
}