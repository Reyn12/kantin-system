<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cara yang lebih bener untuk cek auth dan role
        if (!Auth::check() || Auth::user()->role !== 'kasir') {
            return redirect('/kasir/login');
        }

        return $next($request);
    }
}