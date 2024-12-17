<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pembeli');
            $table->string('nomor_telepon'); // Menambahkan kolom nomor_telepon
            $table->decimal('total_harga', 10, 2);
            $table->date('tanggal_transaksi');
            $table->enum('metode_pembayaran', ['cash', 'qr_code'])->default('cash'); // Menambahkan kolom metode_pembayaran
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
