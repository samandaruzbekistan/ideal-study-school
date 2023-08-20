<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CombinedAuth
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
        if (session()->has('admin') || session()->has('teacher') || session()->has('cashier')){
            return $next($request);
        }
        else{
            return redirect(route('admin.login'));
        }
    }
}
