<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard')
                ->with('info', 'Anda adalah admin. Gunakan dashboard admin.');
        }

        return $next($request);
    }
}
