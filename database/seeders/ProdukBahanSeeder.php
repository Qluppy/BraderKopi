<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukBahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkBahan = [
            ['idproduk' => 1, 'idbahan' => 1, 'jumlah_bahan' => 30], // CAFÉ LATTE
            ['idproduk' => 1, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 1, 'idbahan' => 3, 'jumlah_bahan' => 30],
            ['idproduk' => 2, 'idbahan' => 17, 'jumlah_bahan' => 20], // FILTER COFFEE
            ['idproduk' => 3, 'idbahan' => 1, 'jumlah_bahan' => 30], // KARAMEL
            ['idproduk' => 3, 'idbahan' => 4, 'jumlah_bahan' => 20],
            ['idproduk' => 3, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 4, 'idbahan' => 1, 'jumlah_bahan' => 30], // SWEET LATTE
            ['idproduk' => 4, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 4, 'idbahan' => 5, 'jumlah_bahan' => 20],
            ['idproduk' => 5, 'idbahan' => 1, 'jumlah_bahan' => 30], // CRÈME BRULLE
            ['idproduk' => 5, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 5, 'idbahan' => 6, 'jumlah_bahan' => 15],
            ['idproduk' => 6, 'idbahan' => 1, 'jumlah_bahan' => 30], // COTTON CANDY
            ['idproduk' => 6, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 6, 'idbahan' => 7, 'jumlah_bahan' => 20],
            ['idproduk' => 7, 'idbahan' => 1, 'jumlah_bahan' => 30], // KOKRIM
            ['idproduk' => 7, 'idbahan' => 8, 'jumlah_bahan' => 15],
            ['idproduk' => 7, 'idbahan' => 9, 'jumlah_bahan' => 20],
            ['idproduk' => 8, 'idbahan' => 10, 'jumlah_bahan' => 25], // VIETNAM DRIP
            ['idproduk' => 8, 'idbahan' => 11, 'jumlah_bahan' => 30],
            ['idproduk' => 9, 'idbahan' => 1, 'jumlah_bahan' => 30], // AMERICANO
            ['idproduk' => 10, 'idbahan' => 12, 'jumlah_bahan' => 100], // SHAKEN FRUITY
            ['idproduk' => 10, 'idbahan' => 13, 'jumlah_bahan' => 50],
            ['idproduk' => 10, 'idbahan' => 5, 'jumlah_bahan' => 15],
            ['idproduk' => 11, 'idbahan' => 14, 'jumlah_bahan' => 50], // CITRUS
            ['idproduk' => 11, 'idbahan' => 13, 'jumlah_bahan' => 50],
            ['idproduk' => 11, 'idbahan' => 5, 'jumlah_bahan' => 15],
            ['idproduk' => 12, 'idbahan' => 15, 'jumlah_bahan' => 100], // BLACKBERRY
            ['idproduk' => 12, 'idbahan' => 16, 'jumlah_bahan' => 50],
            ['idproduk' => 12, 'idbahan' => 13, 'jumlah_bahan' => 50],
            ['idproduk' => 13, 'idbahan' => 17, 'jumlah_bahan' => 20], // Gourmet brewed coffee
            ['idproduk' => 14, 'idbahan' => 17, 'jumlah_bahan' => 20], // Drip coffee
            ['idproduk' => 15, 'idbahan' => 1, 'jumlah_bahan' => 30], // Barista Espresso
            ['idproduk' => 16, 'idbahan' => 17, 'jumlah_bahan' => 20], // Organic brewed coffee
            ['idproduk' => 17, 'idbahan' => 17, 'jumlah_bahan' => 20], // Premium brewed coffee
            ['idproduk' => 18, 'idbahan' => 1, 'jumlah_bahan' => 30], // kopi bunbun
            ['idproduk' => 18, 'idbahan' => 18, 'jumlah_bahan' => 15],
            ['idproduk' => 18, 'idbahan' => 8, 'jumlah_bahan' => 15],
            ['idproduk' => 19, 'idbahan' => 1, 'jumlah_bahan' => 30], // katakuri
            ['idproduk' => 19, 'idbahan' => 4, 'jumlah_bahan' => 20],
            ['idproduk' => 19, 'idbahan' => 2, 'jumlah_bahan' => 150],
            ['idproduk' => 20, 'idbahan' => 1, 'jumlah_bahan' => 30], // blackcitrus
            ['idproduk' => 20, 'idbahan' => 14, 'jumlah_bahan' => 50],
            ['idproduk' => 20, 'idbahan' => 5, 'jumlah_bahan' => 15],
        ];

        DB::table('produk_bahan')->insert($produkBahan);
    }
}
