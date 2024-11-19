<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input registrasi
        $request->validate([
            'username' => 'required|unique:akun,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,kasir',
        ]);

        // Buat akun baru
        Akun::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Akun berhasil dibuat!');
    }

    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Proses login
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Berhasil login!');
        }

        return redirect()->back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        // Logout pengguna
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
