<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Admin
                if ($user && $user->role === 'admin') {
                    if (\Illuminate\Support\Facades\Route::has('admin.dashboard')) {
                        return redirect()->route('admin.dashboard');
                    }
                    return redirect('/admin/dashboard');
                }

                // User biasa
                if (\Illuminate\Support\Facades\Route::has('dashboard')) {
                    return redirect()->route('dashboard');
                }
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
