<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Student
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
        if(session()->has('STUDENT_ID') || session()->has('user_id')){
            return $next($request);
        }
        else if(session()->has('is_teacher'))
        {
            return redirect('/teacher/dashboard');
        }
        else{
            return redirect('/');
        }

    }
}
