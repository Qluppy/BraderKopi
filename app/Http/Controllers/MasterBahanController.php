<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\MasterBahan;
use Illuminate\Http\Request;

class MasterBahanController extends Controller
{
    public function index()
    {
        // Ambil semua data bahan dari master_bahan
        $bahan = MasterBahan::all();

        // Return view dengan data bahan
        return view('masterbahan.index', compact('bahan'));
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'deskripsi_bahan' => 'nullable|string',
            'jumlah_stok' => 'required|numeric|min:0'
        ]);

        // Buat entri baru di tabel master_bahan
        $bahan = MasterBahan::create([
            'nama_bahan' => $validatedData['nama_bahan'],
            'satuan' => $validatedData['satuan'],
            'deskripsi_bahan' => $validatedData['deskripsi_bahan'],
        ]);

        // Tambahkan stok ke tabel stok
        Stok::create([
            'idbahan' => $bahan->id,
            'jumlah_stok' => $validatedData['jumlah_stok'],
        ]);

        // Redirect ke halaman master bahan dengan pesan sukses
        return redirect()->route('stok.index')->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Ambil data bahan untuk diedit
        $bahan = MasterBahan::findOrFail($id);

        // Return view edit dengan data bahan
        return view('stok.index', compact('bahan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'deskripsi_bahan' => 'nullable|string',
            'jumlah_stok' => 'required|numeric|min:0',
        ]);

        // Update data di master_bahan
        $bahan = MasterBahan::findOrFail($id);
        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->satuan = $request->satuan;
        $bahan->deskripsi_bahan = $request->deskripsi_bahan;
        $bahan->save();

        // Update jumlah stok di tabel stok
        $stok = Stok::where('idbahan', $id)->first();
        if ($stok) {
            $stok->jumlah_stok = $request->jumlah_stok; // Anda bisa menggunakan logika tambahan di sini jika perlu
            $stok->save();
        }

        return redirect()->route('stok.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus bahan berdasarkan ID
        MasterBahan::destroy($id);

        // Redirect kembali ke halaman master bahan dengan pesan sukses
        return redirect()->route('stok.index')->with('success', 'Bahan berhasil dihapus.');
    }
}
