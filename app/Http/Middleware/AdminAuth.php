<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store the intended URL for redirect after login
            session(['url.intended' => $request->url()]);

            // Redirect to login with a message
            return redirect()
                ->route('login.form')
                ->with('info', 'Silakan login terlebih dahulu untuk mengakses panel admin.');
        }

        return $next($request);
    }
}
