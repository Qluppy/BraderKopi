@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Informasi Ringkasan -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Produk</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $totalProduk }} Produk</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Total Bahan</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $totalBahan }} Bahan</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transaksi Hari Ini</h3>
                    </div>
                    <div class="card-body">
                        <p>{{ $transaksiHariIni }} Transaksi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terlaris -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Produk Terlaris</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Jumlah Terjual</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produkTerlaris as $produk)
        <tr>
            <td>{{ $produk->nama_produk }}</td>
            <td>{{ $produk->detailtransaksi_count }} kali terjual</td>
        </tr>
        @endforeach
    </tbody>
</table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Menipis -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Stok Bahan Menipis</h3>
                    </div>
                    <div class="card-body">
                        @if($stokMenipis->isEmpty())
                            <p class="text-success">Semua bahan cukup.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Bahan</th>
                                        <th>Jumlah Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stokMenipis as $bahan)
                                    <tr>
                                        <td>{{ $bahan->nama_bahan }}</td>
                                        <td>{{ $bahan->jumlah_stok }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
