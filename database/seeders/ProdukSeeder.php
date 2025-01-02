<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            ['nama_produk' => 'CAFÉ LATTE', 'deskripsi_produk' => 'Kopi espresso dengan susu panas dan busa', 'harga_produk' => 23000, 'gambar_produk' => null],
            ['nama_produk' => 'FILTER COFFEE', 'deskripsi_produk' => 'Kopi seduh dengan metode filter', 'harga_produk' => 25000, 'gambar_produk' => null],
            ['nama_produk' => 'KARAMEL', 'deskripsi_produk' => 'Kopi dengan sirup karamel manis', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'SWEET LATTE', 'deskripsi_produk' => 'Latte dengan rasa manis yang lembut', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'CRÈME BRULLE', 'deskripsi_produk' => 'Kopi dengan campuran krim brulée', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'COTTON CANDY', 'deskripsi_produk' => 'Minuman manis dengan rasa cotton candy', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'KOKRIM', 'deskripsi_produk' => 'Minuman kopi dengan krim kelapa yang lezat', 'harga_produk' => 18000, 'gambar_produk' => null],
            ['nama_produk' => 'VIETNAM DRIP', 'deskripsi_produk' => 'Kopi Vietnam dengan rasa yang khas', 'harga_produk' => 18000, 'gambar_produk' => null],
            ['nama_produk' => 'AMERICANO', 'deskripsi_produk' => 'Kopi hitam dengan sedikit air', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'SHAKEN FRUITY', 'deskripsi_produk' => 'Minuman kopi dengan campuran jus buah segar', 'harga_produk' => 20000, 'gambar_produk' => null],
            ['nama_produk' => 'CITRUS', 'deskripsi_produk' => 'Kopi dengan sentuhan rasa jeruk segar', 'harga_produk' => 18000, 'gambar_produk' => null],
            ['nama_produk' => 'BLACKBERRY', 'deskripsi_produk' => 'Kopi dengan rasa buah blackberry yang unik', 'harga_produk' => 18000, 'gambar_produk' => null],
            ['nama_produk' => 'Gourmet brewed coffee', 'deskripsi_produk' => 'Kopi gourmet dengan rasa yang kuat', 'harga_produk' => 19000, 'gambar_produk' => null],
            ['nama_produk' => 'Drip coffee', 'deskripsi_produk' => 'Kopi yang diseduh menggunakan metode drip', 'harga_produk' => 22000, 'gambar_produk' => null],
            ['nama_produk' => 'Barista Espresso', 'deskripsi_produk' => 'Espresso murni yang pekat dan kuat', 'harga_produk' => 25000, 'gambar_produk' => null],
            ['nama_produk' => 'Organic brewed coffee', 'deskripsi_produk' => 'Kopi yang diseduh dari biji kopi organik', 'harga_produk' => 24000, 'gambar_produk' => null],
            ['nama_produk' => 'Premium brewed coffee', 'deskripsi_produk' => 'Kopi premium dengan rasa yang luar biasa', 'harga_produk' => 28000, 'gambar_produk' => null],
            ['nama_produk' => 'kopi bunbun', 'deskripsi_produk' => 'Kopi khas dengan rasa unik', 'harga_produk' => 19000, 'gambar_produk' => null],
            ['nama_produk' => 'katakuri', 'deskripsi_produk' => 'Minuman kopi dengan rasa lembut dan ringan', 'harga_produk' => 18000, 'gambar_produk' => null],
            ['nama_produk' => 'blackcitrus', 'deskripsi_produk' => 'Kopi dengan perpaduan rasa kopi dan jeruk hitam', 'harga_produk' => 20000, 'gambar_produk' => null]
        ];

        DB::table('produk')->insert($produk);
    }
}
