<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Telemiddleware
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
    

        if (Auth::guard('telecaller')->check()) {
            // return redirect()->route('index');
            return $next($request);
        }

        return redirect()->route('frontend.login');
    

    }

   
}
