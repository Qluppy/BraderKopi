<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\MasterBahan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Dashboard
        $totalProduk = Produk::count();
        $totalBahan = MasterBahan::count();
        $transaksiHariIni = Transaksi::whereDate('tanggal_transaksi', today())->count();

        // Menggunakan relasi yang benar untuk produk terlaris
        $produkTerlaris = Produk::withCount('detailTransaksi') // Hitung jumlah transaksi
            ->get() // Ambil semua data terlebih dahulu
            ->filter(function ($produk) {
                return $produk->detail_transaksi_count > 0; // Saring produk yang pernah terjual
            })
            ->sortByDesc('detail_transaksi_count') // Urutkan berdasarkan jumlah transaksi
            ->take(5); // Ambil 5 produk terlaris

        // Menampilkan bahan yang stoknya menipis
        $stokMenipis = Stok::where('jumlah_stok', '<=', 10)->get();

        // Return view dengan data
        return view('dashboard', compact(
            'totalProduk',
            'totalBahan',
            'transaksiHariIni',
            'produkTerlaris',
            'stokMenipis',
        ));
    }
}
