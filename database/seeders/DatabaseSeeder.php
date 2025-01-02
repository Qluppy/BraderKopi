<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Memanggil seeder tambahan
        $this->call(UsersTableSeeder::class);

        // Seeder untuk master_bahan
        $this->call(MasterBahanSeeder::class);

        // Seeder untuk produk
        $this->call(ProdukSeeder::class);

        // Seeder untuk produk_bahan
        $this->call(ProdukBahanSeeder::class);

        // Seeder untuk stok (stok baru membutuhkan bahan yang ada di master_bahan)
        $this->call(StokSeeder::class);

        $this->call(LaporanSeeder::class);
    }
}
