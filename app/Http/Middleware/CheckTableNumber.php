<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTableNumber
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('table_number')) {
            return redirect()->route('order.index')->with('error', 'Silakan scan QR atau masukkan nomor meja dulu ya!');
        }

        return $next($request);
    }
}