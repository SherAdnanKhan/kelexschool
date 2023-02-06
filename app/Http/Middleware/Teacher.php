<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Teacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(session()->has('EMP_ID') || session()->has('user_id') ){
            return $next($request);
        }
        else if(session()->has('is_student'))
        {
            return redirect('/teacher/dashboard');
        }
        else{
            return redirect('/');
        }

    }
}
