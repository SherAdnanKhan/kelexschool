<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class website
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     *
     * aneeskhan gamranigit a
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('campus_info')) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
