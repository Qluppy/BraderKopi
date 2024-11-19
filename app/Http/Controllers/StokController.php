<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\MasterBahan;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Ambil semua data bahan dan stok dari tabel stok
        $stok = Stok::with('masterBahan')->get(); // Mengambil stok beserta data master_bahan terkait

        // Return view dengan data stok
        return view('stok.index', compact('stok'));
    }

    public function tambahStok(Request $request)
{
    // Validasi data yang masuk
    $validatedData = $request->validate([
        'bahan_id' => 'required|exists:master_bahan,id',
        'jumlah_stok' => 'required|numeric|min:1',
        'satuan' => 'required|string' // Validasi satuan
    ]);

    // Cari bahan yang dipilih
    $bahan = MasterBahan::find($validatedData['bahan_id']);

    // Konversi jumlah stok berdasarkan satuan
    if ($validatedData['satuan'] == 'gram') {
        $jumlahDalamKg = $validatedData['jumlah_stok'] / 1000; // Konversi gram ke kilogram
    } elseif ($validatedData['satuan'] == 'mililiter') {
        $jumlahDalamL = $validatedData['jumlah_stok'] / 1000; // Konversi mililiter ke liter
    } elseif ($validatedData['satuan'] == 'liter') {
        $jumlahDalamL = $validatedData['jumlah_stok']; // Jika satuannya liter
    } else {
        $jumlahDalamKg = $validatedData['jumlah_stok']; // Jika satuannya kilogram
    }

    // Tambahkan stok ke stok yang ada
    $stok = Stok::where('idbahan', $validatedData['bahan_id'])->first();
    if ($stok) {
        if (in_array($validatedData['satuan'], ['gram', 'kilogram'])) {
            $stok->jumlah_stok += $jumlahDalamKg; // Update stok jika satuannya dalam kg
        } elseif (in_array($validatedData['satuan'], ['mililiter', 'liter'])) {
            $stok->jumlah_stok += $jumlahDalamL; // Update stok jika satuannya dalam liter
        }
        $stok->save();
    } else {
        Stok::create([
            'idbahan' => $validatedData['bahan_id'],
            'jumlah_stok' => in_array($validatedData['satuan'], ['gram', 'kilogram']) ? $jumlahDalamKg : $jumlahDalamL
        ]);
    }

    // Redirect kembali ke halaman stok dengan pesan sukses
    return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
}
}
