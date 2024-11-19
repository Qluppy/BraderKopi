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
            $table->foreignId('idakun')->nullable()->constrained('akun')->onDelete('cascade');
            $table->decimal('total_harga', 8, 2);
            $table->string('nama_pembeli');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->enum('metode_pembayaran', ['cash', 'QR code']);
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
