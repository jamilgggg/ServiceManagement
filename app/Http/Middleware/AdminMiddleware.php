<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->idacctype == 1) {
            return $next($request);
        }

        // Redirect if not authorized
        return redirect()->route('dashboard')->with('error', 'Access Denied.');
    }
}
