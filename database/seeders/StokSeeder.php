<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanIds = DB::table('master_bahan')->pluck('id');

        $stokData = $bahanIds->map(function ($id) {
            return [
                'idbahan' => $id,
                'jumlah_stok' => 10000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('stok')->insert($stokData);
    }
}
