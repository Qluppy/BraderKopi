<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanPenjualanExport implements FromCollection
{
    protected $transaksis;

    public function __construct($transaksis)
    {
        $this->transaksis = $transaksis;
    }

    // Mengambil data transaksi untuk diexport
    public function collection()
    {
        // Map data transaksi yang akan di-export ke Excel
        return $this->transaksis->map(function($transaksi) {
            return [
                $transaksi->created_at->format('d-m-Y'), // Tanggal
                $transaksi->produk->nama_produk,        // Nama Produk (Relasi dengan produk)
                $transaksi->jumlah,                     // Jumlah terjual
                $transaksi->total_harga,                // Total Harga
            ];
        });
    }

    // Menambahkan header ke file Excel
    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Jumlah Terjual',
            'Total Harga',
        ];
    }
}
