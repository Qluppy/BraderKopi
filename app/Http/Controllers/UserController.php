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

        $users = User::all();
        return view('users', compact('users'));
    }

    // Menampilkan form tambah user
    public function store(Request $request)
    {
        // Cek apakah pengguna adalah admin
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }
    
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'isAdmin' => 'required|boolean',
        ]);
    
        try {
            // Buat pengguna baru
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'isAdmin' => filter_var($request->isAdmin, FILTER_VALIDATE_BOOLEAN),
            ]);
    
            // Redirect ke halaman daftar pengguna dengan pesan sukses
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            // Jika gagal, kembalikan ke halaman create dengan pesan error
            return redirect()->route('users.create')->with('error', 'Failed to create user. Please try again.');
        }
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
    // Menampilkan form untuk mengedit user
    public function edit($id)
    {
        if (!$this->checkAdmin()) {
            return redirect('/dashboard')->with('error', 'You do not have access to this page.');
        }
    
        $user = User::findOrFail($id);
        return view('edit', compact('user'));  // Mengarah langsung ke 'resources/views/edit.blade.php'
    }  
    public function create()
{
    if (!$this->checkAdmin()) {
        return redirect('/dashboard')->with('error', 'You do not have access to this page.');
    }

    return view('create');
}      

}
