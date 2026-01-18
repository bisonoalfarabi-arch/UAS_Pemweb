<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->role !== 'admin') {
            // Aman: kalau route('home') belum ada, fallback ke '/'
            if (function_exists('route') && \Illuminate\Support\Facades\Route::has('home')) {
                return redirect()->route('home')
                    ->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses.');
            }

            return redirect('/')
                ->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses.');
        }

        return $next($request);
    }
}
