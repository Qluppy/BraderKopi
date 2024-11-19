<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'harga_produk',
        'deskripsi_produk',
        'gambar_produk',
    ];

    // Relasi ke tabel produk_bahan
    public function bahan()
    {
        return $this->belongsToMany(MasterBahan::class, 'produk_bahan', 'idproduk', 'idbahan')
                    ->withPivot('jumlah_bahan');
    }

    public function produkBahan()
    {
        return $this->hasMany(ProdukBahan::class, 'idproduk');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'idproduk');
    }
}
