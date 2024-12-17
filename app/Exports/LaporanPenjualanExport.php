<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPenjualanExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $rekapProduk;

    public function __construct($rekapProduk)
    {
        $this->rekapProduk = $rekapProduk;
    }

    // Mengambil data untuk diekspor ke Excel
    public function collection()
    {
        return collect($this->rekapProduk)->map(function ($produk) {
            return [
                'tanggal' => $produk->tanggal_transaksi,   // Tanggal transaksi
                'produk' => $produk->nama_produk,         // Nama produk
                'jumlah_terjual' => $produk->total_terjual, // Total terjual
                'total_pendapatan' => $produk->total_pendapatan, // Total pendapatan
            ];
        });
    }

    // Header untuk file Excel
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Produk',
            'Jumlah Terjual',
            'Total Pendapatan',
        ];
    }

    // Menambahkan gaya ke file Excel
    public function styles(Worksheet $sheet)
    {
        return [
            // Gaya untuk header (baris pertama)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4CAF50'],
                ],
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
            ],
            // Gaya untuk seluruh tabel
            'A' => ['alignment' => ['horizontal' => 'center']], // Kolom Tanggal
            'B' => ['alignment' => ['horizontal' => 'left']],   // Kolom Nama Produk
            'C' => ['alignment' => ['horizontal' => 'center']], // Kolom Jumlah Terjual
            'D' => ['alignment' => ['horizontal' => 'right']],  // Kolom Total Pendapatan
        ];
    }

    // Menentukan lebar kolom
    public function columnWidths(): array
    {
        return [
            'A' => 15, // Kolom Tanggal
            'B' => 30, // Kolom Nama Produk
            'C' => 20, // Kolom Jumlah Terjual
            'D' => 20, // Kolom Total Pendapatan
        ];
    }
}
