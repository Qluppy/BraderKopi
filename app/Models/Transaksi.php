<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';

    protected $fillable = [

        'total_harga',
        'nama_pembeli',
        'tanggal_transaksi',
        'metode_pembayaran',
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'idakun');
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'idtransaksi');
    }
}
