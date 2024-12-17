<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DropboxController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MasterBahanController;
use App\Http\Controllers\DetailTransaksiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});


// Route untuk halaman login
// Rute autentikasi
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/registrasi', function () {
    return view('registrasi');
})->name('registrasi');


Route::post('/registrasi', [AkunController::class, 'registrasi'])->name('registrasi.submit');

Route::post('/login', [AkunController::class, 'login']);
Route::get('/logout', [AkunController::class, 'logout']);
Route::post('/logout', [AkunController::class, 'logout'])->name('logout');

// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});

// Route untuk halaman stok
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::post('/stok/tambah', [StokController::class, 'tambahStok'])->name('stok.tambah');
Route::resource('stok', StokController::class);

// Route master bahan
Route::get('/masterbahan', [MasterBahanController::class, 'index'])->name('masterbahan.index');
Route::post('/masterbahan', [MasterBahanController::class, 'store'])->name('masterbahan.store');
Route::resource('masterbahan', MasterBahanController::class);

// Route untuk halaman produk
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');


// Route untuk halaman transaksi
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/transaksi/cari-produk', [TransaksiController::class, 'cariProduk'])->name('transaksi.cari-produk');
Route::post('/keranjang/tambah/{id}', [TransaksiController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
Route::put('/keranjang/update/{produk_id}', [TransaksiController::class, 'updateKeranjang'])->name('keranjang.update');
Route::delete('/keranjang/hapus/{produk_id}', [TransaksiController::class, 'hapusDariKeranjang'])->name('keranjang.hapus');
Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');

// Route untuk halaman riwayat transaksi
Route::get('/riwayat-transaksi', [TransaksiController::class, 'riwayat'])->name('transaksi.riwayat');
Route::get('/riwayat-transaksi/{id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');

// Route untuk halaman laporan penjualan
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');



// Route untuk halaman pengaturan
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update'); // Rute update

// Route untuk halaman notifikasi stok
Route::get('/notifikasi-stok', function () {
    return view('notifikasi_stok');
})->name('notifikasi.stok');

// kelola akun
Route::middleware(['auth'])->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index'); // Daftar akun
    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit'); // Edit akun
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update'); // Update akun
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy'); // Hapus akun   
});


//dropbox
// Route::get('/dropbox', [DropboxController::class, 'showUploadForm']);

// Route::get('/dropbox/create-folder/{path}', [DropboxController::class, 'createFolder']);
// Route::get('/dropbox/list/{path?}', [DropboxController::class, 'listFolder']);
// Route::post('/dropbox/upload', [LaporanController::class, 'uploadToDropbox']);
// Route::get('/dropbox/temporary-link/{filePath}', [DropboxController::class, 'getTemporaryLink']);
// Route::get('/dropbox/move/{from}/{to}', [DropboxController::class, 'moveFile']);

