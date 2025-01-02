<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;

class SAWController extends Controller
{
    public function calculate(Request $request)
    {
        Log::info('Memulai perhitungan SAW.');

        // Mendapatkan bulan dan tahun dari request atau default ke saat ini
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Mengambil data transaksi untuk bulan dan tahun yang dipilih
        $transactions = Transaksi::whereYear('tanggal_transaksi', $tahun)
            ->whereMonth('tanggal_transaksi', $bulan)
            ->with('detailTransaksi.produk.produkBahan.masterBahan')
            ->get();

        $groupedAlternatives = []; // Untuk mengelompokkan produk
        foreach ($transactions as $transaction) {
            foreach ($transaction->detailTransaksi as $detail) {
                $produk = $detail->produk;

                $namaProduk = $produk->nama_produk ?? "Produk Tidak Diketahui";
                $hargaProduk = $produk->harga_produk ?? 0;
                $terjual = $detail->jumlah ?? 0;

                // Mendapatkan jumlah biji kopi dari relasi produk dan bahan
                $bijiKopi = $produk->produkBahan
                    ->where('masterBahan.nama_bahan', 'Biji Kopi')
                    ->sum('jumlah_bahan') ?? 0;

                // Jika produk sudah ada di grup, akumulasikan data
                if (isset($groupedAlternatives[$namaProduk])) {
                    $groupedAlternatives[$namaProduk]['terjual'] += $terjual;
                } else {
                    // Tambahkan produk ke grup
                    $groupedAlternatives[$namaProduk] = [
                        'harga_produk' => $hargaProduk,
                        'biji_kopi' => $bijiKopi,
                        'terjual' => $terjual,
                    ];
                }
            }
        }

        // Konversi hasil grup ke dalam array biasa
        $alternatives = [];
        $alternativeLabels = [];
        foreach ($groupedAlternatives as $namaProduk => $data) {
            $alternatives[] = $data;
            $alternativeLabels[] = ['nama_produk' => $namaProduk];
        }

        // Jika tidak ada data alternatif, kembalikan dengan peringatan
        if (empty($alternatives)) {
            Log::warning('Tidak ada data transaksi untuk bulan: ' . $bulan . ', tahun: ' . $tahun);
            return view('result', [
                'alternatives' => [],
                'alternativeLabels' => [],
                'normalizedAlternatives' => [],
                'finalScores' => [],
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])->with('warning', 'Tidak ada data transaksi untuk periode yang dipilih.');
        }

        // Bobot kriteria dan jenis kriteria
        $weights = [0.4, 0.2, 0.4]; // Bobot untuk harga, biji kopi, dan terjual
        $criteriaTypes = ['benefit', 'benefit', 'cost']; // Harga dan biji kopi sebagai benefit, terjual sebagai cost

        // Pastikan jumlah elemen di $weights dan $criteriaTypes sesuai dengan jumlah kriteria
        if (count($weights) != count($criteriaTypes) || count($weights) != count($alternatives[0])) {
            Log::error('Jumlah tipe kriteria atau bobot tidak sesuai dengan jumlah kriteria.');
            throw new \Exception('Jumlah tipe kriteria atau bobot tidak sesuai dengan jumlah kriteria.');
        }

        // Normalisasi matriks
        $normalizedAlternatives = $this->normalize($alternatives, $criteriaTypes);

        // Menghitung skor akhir menggunakan bobot
        $finalScores = $this->calculateScores($normalizedAlternatives, $weights);

        Log::info('Perhitungan SAW selesai.');
// Cari skor yang mendekati angka 1
$closestToOneIndex = array_reduce(array_keys($finalScores), function ($carry, $index) use ($finalScores) {
    return (abs($finalScores[$index] - 1) < abs($finalScores[$carry] - 1)) ? $index : $carry;
}, 0);

$lowestScore = [
    'nama_produk' => $alternativeLabels[$closestToOneIndex]['nama_produk'] ?? '-',
    'skor' => $finalScores[$closestToOneIndex] ?? 0,
];


        return view('result', [
            'alternatives' => $alternatives,
            'alternativeLabels' => $alternativeLabels,
            'normalizedAlternatives' => $normalizedAlternatives,
            'finalScores' => $finalScores,
            'lowestScore' => $lowestScore,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    private function normalize(array $alternatives, array $criteriaTypes)
    {
        Log::info('Melakukan normalisasi data alternatif.');

        $criteriaKeys = array_keys($alternatives[0]);

        if (count($criteriaKeys) != count($criteriaTypes)) {
            Log::error('Jumlah tipe kriteria tidak sesuai dengan jumlah kriteria.');
            throw new \Exception('Jumlah tipe kriteria tidak sesuai dengan jumlah kriteria.');
        }

        $normalized = [];
        foreach ($criteriaKeys as $i => $key) {
            $column = array_column($alternatives, $key);

            if ($criteriaTypes[$i] === 'benefit') {
                $max = max($column);
                $normalizedColumn = $max == 0
                    ? array_fill(0, count($column), 0)
                    : array_map(fn($value) => $value / $max, $column);
            } else {
                $min = min($column);
                $normalizedColumn = $min == 0
                    ? array_fill(0, count($column), 0)
                    : array_map(fn($value) => $min / $value, $column);
            }

            foreach ($normalizedColumn as $index => $value) {
                $normalized[$index][$key] = $value;
            }
        }

        Log::info('Normalisasi selesai.', $normalized);

        return $normalized;
    }

    private function calculateScores(array $normalizedAlternatives, array $weights)
    {
        Log::info('Menghitung skor akhir untuk setiap alternatif.');

        $criteriaKeys = array_keys($normalizedAlternatives[0]);
        $finalScores = [];
        foreach ($normalizedAlternatives as $normalized) {
            $score = 0;
            foreach ($criteriaKeys as $index => $key) {
                $score += $normalized[$key] * $weights[$index];
            }
            $finalScores[] = $score;
        }

        return $finalScores;
    }
}
