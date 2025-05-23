<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Session::has('authenticated') && Session::get('authenticated') === true) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($request->username === 'admin' && $request->password === 'password') {
            Session::put('authenticated', true);
            Session::put('user', [
                'name' => 'Administrator',
                'username' => $request->username,
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout()
    {
        Session::forget('authenticated');
        Session::forget('user');
        
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }
}
