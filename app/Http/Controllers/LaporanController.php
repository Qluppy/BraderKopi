<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPenjualanExport;

class LaporanController extends Controller
{
    // Menampilkan halaman laporan dengan grafik dan detail penjualan
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $periode = $request->get('periode', 'harian'); // Default 'harian'
        $tanggalSekarang = Carbon::now();
        $penjualans = [];

        if ($periode == 'harian') {
            $penjualans = Transaksi::whereDate('created_at', $tanggalSekarang->format('Y-m-d'))->get();
        } elseif ($periode == 'bulanan') {
            $penjualans = Transaksi::whereMonth('created_at', $tanggalSekarang->format('m'))
                                    ->whereYear('created_at', $tanggalSekarang->format('Y'))
                                    ->get();
        } elseif ($periode == 'tahunan') {
            $penjualans = Transaksi::whereYear('created_at', $tanggalSekarang->format('Y'))->get();
        }

        $label = [];
        $data = [];

        foreach ($penjualans as $penjualan) {
            $label[] = $penjualan->created_at->format('d-m-Y');
            $data[] = $penjualan->total_harga;
        }

        return view('laporan.index', [
            'penjualans' => $penjualans,
            'label' => $label,
            'data' => $data
        ]);
    }

    // Export laporan dalam format Excel
    public function export(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Dapatkan data penjualan berdasarkan periode
        $periode = $request->get('periode', 'harian');
        $tanggalSekarang = Carbon::now();

        if ($periode == 'harian') {
            $penjualans = Transaksi::whereDate('created_at', $tanggalSekarang->format('Y-m-d'))->get();
        } elseif ($periode == 'bulanan') {
            $penjualans = Transaksi::whereMonth('created_at', $tanggalSekarang->format('m'))
                                    ->whereYear('created_at', $tanggalSekarang->format('Y'))
                                    ->get();
        } elseif ($periode == 'tahunan') {
            $penjualans = Transaksi::whereYear('created_at', $tanggalSekarang->format('Y'))->get();
        }

        // Export data ke Excel
        return Excel::download(new LaporanPenjualanExport($penjualans), 'laporan_penjualan.xlsx');
    }
}
