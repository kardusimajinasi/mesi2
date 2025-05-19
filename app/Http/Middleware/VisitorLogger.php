<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class VisitorLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $today = now()->toDateString();

        $exists = DB::table('visitors')
            ->where('ip_address', $ipAddress)
            ->whereDate('visited_at', $today)
            ->exists();

        if (!$exists) {
            DB::table('visitors')->insert([
                'ip_address' => $ipAddress,
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
