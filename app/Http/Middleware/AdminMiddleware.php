<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Mengecek apakah user login sebagai admin (misal role-nya 'admin')
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirect ke dashboard biasa jika bukan admin
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses sebagai admin.');
    }
}
