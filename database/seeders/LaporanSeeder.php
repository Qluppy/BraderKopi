<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data produk dari database
        $produk = DB::table('produk')->get();

        // Pastikan ada produk sebelum melanjutkan
        if ($produk->isEmpty()) {
            $this->command->error('Seeder gagal: Data produk tidak ditemukan. Jalankan ProdukSeeder terlebih dahulu.');
            return;
        }

        // Buat data transaksi
        $transaksi = [];
        $detailTransaksi = [];

        // Rentang bulan yang diinginkan (September hingga Desember 2024)
        $bulan = [
            '09' => '2024-09-01', // September
            '10' => '2024-10-01', // Oktober
            '11' => '2024-11-01', // November
            '12' => '2024-12-01', // Desember
        ];

        $transaksiId = 1; // Mulai dari ID transaksi 1

        // Loop untuk setiap bulan
        foreach ($bulan as $key => $monthStartDate) {
            $maxTransaksiPerBulan = 5; // Maksimal 5 transaksi per bulan
            $tanggalMulai = Carbon::parse($monthStartDate);
            $tanggalAkhir = $tanggalMulai->copy()->endOfMonth(); // Akhir bulan

            // Generate transaksi untuk bulan ini
            for ($i = 1; $i <= $maxTransaksiPerBulan; $i++) {
                // Pilih tanggal acak dalam rentang bulan ini
                $tanggalTransaksi = $tanggalMulai->copy()->addDays(rand(0, $tanggalAkhir->dayOfMonth - 1));

                $transaksi[] = [
                    'id' => $transaksiId,
                    'nama_pembeli' => "Pembeli $transaksiId",
                    'total_harga' => 0, // Akan dihitung nanti
                    'tanggal_transaksi' => $tanggalTransaksi,
                    'created_at' => $tanggalTransaksi,
                    'updated_at' => $tanggalTransaksi,
                ];

                // Pilih 2-3 produk secara acak untuk transaksi ini
                $produkTerpilih = $produk->random(rand(2, 3));
                $totalHarga = 0;

                foreach ($produkTerpilih as $p) {
                    $jumlah = rand(1, 3); // Jumlah produk yang dibeli
                    $subtotal = $p->harga_produk * $jumlah; // Hitung subtotal produk

                    // Simpan detail transaksi dengan harga produk yang sesuai
                    $detailTransaksi[] = [
                        'transaksi_id' => $transaksiId,
                        'produk_id' => $p->id,
                        'jumlah' => $jumlah,
                        'harga' => $p->harga_produk, // Masukkan harga produk
                    ];

                    $totalHarga += $subtotal; // Total harga transaksi dihitung berdasarkan subtotal
                }

                // Update total harga transaksi
                $transaksi[$transaksiId - 1]['total_harga'] = $totalHarga;

                // Increment transaksiId
                $transaksiId++;
            }
        }

        // Masukkan data ke tabel
        DB::table('transaksi')->insert($transaksi);
        DB::table('detailtransaksi')->insert($detailTransaksi);

        $this->command->info('Seeder berhasil dijalankan.');
    }
}