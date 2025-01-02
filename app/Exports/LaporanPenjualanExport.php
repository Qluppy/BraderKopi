<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
                'produk' => $produk->nama_produk,          // Nama produk
                'harga_satuan' => $produk->harga_produk,   // Harga satuan produk
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
            'Harga Satuan',
            'Jumlah Terjual',
            'Total Pendapatan',
        ];
    }

    // Menambahkan gaya ke file Excel
    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow(); // Mendapatkan baris terakhir

        // Gaya untuk header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4CAF50'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Gaya untuk seluruh tabel (termasuk border)
        $sheet->getStyle("A1:E$lastRow")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Gaya untuk kolom tertentu
        $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C2:E' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    }

    // Menentukan lebar kolom
    public function columnWidths(): array
    {
        return [
            'A' => 20, // Kolom Tanggal
            'B' => 30, // Kolom Nama Produk
            'C' => 20, // Kolom Harga Satuan
            'D' => 20, // Kolom Jumlah Terjual
            'E' => 20, // Kolom Total Pendapatan
        ];
    }
}
