<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SawController extends Controller
{
    public function index()
    {
        // Data awal untuk ditampilkan di halaman result tanpa perhitungan
        $alternatives = [];
        $normalizedAlternatives = [];
        $finalScores = [];

        return view('result', [
            'alternatives' => $alternatives,
            'normalizedAlternatives' => $normalizedAlternatives,
            'finalScores' => $finalScores,
        ]);
    }

    public function calculate()
    {
        // Data alternatif (Harga, Biji kopi, Terjual)
        $alternatives = [
            [3000000, 48, 18],  // A1
            [4000000, 64, 17],  // A2
            [5000000, 32, 18],  // A3
        ];

        // Bobot untuk masing-masing kriteria
        $weights = [0.4, 0.2, 0.4];

        // Jenis kriteria (cost atau benefit)
        $criteriaTypes = ['cost', 'benefit', 'benefit']; // Harga = cost, Biji kopi = benefit, Terjual = benefit

        // Step 1: Normalisasi Matriks
        $normalizedAlternatives = $this->normalize($alternatives, $criteriaTypes);

        // Step 2: Hitung skor akhir
        $finalScores = [];
        foreach ($normalizedAlternatives as $alternative) {
            $score = 0;
            foreach ($alternative as $index => $value) {
                $score += $value * $weights[$index];
            }
            $finalScores[] = $score;
        }

        return view('result', [
            'alternatives' => $alternatives,
            'normalizedAlternatives' => $normalizedAlternatives,
            'finalScores' => $finalScores,
        ]);
    }

    public function normalize($matrix, $criteriaTypes)
    {
        $normalizedMatrix = [];
        $numCriteria = count($matrix[0]);

        for ($j = 0; $j < $numCriteria; $j++) {
            $column = array_column($matrix, $j);

            if ($criteriaTypes[$j] === 'cost') { // Kriteria minimisasi (cost)
                $minValue = min($column);
                foreach ($column as $index => $value) {
                    $normalizedMatrix[$index][$j] = $minValue / $value;
                }
            } else { // Kriteria maksimisasi (benefit)
                $maxValue = max($column);
                foreach ($column as $index => $value) {
                    $normalizedMatrix[$index][$j] = $value / $maxValue;
                }
            }
        }

        return $normalizedMatrix;
    }
}
