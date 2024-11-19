@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Transaksi - ID: {{ $transaksi->id }}</h2>

    <h4>Nama Pembeli: {{ $transaksi->nama_pembeli }}</h4>
    <h4>Total Harga: {{ number_format($transaksi->total_harga, 2, ',', '.') }}</h4>
    <h4>Metode Pembayaran: {{ ucfirst($transaksi->metode_pembayaran) }}</h4>
    <h4>Tanggal: {{ $transaksi->created_at->format('d-m-Y H:i') }}</h4>

    <!-- Tabel Detail Produk yang Dibeli -->
    <h4>Produk yang Dibeli</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->detailTransaksi as $detail)
            <tr>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td>{{ $detail->jumlah }}</td>
                <td>{{ number_format($detail->harga, 2, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
