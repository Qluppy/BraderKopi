<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukBahan extends Model
{
    use HasFactory;

    protected $table = 'produk_bahan';

    protected $fillable = [
        'idproduk',
        'idbahan',
        'jumlah_bahan',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idproduk');
    }

    public function masterBahan()
    {
        return $this->belongsTo(MasterBahan::class, 'idbahan');
    }
}
