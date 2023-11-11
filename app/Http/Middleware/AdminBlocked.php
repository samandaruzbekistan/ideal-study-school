<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBlocked
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
        $timestamp = DB::table('status_system')->where('id',1)->first();

        if (Carbon::now() > Carbon::parse($timestamp->close_timestamp)) {
            // The current time is greater than the stored timestamp
            // You can skip the route or perform a specific action here
            return $next($request);
        }
        else{
            return redirect(route('access'));
        }
    }
}
