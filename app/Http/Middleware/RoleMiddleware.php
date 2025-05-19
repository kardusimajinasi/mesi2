<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        Log::info('Middleware Role is running...');
        Log::info('Required role: ' . $role);
        Log::info('User role: ' . (Auth::check() ? Auth::user()->level->level : 'Guest'));

        if (Auth::check()) {
            Log::info('User role: ' . Auth::user()->level->level);
        }

        if (Auth::check() && strtolower(Auth::user()->level->level) === strtolower($role)) {
            return $next($request);
        }

        Log::error('Unauthorized access detected.');
        // Jika tidak memiliki akses, kembalikan ke halaman login
        return redirect('/login')->withErrors(['error' => 'Unauthorized']);
    }
}
