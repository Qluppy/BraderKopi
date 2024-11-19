<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Setting;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Ambil pengaturan toko (misalnya dari tabel settings)
        $setting = Setting::first(); // Ambil pengaturan pertama atau sesuaikan dengan logika Anda
        $metode_pembayaran = $setting ? explode(',', $setting->metode_pembayaran) : []; // Cek jika setting tidak null
        $users = Akun::all(); // Ambil semua pengguna

        return view('pengaturan.index', compact('setting', 'metode_pembayaran', 'users')); // Gunakan 'setting' sebagai variabel
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'alamat_toko' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
            'metode_pembayaran' => 'array'
        ]);

        // Update pengaturan toko
        $setting = Setting::first();
        if ($setting) { // Pastikan setting ada
            $setting->nama_toko = $request->nama_toko;
            $setting->alamat_toko = $request->alamat_toko;
            $setting->nomor_telepon = $request->nomor_telepon;
            $setting->metode_pembayaran = implode(',', $request->metode_pembayaran);
            $setting->save();
        }

        return redirect()->route('pengaturan.index')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
