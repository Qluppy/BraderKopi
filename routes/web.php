<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MasterBahanController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});


// Route untuk halaman login


// Route untuk dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

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


Route::post('/register', [UserController::class,'register']);

Route::post('/logout', [UserController::class, 'logout']);

Route::post('/login', [UserController::class, 'login']);
