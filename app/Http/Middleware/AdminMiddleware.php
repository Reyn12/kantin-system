<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cara yang lebih bener untuk cek auth dan role
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}