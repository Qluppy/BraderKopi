<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        try {
            // Menampilkan semua detail transaksi
            $detail = DetailTransaksi::all();
            return response()->json($detail, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'idtransaksi' => 'required|exists:transaksi,id', // Pastikan idtransaksi ada di tabel transaksi
                'idproduk' => 'required|exists:produk,id', // Pastikan idproduk ada di tabel produk
                'jumlah' => 'required|integer|min:1',
                'harga_saat_pesan' => 'required|numeric|min:0'
            ]);

            // Menyimpan detail transaksi baru
            $detail = DetailTransaksi::create($validatedData);
            return response()->json($detail, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            // Menampilkan satu detail transaksi berdasarkan ID
            $detail = DetailTransaksi::findOrFail($id);
            return response()->json($detail, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validatedData = $request->validate([
                'jumlah' => 'required|integer|min:1',
                'harga_saat_pesan' => 'required|numeric|min:0'
            ]);

            // Update detail transaksi
            $detail = DetailTransaksi::findOrFail($id);
            $detail->update($validatedData);

            return response()->json($detail, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Hapus detail transaksi
            $detail = DetailTransaksi::findOrFail($id);
            $detail->delete();

            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
        }
    }
}