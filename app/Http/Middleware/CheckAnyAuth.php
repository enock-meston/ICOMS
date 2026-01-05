<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAnyAuth
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the user is authenticated via either
     * the 'web' guard (Admin User) or 'cooperative' guard (Co-operative User).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated via either guard
        if (Auth::guard('web')->check() || Auth::guard('cooperative')->check()) {
            return $next($request);
        }

        // Redirect to login if not authenticated
        return redirect()->route('login')->with('error', 'Please login to access this page.');
    }
}
