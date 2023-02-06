<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if(session()->has('user_id') && session()->has('CAMPUS_ID') !==0){
            return $next($request);
        }


        else if (session()->has('user_id') && session()->has('CAMPUS_ID') ==0)
        {
            return redirect()->route('superadmin');
        }
        else if(session()->has('is_student'))
        {
            return redirect('/student/dashboard');
        }
        else if(session()->has('is_teacher'))
        {
            return redirect('/teacher/dashboard');
        }
        else {
            return redirect('/');
        }


    }
}
