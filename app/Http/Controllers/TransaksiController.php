<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Produk;
use App\Models\Transaksi;
use Spatie\Dropbox\Client;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use App\Services\FonnteService;
use Illuminate\Support\Facades\Log;
use App\Services\DropboxTokenProvider;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TransaksiController extends Controller
{
    protected $client;
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->client = new Client($this->getValidAccessToken());
        $this->fonnteService = $fonnteService;
    }

    /**
     * Mendapatkan token akses yang valid.
     */
    private function getValidAccessToken()
    {
        $tokenProvider = new DropboxTokenProvider();
        return $tokenProvider->getToken();
    }

    /**
     * Fungsi untuk membuat PDF dari struk transaksi.
     */
    private function generateReceiptPDF($transaksi)
    {
        return PDF::loadView('transaksi.nota-pdf', compact('transaksi'));
    }


    /**
     * Fungsi untuk menyelesaikan transaksi, membuat struk PDF, dan mengunggah ke Dropbox.
     */
    private function completeCart($transaksi)
    {
        // Generate PDF menggunakan view tanpa layout
        $pdf = $this->generateReceiptPDF($transaksi);

        // Simpan sementara file PDF di storage lokal
        $filePath = storage_path("app/public/struk-transaksi-{$transaksi->id}.pdf");
        $pdf->save($filePath);

        // Unggah ke Dropbox
        try {
            // Pastikan folder di Dropbox ada
            $this->client->createFolder('/struk');
        } catch (\Spatie\Dropbox\Exceptions\BadRequest $e) {
            // Abaikan error jika folder sudah ada
        }

        try {
            // Upload file ke Dropbox
            $this->client->upload(
                "/struk/struk-transaksi-{$transaksi->id}.pdf",
                file_get_contents($filePath),
                'overwrite'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengunggah struk ke Dropbox: ' . $e->getMessage());
        }

        // Hapus file lokal setelah diunggah
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }



    /**
     * Fungsi untuk mengirimkan struk transaksi ke WhatsApp.
     */
    private function sendToWA($transaksi, $whatsappNumber)
    {
        $pdf = $this->generateReceiptPDF($transaksi);

        // Simpan sementara file PDF
        $localFilePath = storage_path("app/public/struk-transaksi-{$transaksi->id}.pdf");
        $pdf->save($localFilePath);

        // Pastikan folder di Dropbox ada
        try {
            $this->client->createFolder('/struk');
        } catch (\Spatie\Dropbox\Exceptions\BadRequest $e) {
            // Abaikan error jika folder sudah ada
        }

        // Unggah file ke Dropbox dan ambil link sementara
        $dropboxPath = "/struk/struk-transaksi-{$transaksi->id}.pdf";
        $this->client->upload($dropboxPath, file_get_contents($localFilePath), 'overwrite');
        $temporaryLink = $this->client->getTemporaryLink($dropboxPath);

        // Kirim ke WhatsApp menggunakan FonnteService
        $message = "Halo, berikut adalah link struk transaksi Anda dengan ID: {$transaksi->id}. Terima kasih telah berbelanja!\n\nLink Struk: {$temporaryLink}";
        $this->fonnteService->sendMessage($whatsappNumber, $message);

        // Hapus file lokal setelah selesai
        if (file_exists($localFilePath)) {
            unlink($localFilePath);
        }
    }


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

    public function nota($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Kirim data transaksi ke view nota
        return view('transaksi.nota', compact('transaksi'));
    }


    public function store(Request $request)
    {
        Log::info($request->all());

        $request->validate([
            'nama_pembeli' => 'required|string',
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

        // Panggil fungsi completeCart dan sendToWA
        $this->completeCart($transaksi);
        $this->sendToWA($transaksi, $request->input('nomor_whatsapp'));

        session()->forget('keranjang');

        return redirect()->route('transaksi.nota', ['id' => $transaksi->id]);
    }
}
