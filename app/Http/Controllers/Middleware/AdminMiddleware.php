<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman admin.');
        }

        // Bukan admin
        if (Auth::user()->role !== 'admin') {
            // Pakai URL langsung biar aman walau route name "home" tidak ada
            return redirect('/')
                ->with('error', 'Akses ditolak. Hanya administrator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
