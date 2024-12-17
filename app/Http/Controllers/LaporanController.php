<?php

namespace App\Http\Controllers;

use Spatie\Dropbox\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\DropboxTokenProvider;
use App\Exports\LaporanPenjualanExport;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan periode
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        // Ambil data rekapitulasi per produk
        $rekapProduk = DB::table('detailtransaksi')
            ->join('transaksi', 'detailtransaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'detailtransaksi.produk_id', '=', 'produk.id')
            ->select(
                'detailtransaksi.produk_id',
                'produk.nama_produk',
                DB::raw('SUM(detailtransaksi.jumlah) AS total_terjual'),
                DB::raw('SUM(detailtransaksi.jumlah * produk.harga_produk) AS total_pendapatan')
            )
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('detailtransaksi.produk_id', 'produk.nama_produk')
            ->orderByDesc('total_terjual')
            ->get();

        // Total Penjualan Seluruhnya
        $totalPenjualan = $rekapProduk->sum('total_pendapatan');

        return view('laporan.index', compact('rekapProduk', 'totalPenjualan', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        // Filter periode
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->endOfMonth()->toDateString());

        // Ambil data rekapitulasi per produk
        $rekapProduk = DB::table('detailtransaksi')
            ->join('transaksi', 'detailtransaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'detailtransaksi.produk_id', '=', 'produk.id')
            ->select(
                'transaksi.tanggal_transaksi',
                'produk.nama_produk',
                DB::raw('SUM(detailtransaksi.jumlah) AS total_terjual'),
                DB::raw('SUM(transaksi.total_harga) AS total_pendapatan')
            )
            ->whereBetween('transaksi.tanggal_transaksi', [$startDate, $endDate])
            ->groupBy('transaksi.tanggal_transaksi', 'produk.nama_produk')
            ->orderByDesc('total_terjual')
            ->get();

        // Nama file export
        $fileName = 'laporan_penjualan_' . $startDate . '_to_' . $endDate . '.xlsx';

        // Export menggunakan LaporanPenjualanExport
        return Excel::download(new LaporanPenjualanExport($rekapProduk), $fileName);
    }
}
