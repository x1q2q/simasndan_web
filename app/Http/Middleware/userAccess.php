<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class userAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if ($userType == 'admin') {
           if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->is_pengasuh == '0'){
               return $next($request);
           }
           return redirect('/login');
        }
       if ($userType == 'pengasuh') {
            if(Auth::guard('admin')->user() && Auth::guard('admin')->user()->is_pengasuh == '1'){
                return $next($request);
            }
            return redirect('/login');
        }
        if ($userType == 'guru') {
            if(Auth::guard('guru')){
                return $next($request);
            }
            return redirect('/login');
        }
        if ($userType == 'pengurus') {
            if(Auth::guard('santri')->user() && Auth::guard('santri')->user()->is_pengurus == '1'){
                return $next($request);
            }
            return redirect('/login');
        }
    }
}
