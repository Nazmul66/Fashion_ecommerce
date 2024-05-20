<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if( !empty(Auth::check()) ){
            if( Auth::user()->role === 1 ){
                return $next($request);
            }
            else if(Auth::user()->role === 3 ){
                return $next($request);
            }
            else if(Auth::user()->role === 2 ){
                return redirect()->route('home');
            }
       }
       else{
           return redirect()->route('/login');
       }
    }
}
