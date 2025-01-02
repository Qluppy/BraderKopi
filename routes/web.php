<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\DropboxController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\MasterBahanController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\{
    AuthController,
    SawController
};

// Rute dengan Middleware Auth
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');

    // Dashboard Routes
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/saw', [SawController::class, 'index'])->name('saw.index');
    Route::get('/result', [SawController::class, 'calculate'])->name('result');
    Route::get('/saw/calculate', [SawController::class, 'calculate'])->name('saw.calculate');
    // Stok Routes
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    Route::post('/stok/tambah', [StokController::class, 'tambahStok'])->name('stok.tambah');
    Route::resource('stok', StokController::class);
    Route::get('/stok/create', [StokController::class, 'create'])->name('stok.create');
    Route::post('/stok', [StokController::class, 'store'])->name('stok.store');

    // Route untuk halaman produk
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');


    // Pengaturan Routes
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');

    // Route untuk halaman transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/cari-produk', [TransaksiController::class, 'cariProduk'])->name('transaksi.cari-produk');
    Route::post('/keranjang/tambah/{id}', [TransaksiController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');
    Route::put('/keranjang/update/{produk_id}', [TransaksiController::class, 'updateKeranjang'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{produk_id}', [TransaksiController::class, 'hapusDariKeranjang'])->name('keranjang.hapus');
    Route::post('/transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/nota/{id}', [TransaksiController::class, 'nota'])->name('transaksi.nota');

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    // Notifikasi Stok
    Route::get('/notifikasi-stok', function () {
        return view('notifikasi_stok');
    })->name('notifikasi.stok');

    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update'); // Bukan `users.edit`
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
