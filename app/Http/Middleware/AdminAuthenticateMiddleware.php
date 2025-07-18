<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || (!Auth::user()->isAdmin() && !session()->has('impersonate'))) {
            return redirect()->route('login');
        }

        if(Auth::user()->login_otp != 0) {
            return redirect()->route('admin.loginOTP');
        }
        
        return $next($request);
    }
}
