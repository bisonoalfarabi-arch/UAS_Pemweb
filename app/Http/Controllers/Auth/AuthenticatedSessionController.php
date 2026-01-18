<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard');
}
