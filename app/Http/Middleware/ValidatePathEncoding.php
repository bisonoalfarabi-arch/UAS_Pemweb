<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidatePathEncoding
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Validasi encoding path di sini jika diperlukan
        // Untuk sekarang, langsung lanjutkan request
        return $next($request);
    }
}