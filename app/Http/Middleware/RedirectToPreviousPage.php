<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectToPreviousPage
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Pastikan URL sebelumnya disimpan
        if (!$request->is('login', 'logout', 'register') && $request->method() === 'GET') {
            Session::put('url.intended', $request->fullUrl());
        }

        return $next($request);
    }

}
