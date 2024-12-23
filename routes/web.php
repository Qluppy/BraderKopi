<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController, StokController, ProdukController, 
    TransaksiController, LaporanController, PengaturanController, 
    MasterBahanController, UserController, SawController
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

    // Master Bahan Routes
    Route::get('/masterbahan', [MasterBahanController::class, 'index'])->name('masterbahan.index');
    Route::post('/masterbahan', [MasterBahanController::class, 'store'])->name('masterbahan.store');
    Route::resource('masterbahan', MasterBahanController::class);

    // Produk Routes
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

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    // Notifikasi Stok
    Route::get('/notifikasi-stok', function () {
        return view('notifikasi_stok');
    })->name('notifikasi.stok');

    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
