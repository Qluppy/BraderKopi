<?php

namespace App\Http\Controllers;

use Spatie\Dropbox\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DropboxTokenProvider;
use App\Exports\LaporanPenjualanExport;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        // Filter berdasarkan periode
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        // Ambil parameter pagination
        $perPage = $request->query('per_page', 5); // Default 5 per halaman

        // Ambil data rekapitulasi per produk dengan pagination
        $rekapProduk = DB::table('detailtransaksi')
            ->join('transaksi', 'detailtransaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'detailtransaksi.produk_id', '=', 'produk.id')
            ->select(
                'transaksi.tanggal_transaksi', // Tambahkan kolom tanggal transaksi
                'detailtransaksi.produk_id',
                'produk.nama_produk',
                'produk.harga_produk', // Harga satuan
                DB::raw('SUM(detailtransaksi.jumlah) AS total_terjual'),
                DB::raw('SUM(detailtransaksi.jumlah * produk.harga_produk) AS total_pendapatan')
            )
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy(
                'transaksi.tanggal_transaksi',
                'detailtransaksi.produk_id',
                'produk.nama_produk',
                'produk.harga_produk'
            )
            ->orderByDesc('transaksi.tanggal_transaksi') // Urutkan berdasarkan tanggal transaksi terbaru
            ->paginate($perPage)
            ->withQueryString(); // Menjaga query string untuk start_date, end_date, dan per_page

        $totalPenjualan = DB::table('transaksi')
            ->sum('total_harga');

        return view('laporan.index', compact('rekapProduk', 'totalPenjualan', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        // Filter periode
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        // Ambil data rekapitulasi per produk
        $rekapProduk = DB::table('detailtransaksi')
            ->join('transaksi', 'detailtransaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'detailtransaksi.produk_id', '=', 'produk.id')
            ->select(
                'transaksi.tanggal_transaksi', // Tambahkan kolom tanggal transaksi
                'produk.nama_produk',
                'produk.harga_produk',
                DB::raw('SUM(detailtransaksi.jumlah) AS total_terjual'),
                DB::raw('SUM(detailtransaksi.jumlah * produk.harga_produk) AS total_pendapatan')
            )
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy(
                'transaksi.tanggal_transaksi',
                'produk.nama_produk',
                'produk.harga_produk'
            )
            ->orderByDesc('transaksi.tanggal_transaksi')
            ->get();

        // Nama file export
        $fileName = 'laporan_penjualan_' . $startDate . '_to_' . $endDate . '.xlsx';

        // Export menggunakan LaporanPenjualanExport
        return Excel::download(new LaporanPenjualanExport($rekapProduk), $fileName);
    }
}
