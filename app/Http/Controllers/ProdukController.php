<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\MasterBahan;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    // Ambil data produk dan master bahan
    $search = $request->get('search');
    $filter = $request->get('filter', 'newest'); // Default filter ke 'newest'
    $perPage = $request->get('per_page', 5); // Default ke 5, jika tidak ada inputan

    $produk = Produk::with('bahan')
        ->when($search, function ($query, $search) {
            return $query->where('nama_produk', 'like', "%{$search}%");
        });

    // Filter berdasarkan kondisi
    if ($filter == 'newest') {
        $produk = $produk->orderBy('created_at', 'desc');
    } elseif ($filter == 'oldest') {
        $produk = $produk->orderBy('created_at', 'asc');
    } elseif ($filter == 'lowest_price') {
        $produk = $produk->orderBy('harga_produk', 'asc');
    } elseif ($filter == 'highest_price') {
        $produk = $produk->orderBy('harga_produk', 'desc');
    }

    // Menggunakan paginate untuk membatasi data berdasarkan per halaman
    $produk = $produk->paginate($perPage)->withQueryString(); // Menjaga query string seperti search dan filter

    return view('produk.index', compact('produk'));
}


    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Menampilkan form untuk menambahkan produk baru
        $bahan = MasterBahan::all(); // Ambil semua data bahan
        return view('produk.create', compact('bahan')); // Pastikan $bahan dikirim ke view
    }

    public function store(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    Log::info($request->all()); // Ini untuk debugging

    // Validasi input
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga_produk' => 'required|numeric',
        'deskripsi_produk' => 'nullable|string',
        'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'bahan' => 'required|array',
        'bahan.*' => 'exists:master_bahan,id',
        'jumlah_stok' => 'required|array',
        'jumlah_stok.*' => 'numeric|min:0',
    ]);

    // Periksa nama produk secara case-insensitive
    $existingProduk = Produk::whereRaw('LOWER(nama_produk) = ?', [strtolower($request->nama_produk)])->first();

    if ($existingProduk) {
        return redirect()->back()->withErrors([
            'nama_produk' => 'Nama produk sudah ada (tidak sensitif terhadap huruf besar/kecil). Harap gunakan nama lain.',
        ])->withInput();
    }

    // Upload gambar produk jika ada
    $gambarPath = null;
    if ($request->hasFile('gambar_produk')) {
        $gambarPath = $request->file('gambar_produk')->store('produk', 'public');
        Log::info('Gambar path: ' . $gambarPath); // Untuk memastikan path gambar
    }

    // Buat produk baru
    $produk = Produk::create([
        'nama_produk' => $request->nama_produk,
        'harga_produk' => $request->harga_produk,
        'deskripsi_produk' => $request->deskripsi_produk,
        'gambar_produk' => $gambarPath, // Simpan path gambar
    ]);

    // Simpan bahan-bahan yang diperlukan untuk produk
    foreach ($request->bahan as $key => $idbahan) {
        ProdukBahan::create([
            'idproduk' => $produk->id,
            'idbahan' => $idbahan,
            'jumlah_bahan' => $request->jumlah_stok[$key], // Simpan jumlah bahan
        ]);
    }

    return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
}



    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Menampilkan form untuk mengedit produk
        $produk = Produk::with('produkBahan.masterBahan')->findOrFail($id);
        $bahan = MasterBahan::all(); // Ambil semua bahan
        return view('produk.edit', compact('produk', 'bahan')); // Pastikan $bahan dikirim ke view
    }

    public function update(Request $request, $id)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    // Validasi input hanya untuk produk yang bisa diedit
    $request->validate([
        'nama_produk' => 'required|string|max:255',
        'harga_produk' => 'required|numeric',
        'deskripsi_produk' => 'nullable|string',
        'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Temukan produk berdasarkan id
    $produk = Produk::findOrFail($id);

    // Upload gambar baru jika ada
    if ($request->hasFile('gambar_produk')) {
        // Hapus gambar lama jika ada
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }
        // Simpan gambar baru
        $gambarPath = $request->file('gambar_produk')->store('produk', 'public');
        $produk->gambar_produk = $gambarPath;
    }

    // Perbarui data produk (nama, harga, deskripsi)
    $produk->update([
        'nama_produk' => $request->nama_produk,
        'harga_produk' => $request->harga_produk,
        'deskripsi_produk' => $request->deskripsi_produk,
    ]);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}


    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Hapus produk beserta bahan-bahannya
        $produk = Produk::findOrFail($id);

        // Hapus gambar produk jika ada
        if ($produk->gambar_produk) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        // Hapus bahan-bahan produk
        ProdukBahan::where('idproduk', $produk->id)->delete();

        // Hapus produk
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}
