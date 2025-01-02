<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Menampilkan formulir registrasi
    public function showRegistrationForm()
    {
        return view('register');  
        // Pastikan Anda memiliki view ini di resources/views/register.blade.php
    }

    // Proses registrasi pengguna baru
    public function register(Request $request)
    {
        // Memvalidasi data input menggunakan fungsi validator di bawah
        $this->validator($request->all())->validate();

        // Membuat pengguna baru dengan fungsi create di bawah
        $user = $this->create($request->all());

        // Login otomatis setelah pengguna berhasil registrasi
        auth()->login($user);

        // Mengarahkan pengguna ke halaman dashboard
        return redirect()->route('login'); 
        // Sesuaikan route dashboard Anda di file web.php
    }

    // Validasi data input registrasi
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'], // Nama wajib diisi, berupa string, maksimal 255 karakter
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
            // Email wajib diisi, format email, maksimal 255 karakter, dan harus unik di tabel users
            'username' => ['required', 'string', 'max:255', 'unique:users'], 
            // Username wajib diisi, berupa string, maksimal 255 karakter, dan harus unik
            'password' => ['required', 'string', 'min:6', 'confirmed'], 
            // Password wajib diisi, berupa string, minimal 6 karakter, dan harus cocok dengan password_confirmation
        ]);
    }

    // Membuat pengguna baru di database
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'], // Nama pengguna
            'username' => $data['username'], // Username pengguna
            'email' => $data['email'], // Email pengguna
            'password' => bcrypt($data['password']), 
            // Password dienkripsi menggunakan bcrypt untuk keamanan
        ]);
    }

    // Menampilkan formulir login
    public function showLoginForm()
    {
        return view('login'); 
        // Pastikan Anda memiliki view ini di resources/views/login.blade.php
    }

    // Proses login pengguna
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username' => 'required|string', // Username wajib diisi dan berupa string
            'password' => 'required|string', // Password wajib diisi dan berupa string
        ]);

        // Mengambil hanya username dan password dari input
        $credentials = $request->only('username', 'password');

        // Mencari pengguna berdasarkan email atau username
        $user = User::where('email', $request->username)
            ->orWhere('username', $request->username)
            ->first();

        // Jika pengguna ditemukan dan data login sesuai
        if ($user && Auth::attempt(['id' => $user->id, 'password' => $request->password])) {
            return redirect()->intended('/dashboard'); 
            // Mengarahkan ke halaman dashboard atau halaman yang diminta sebelumnya
        }

        // Jika login gagal, kembalikan dengan pesan error
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    // Menampilkan profil pengguna yang sedang login
    public function profile()
    {
        $user = Auth::user(); 
        // Mendapatkan data pengguna yang sedang login
        return view('profile', compact('user')); 
        // Mengirimkan data pengguna ke view profile/index.blade.php
    }

    // Logout pengguna
    public function logout()
    {
        Auth::logout(); 
        // Mengakhiri sesi login
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
        // Mengarahkan ke halaman login dengan pesan sukses
    }
}
