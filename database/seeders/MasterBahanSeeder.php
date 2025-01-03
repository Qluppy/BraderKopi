<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterBahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahan = [
            ['nama_bahan' => 'Espresso', 'deskripsi_bahan' => 'Ekstrak kopi yang pekat', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Susu', 'deskripsi_bahan' => 'Susu cair untuk minuman', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Foam susu', 'deskripsi_bahan' => 'Busa susu dari proses steaming', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Sirup karamel', 'deskripsi_bahan' => 'Sirup rasa karamel', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Sirup gula', 'deskripsi_bahan' => 'Sirup gula sederhana', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Krim brulée', 'deskripsi_bahan' => 'Krim dengan rasa brulée', 'jenis_bahan' => 'padat', 'satuan' => 'gram'],
            ['nama_bahan' => 'Sirup cotton candy', 'deskripsi_bahan' => 'Sirup rasa cotton candy', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Krim kelapa', 'deskripsi_bahan' => 'Krim dengan rasa kelapa', 'jenis_bahan' => 'padat', 'satuan' => 'gram'],
            ['nama_bahan' => 'Sirup gula aren', 'deskripsi_bahan' => 'Sirup dari gula aren', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Kopi Vietnam', 'deskripsi_bahan' => 'Kopi khas Vietnam', 'jenis_bahan' => 'padat', 'satuan' => 'gram'],
            ['nama_bahan' => 'Susu kental manis', 'deskripsi_bahan' => 'Susu kental dengan gula', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Jus buah', 'deskripsi_bahan' => 'Jus dari berbagai buah', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Es batu', 'deskripsi_bahan' => 'Air beku untuk minuman', 'jenis_bahan' => 'padat', 'satuan' => 'gram'],
            ['nama_bahan' => 'Air jeruk', 'deskripsi_bahan' => 'Air perasan jeruk', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Jus blackberry', 'deskripsi_bahan' => 'Jus dari buah blackberry', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Air soda', 'deskripsi_bahan' => 'Air dengan karbonasi', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter'],
            ['nama_bahan' => 'Biji Kopi', 'deskripsi_bahan' => 'Kopi yang sudah digiling', 'jenis_bahan' => 'padat', 'satuan' => 'gram'],
            ['nama_bahan' => 'Sirup kelapa', 'deskripsi_bahan' => 'Sirup rasa kelapa', 'jenis_bahan' => 'cair', 'satuan' => 'mililiter']
        ];

        DB::table('master_bahan')->insert($bahan);
    }
}
