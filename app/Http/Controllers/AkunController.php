<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan model User yang benar digunakan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file view ini ada di resources/views/auth/login.blade.php
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input login
        $incomingFields = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek kredensial login
        if (Auth::attempt(['username' => $incomingFields['username'], 'password' => $incomingFields['password']])) {
            // Regenerate session setelah login
            $request->session()->regenerate();

            // Redirect ke dashboard
            return redirect()->route('dashboard.index');
        }

        // Jika login gagal
        return back()->withErrors([
            'loginError' => 'Username atau password salah.',
        ])->withInput($request->except('password'));
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Fungsi register
    public function registrasi(Request $request)
    {
        // Validasi input
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:10', 'unique:users,username'], // Tabel default untuk User adalah 'users'
            'password' => ['required', 'min:4', 'max:8'],
            'role' => ['required', 'in:kasir,admin'], // Pastikan hanya 'kasir' atau 'admin'
        ]);

        // Enkripsi password
        $incomingFields['password'] = bcrypt($incomingFields['password']);

        // Buat user baru
        $user = User::create($incomingFields);

        if ($user) {
            // Setelah registrasi, arahkan ke halaman login dengan pesan sukses
            return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
        }

        // Jika registrasi gagal
        return back()->withErrors(['registrasiError' => 'Gagal melakukan registrasi.'])->withInput();
    }
        // Menampilkan daftar akun
        public function index()
        {
            $users = User::all(); // Ambil semua data akun
            return view('akun', compact('users')); // Ubah view ke admin.akun.akun
        }
    
        // Menampilkan form edit akun
        public function edit($id)
{
    $user = User::findOrFail($id); // Ambil data akun berdasarkan ID
    return view('edit', compact('user')); // Gunakan edit.blade.php
}

    
        // Memperbarui data akun
        public function update(Request $request, $id)
        {
            $incomingFields = $request->validate([
                'username' => ['required', 'min:3', 'max:10', 'unique:users,username,' . $id],
                'role' => ['required', 'in:kasir,admin'],
            ]);
    
            $user = User::findOrFail($id);
            $user->update($incomingFields);
    
            return redirect()->route('akun.index')->with('success', 'Akun berhasil diperbarui.');
        }
    
        // Menghapus akun
        public function destroy($id)
        {
            $user = User::findOrFail($id);
            $user->delete();
    
            return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
        }
    }
    
