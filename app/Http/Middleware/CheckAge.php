<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAge
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->age <= 17) {
            return response('Maaf, umur Anda belum cukup untuk mengakses halaman ini.', 403);
        }
        return $next($request);
    }
}