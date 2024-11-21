<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleRedirectException
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
        try {
            // Redirect authenticated users accessing the base URL to /admin
            // if (Auth::check() && $request->path() === '/') {
            //     return redirect('/admin');
            // }
            
            return $next($request);
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            // return Auth::check() ? redirect('/admin') : redirect('/');
            return Auth::check() ? redirect('/admin') : redirect('/');
        }
    }
}
