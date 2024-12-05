<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Untuk Logging

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Log role for debugging
        if (Auth::check()) {
            Log::info('User Role:', ['role' => Auth::user()->role->nama_role]);
        }

        // Check if the user is authenticated and has the specified role
        if (Auth::check() && Auth::user()->role->nama_role === $role) {
            return $next($request);
        }

       // If not authorized, redirect or abort
       return redirect('/dashboard')->with('error', 'You do not have access to this resource.');
    }
}