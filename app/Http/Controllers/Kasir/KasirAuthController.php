<?php
// KasirAuthController

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirAuthController extends Controller
{
    /**
     * Show the form for logging in the kasir.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('kasir.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'kasir') {
                $request->session()->regenerate();
                return redirect()->intended('/kasir/dashboard')->with('success', 'Welcome back, Kasir!');
            }
            
            Auth::logout();
            return back()->with('error', 'You do not have kasir access.');
        }

        return back()->with('error', 'The provided credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}