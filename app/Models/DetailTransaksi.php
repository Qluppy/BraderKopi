<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan nama default (laravel akan menganggap tabel bernama 'detailtransaksis')
    protected $table = 'detailtransaksi';

    // Tentukan atribut yang dapat diisi secara mass-assignment
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'harga',
        'jumlah',
    ];

    // Relasi dengan transaksi (setiap detail transaksi berhubungan dengan satu transaksi)
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Relasi dengan produk (setiap detail transaksi berhubungan dengan satu produk)
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}