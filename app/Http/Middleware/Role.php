<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::user() || !in_array(Auth::user()->role, $roles)) {
            if (Auth::user()) {
                if (Auth::user()->role === 'teknisi') {
                    return redirect('/teknisi/dashboard');
                } elseif (Auth::user()->role === 'unit_lingkungan') {
                    return redirect('/dashboard');
                }
                // Tambahkan else untuk role lain jika ada
            }
            return redirect('/login');
        }
        return $next($request);
    }
}
