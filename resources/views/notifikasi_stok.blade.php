@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notifikasi Stok</h2>

    <div class="alert alert-danger">
        <strong>Peringatan!</strong> Stok bahan tidak mencukupi untuk produk yang dipilih.
        Silakan periksa kembali bahan yang tersedia dan pastikan untuk menambah stok jika perlu.
    </div>

    <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali ke Halaman Transaksi</a>
</div>
@endsection
