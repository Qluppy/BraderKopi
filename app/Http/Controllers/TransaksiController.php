<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil semua produk untuk halaman transaksi
        $produks = Produk::with('bahan')->get(); // Memuat relasi bahan
        return view('transaksi.index', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_pembeli' => 'required|string',
            'produk_id' => 'required|array', 
            'jumlah' => 'required|array',
            'metode_pembayaran' => 'required|string',
        ]);

        $produkIds = $request->input('produk_id');
        $jumlahs = $request->input('jumlah');
        $totalHarga = 0;

        // Cek stok dan hitung total harga
        foreach ($produkIds as $index => $produkId) {
            $produk = Produk::with('bahan')->find($produkId);
            $jumlah = $jumlahs[$index];

            foreach ($produk->bahan as $bahan) {
                $stok = Stok::where('idbahan', $bahan->id)->first();

                if (!$stok || $stok->jumlah_stok < $bahan->pivot->jumlah_bahan * $jumlah) {
                    return redirect()->route('notifikasi.stok')->with(
                        'error', 
                        'Stok bahan untuk "' . $bahan->nama_bahan . '" tidak mencukupi.'
                    );
                }
            }

            $totalHarga += $produk->harga_produk * $jumlah;

            // Kurangi stok bahan
            foreach ($produk->bahan as $bahan) {
                $stok = Stok::where('idbahan', $bahan->id)->first();
                $stok->jumlah_stok -= $bahan->pivot->jumlah_bahan * $jumlah;
                $stok->save();
            }
        }

        // Simpan transaksi
        $transaksi = new Transaksi();
        $transaksi->nama_pembeli = $request->input('nama_pembeli');
        $transaksi->total_harga = $totalHarga;
        $transaksi->metode_pembayaran = $request->input('metode_pembayaran');
        $transaksi->akun = Auth::id(); // ID pengguna yang login
        $transaksi->save();

        // Simpan detail transaksi
        foreach ($produkIds as $index => $produkId) {
            $jumlah = $jumlahs[$index];
            $detailTransaksi = new DetailTransaksi();
            $detailTransaksi->idtransaksi = $transaksi->id;
            $detailTransaksi->idproduk = $produkId;
            $detailTransaksi->jumlah_produk = $jumlah;
            $detailTransaksi->harga_produk = Produk::find($produkId)->harga_produk;
            $detailTransaksi->save();
        }

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil!');
    }
}
