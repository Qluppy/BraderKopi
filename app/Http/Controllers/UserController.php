<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Fungsi untuk memeriksa apakah pengguna adalah admin
    protected function checkAdmin()
    {
        // Jika pengguna belum login atau bukan admin, kembalikan false
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return false;
        }
        return true;
    }

    // Menampilkan daftar semua pengguna
    public function index()
    {
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }

        $users = User::all(); // Ambil semua data user
        return view('users', compact('users'));
    }

    // Menyimpan pengguna baru ke database
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }

        // Validasi data input
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'isAdmin' => 'required|boolean',
        ]);

        // Membuat pengguna baru
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isAdmin' => filter_var($request->isAdmin, FILTER_VALIDATE_BOOLEAN),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'isAdmin' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'isAdmin' => filter_var($request->isAdmin, FILTER_VALIDATE_BOOLEAN),
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Menghapus pengguna
    public function destroy(User $user)
    {
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
