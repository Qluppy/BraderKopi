<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        // Menampilkan semua detail transaksi
        $detail = DetailTransaksi::all();
        return response()->json($detail);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'idtransaksi' => 'required',
            'idproduk' => 'required',
            'jumlah' => 'required|integer',
            'harga_saat_pesan' => 'required|numeric'
        ]);

        // Menyimpan detail transaksi baru
        $detail = DetailTransaksi::create($request->all());
        return response()->json($detail, 201);
    }

    public function show($id)
    {
        // Menampilkan satu detail transaksi berdasarkan ID
        $detail = DetailTransaksi::findOrFail($id);
        return response()->json($detail);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'jumlah' => 'required|integer',
            'harga_saat_pesan' => 'required|numeric'
        ]);

        // Update detail transaksi
        $detail = DetailTransaksi::findOrFail($id);
        $detail->update($request->all());

        return response()->json($detail);
    }

    public function destroy($id)
    {
        // Hapus detail transaksi
        DetailTransaksi::destroy($id);
        return response()->json(null, 204);
    }
}
