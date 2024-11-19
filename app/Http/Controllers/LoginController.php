<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Login berhasil
            return redirect()->intended('/dashboard'); // Ganti dengan route dashboard Anda
        }

        // Login gagal
        return back()->with('error', 'Username atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login'); // Ganti dengan route login Anda
    }
}
