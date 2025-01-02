<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';

    protected $fillable = [
        'idbahan',
        'jumlah_stok',
    ];

    public function masterBahan()
    {
        return $this->belongsTo(MasterBahan::class, 'idbahan');
    }
    public function getJumlahStokTampilanAttribute()
{
    $jumlah = $this->jumlah_stok; // Ambil stok dalam satuan dasar
    $satuan = $this->masterBahan->satuan; // Ambil satuan bahan (gram/mililiter)

    if (($satuan === 'gram' || $satuan === 'mililiter') && $jumlah == 1000) {
        return '1'; // Jika sama dengan 1000, tampilkan 1
    } elseif ($satuan === 'gram' && $jumlah > 1000) {
        return number_format($jumlah / 1000, 2, ',', ''); // Konversi ke kilogram
    } elseif ($satuan === 'mililiter' && $jumlah > 1000) {
        return number_format($jumlah / 1000, 2, ',', ''); // Konversi ke liter
    }

    return number_format($jumlah, 0, ',', ''); // Jika kurang dari 1000, tampilkan dalam satuan dasar
}

public function getSatuanTampilanAttribute()
{
    $satuan = $this->masterBahan->satuan; // Ambil satuan bahan (gram/mililiter)

    // Ubah satuan jika jumlah >= 1000
    if ($satuan === 'gram' && $this->jumlah_stok >= 1000) {
        return 'kilogram';
    } elseif ($satuan === 'mililiter' && $this->jumlah_stok >= 1000) {
        return 'liter';
    }

    return $satuan; // Tetap gunakan satuan asli jika di bawah 1000
}

}
