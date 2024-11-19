<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    
    use HasFactory;
    
    protected $table = 'detailtransaksi'; // Nama tabel

    protected $fillable = [
        'idtransaksi',
        'idproduk',
        'harga_saat_pesan',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'idtransaksi');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idproduk');
    }
}
