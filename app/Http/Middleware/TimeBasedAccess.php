<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeBasedAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentTime = now()->format('H:i');

        // Define the allowed time range (from 6:00 AM to 8:00 PM)
        $startTime = '06:00';
        $endTime = '20:00';

        // Check if the current time is within the allowed range
        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            // If the current time is within the allowed range, proceed with the request
            return $next($request);
        }
        else{
            return redirect(route('access'));
        }
    }
}
