<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\MasterBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    // Ambil data stok dan master bahan
    $search = $request->get('search');
    $filter = $request->get('filter', 'newest'); // Default filter ke 'newest'
    $perPage = $request->get('per_page', 5); // Default ke 5, jika tidak ada inputan

    $stok = Stok::with('masterBahan')
        ->when($search, function ($query, $search) {
            return $query->whereHas('masterBahan', function ($q) use ($search) {
                $q->where('nama_bahan', 'like', "%{$search}%");
            });
        });

    // Filter berdasarkan kondisi
    if ($filter == 'newest') {
        $stok = $stok->orderBy('created_at', 'desc');
    } elseif ($filter == 'oldest') {
        $stok = $stok->orderBy('created_at', 'asc');
    } elseif ($filter == 'lowest_stock') {
        $stok = $stok->orderBy('jumlah_stok', 'asc');
    } elseif ($filter == 'highest_stock') {
        $stok = $stok->orderBy('jumlah_stok', 'desc');
    }

    // Menggunakan paginate untuk membatasi data berdasarkan per halaman
    $stok = $stok->paginate($perPage)->withQueryString(); // Menjaga query string seperti search dan filter

    return view('stok.index', compact('stok'));
}




    public function create()
{
    return view('stok.create'); // Mengarah ke view stok/create.blade.php
}

    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $validatedData = $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'deskripsi_bahan' => 'nullable|string',
            'jumlah_stok' => 'required|numeric|min:0',
            'jenis_bahan' => 'required|string|in:padat,cair',
        ]);

        // Periksa nama bahan secara case-insensitive
        $existingBahan = MasterBahan::whereRaw('LOWER(nama_bahan) = ?', [strtolower($validatedData['nama_bahan'])])->first();

        if ($existingBahan) {
            return redirect()->back()->withErrors([
                'nama_bahan' => 'Nama bahan sudah ada (tidak sensitif terhadap huruf besar/kecil). Harap gunakan nama lain.',
            ])->withInput();
        }

        $jumlahDalamSatuanDasar = match ($validatedData['satuan']) {
            'kilogram' => $validatedData['jumlah_stok'] * 1000,
            'liter' => $validatedData['jumlah_stok'] * 1000,
            default => $validatedData['jumlah_stok'],
        };

        $satuanDasar = $validatedData['jenis_bahan'] === 'padat' ? 'gram' : 'mililiter';

        // Buat master bahan dan stok
        $bahan = MasterBahan::create([
            'nama_bahan' => $validatedData['nama_bahan'],
            'satuan' => $satuanDasar,
            'deskripsi_bahan' => $validatedData['deskripsi_bahan'],
            'jenis_bahan' => $validatedData['jenis_bahan'],
        ]);

        Stok::create([
            'idbahan' => $bahan->id,
            'jumlah_stok' => $jumlahDalamSatuanDasar,
        ]);

        return redirect()->route('stok.index')->with('success', 'Bahan berhasil ditambahkan.');
    }

    public function tambahStok(Request $request)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }

        $validatedData = $request->validate([
            'bahan_id' => 'required|exists:master_bahan,id',
            'jumlah_stok' => 'required|numeric|min:1',
        ]);

        $bahan = MasterBahan::findOrFail($validatedData['bahan_id']);
        $jumlahDalamSatuanDasar = match ($request->input('satuan')) {
            'kilogram' => $validatedData['jumlah_stok'] * 1000,
            'liter' => $validatedData['jumlah_stok'] * 1000,
            default => $validatedData['jumlah_stok'],
        };

        $stok = Stok::where('idbahan', $bahan->id)->first();
        if ($stok) {
            $stok->jumlah_stok += $jumlahDalamSatuanDasar;
            $stok->save();
        } else {
            Stok::create([
                'idbahan' => $bahan->id,
                'jumlah_stok' => $jumlahDalamSatuanDasar,
            ]);
        }

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Ambil data bahan untuk diedit
        $bahan = MasterBahan::findOrFail($id);

        // Return view edit dengan data bahan
        return view('stok.index', compact('bahan'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $request->validate([
            'nama_bahan' => 'required|string|max:255',
            'deskripsi_bahan' => 'nullable|string',
        ]);

        // Update data di master_bahan
        $bahan = MasterBahan::findOrFail($id);
        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->deskripsi_bahan = $request->deskripsi_bahan;
        $bahan->save();

        return redirect()->route('stok.index')->with('success', 'Bahan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Hapus bahan berdasarkan ID
        MasterBahan::destroy($id);

        // Redirect kembali ke halaman master bahan dengan pesan sukses
        return redirect()->route('stok.index')->with('success', 'Bahan berhasil dihapus.');
    }

}
