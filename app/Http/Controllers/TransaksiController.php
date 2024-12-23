<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('detailTransaksi.produk')->get();
        $produk = Produk::all();
        $keranjang = session()->get('keranjang', []);

        return view('transaksi.index', compact('transaksi', 'produk', 'keranjang'));
    }

    public function cariProduk(Request $request)
    {
        // Ambil kata kunci pencarian dari request
        $query = $request->input('query');

        // Cari produk berdasarkan nama yang sesuai dengan query
        $produk = Produk::where('nama_produk', 'LIKE', "%$query%")
            ->get(['id', 'nama_produk', 'harga_produk', 'gambar_produk']);

        // Kembalikan data produk dalam bentuk JSON
        return response()->json($produk);
    }

    public function tambahKeKeranjang(Request $request, $id)
    {
        $produk = Produk::find($id);
        $jumlah = $request->jumlah;

        if (!$produk) {
            return redirect()->route('transaksi.index')->with('error', 'Produk tidak ditemukan');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += $jumlah;
        } else {
            $keranjang[$id] = [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga_produk' => $produk->harga_produk,
                'gambar_produk' => $produk->gambar_produk,
                'jumlah' => $jumlah,
            ];
        }

        session()->put('keranjang', $keranjang);
        return redirect()->route('transaksi.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function updateKeranjang($key)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$key])) {
            $jumlah = request()->input('jumlah');
            if ($jumlah > 0) {
                $keranjang[$key]['jumlah'] = $jumlah;
                session()->put('keranjang', $keranjang);
                return redirect()->route('transaksi.index')->with('success', 'Jumlah produk berhasil diperbarui.');
            } else {
                return redirect()->route('transaksi.index')->with('error', 'Jumlah produk harus lebih dari 0.');
            }
        }

        return redirect()->route('transaksi.index')->with('error', 'Produk tidak ditemukan dalam keranjang.');
    }

    public function hapusDariKeranjang($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
            return redirect()->route('transaksi.index')->with('success', 'Produk berhasil dihapus dari keranjang');
        }

        return redirect()->route('transaksi.index')->with('error', 'Produk tidak ditemukan di keranjang');
    }

    public function store(Request $request)
{
    Log::info($request->all());

    $request->validate([
        'nama_pembeli' => 'required|string',
        'nomor_telepon' => 'required|string|max:15', // Validasi nomor telepon
    ]);

    $keranjang = session()->get('keranjang', []);
    if (empty($keranjang)) {
        return redirect()->route('transaksi.index')->with('error', 'Keranjang kosong, silakan pilih produk');
    }

    $totalHarga = 0;
    $stokUpdate = [];

    foreach ($keranjang as $item) {
        $produk = Produk::find($item['id']);
        $jumlah = $item['jumlah'];

        $totalHarga += $produk->harga_produk * $jumlah;

        foreach ($produk->bahan as $bahan) {
            $stok = Stok::where('idbahan', $bahan->id)->first();

            if (!$stok || $stok->jumlah_stok < $bahan->pivot->jumlah_bahan * $jumlah) {
                return redirect()->route('notifikasi.stok')->with(
                    'error',
                    'Stok bahan untuk "' . $bahan->nama_bahan . '" tidak mencukupi.'
                );
            }

            $stokUpdate[$bahan->id] = isset($stokUpdate[$bahan->id])
                ? $stokUpdate[$bahan->id] + ($bahan->pivot->jumlah_bahan * $jumlah)
                : $bahan->pivot->jumlah_bahan * $jumlah;
        }
    }

    foreach ($stokUpdate as $bahanId => $jumlahDipakai) {
        $stok = Stok::find($bahanId);
        if ($stok) {
            $stok->jumlah_stok -= $jumlahDipakai;
            $stok->save();
        }
    }

    $transaksi = Transaksi::create([
        'nama_pembeli' => $request->nama_pembeli,
        'nomor_telepon' => $request->nomor_telepon, // Simpan nomor telepon ke database
        'total_harga' => $totalHarga,
        'tanggal_transaksi' => now(),
    ]);

    foreach ($keranjang as $item) {
        $produk = Produk::find($item['id']);
        $jumlah = $item['jumlah'];

        DetailTransaksi::create([
            'transaksi_id' => $transaksi->id,
            'produk_id' => $produk->id,
            'harga' => $produk->harga_produk,
            'jumlah' => $jumlah,
        ]);
    }

    session()->forget('keranjang');

    return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
}


    public function cancel($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'status' => 'dibatalkan',
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi telah dibatalkan');
    }

    // public function nota($id)
    // {
    //     $transaksi = Transaksi::with('detailTransaksi.produk')->findOrFail($id);

    //     // Buat tampilan PDF
    //     $pdf = PDF::loadView('transaksi.nota', compact('transaksi'));

    //     // Menampilkan PDF langsung di browser
    //     return $pdf->stream('Nota_Transaksi_' . $transaksi->id . '.pdf');
    // }
}