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
        // Mengambil semua produk untuk ditampilkan di halaman transaksi
        $produks = Produk::with('bahan')->get(); // Memuat relasi bahan
        return view('transaksi.index', compact('produks'));
    }

    public function store(Request $request)
{
    // Validasi input dari form transaksi
    $request->validate([
        'nama_pembeli' => 'required|string',
        'produk_id' => 'required|array', // Mengharuskan produk_id berbentuk array
        'jumlah' => 'required|array', // Mengharuskan jumlah berbentuk array
        'metode_pembayaran' => 'required|string',
    ]);

    // Mengambil data produk yang dipesan
    $produkIds = $request->input('produk_id');
    $jumlahs = $request->input('jumlah');
    $totalHarga = 0;

    // Memeriksa ketersediaan bahan untuk setiap produk
    foreach ($produkIds as $index => $produkId) {
        $produk = Produk::with('bahan')->find($produkId);
        $jumlah = $jumlahs[$index];

        // Memeriksa setiap bahan yang dibutuhkan untuk produk
        foreach ($produk->bahan as $bahan) {
            $stok = Stok::where('idbahan', $bahan->id)->first();

            // Cek apakah stok ditemukan
            if (!$stok) {
                return redirect()->route('notifikasi.stok')->with('error', 'Stok bahan untuk "' . $bahan->nama_bahan . '" tidak ditemukan.');
            }

            // Jika stok bahan tidak cukup
            if ($stok->jumlah_stok < $bahan->pivot->jumlah_bahan * $jumlah) {
                return redirect()->route('notifikasi.stok')->with('error', 'Stok bahan untuk "' . $bahan->nama_bahan . '" tidak mencukupi.');
            }
        }

        // Jika semua bahan tersedia, hitung total harga
        $totalHarga += $produk->harga_produk * $jumlah;

        // Kurangi stok bahan yang digunakan
        foreach ($produk->bahan as $bahan) {
            $stok = Stok::where('idbahan', $bahan->id)->first();
            $stok->jumlah_stok -= $bahan->pivot->jumlah_bahan * $jumlah; // Kurangi stok dengan benar
            $stok->save();
        }
    }

    // Simpan transaksi
    $transaksi = new Transaksi();
    $transaksi->nama_pembeli = $request->input('nama_pembeli');
    $transaksi->total_harga = $totalHarga;
    $transaksi->metode_pembayaran = $request->input('metode_pembayaran');
    $transaksi->idakun = Auth::id(); // Mengaitkan transaksi dengan pengguna yang login
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

    // Redirect atau tampilkan pesan sukses
    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil!');
}
}
