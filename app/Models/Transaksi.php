<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan nama default (laravel akan menganggap tabel bernama 'transaksi')
    protected $table = 'transaksi';

    // Tentukan atribut yang dapat diisi secara mass-assignment
    protected $fillable = [
        'nama_pembeli',
        'nomor_telepon', // Tambahkan kolom nomor_telepon
        'total_harga',
        'tanggal_transaksi',
        'metode_pembayaran',
    ];

    // Relasi dengan detail transaksi (satu transaksi bisa memiliki banyak detail transaksi)
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}
