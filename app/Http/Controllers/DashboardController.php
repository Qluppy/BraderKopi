<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\MasterBahan;
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
        $produkTerlaris = Produk::withCount('detailTransaksi') // Pastikan nama relasi sesuai
                            ->orderBy('detail_transaksi_count', 'desc')
                            ->take(5)
                            ->get();

        // Menampilkan bahan yang stoknya menipis
        $stokMenipis = MasterBahan::where('jumlah_stok', '<=', 10)->get();

        // Return view dengan data
        return view('dashboard.index', compact('totalProduk', 'totalBahan', 'transaksiHariIni', 'produkTerlaris', 'stokMenipis'));
    }
}
