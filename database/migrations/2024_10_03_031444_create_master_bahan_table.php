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
        Schema::create('master_bahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan');
            $table->text('deskripsi_bahan')->nullable();
            $table->string('satuan'); // Pastikan kolom satuan ada
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_bahan');
    }
};
