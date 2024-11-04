<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Check if the user is authenticated and has the specified role
        if (Auth::check() && Auth::pegawai()->role === $role) {
            return $next($request);
        }

        // If not authorized, redirect or abort
        return redirect('/')->with('error', 'You do not have access to this resource.');
    }
}
