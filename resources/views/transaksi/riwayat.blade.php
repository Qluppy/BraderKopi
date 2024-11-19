@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Transaksi</h2>

    <!-- Tabel Riwayat Transaksi -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Nama Pembeli</th>
                <th>Produk yang Dibeli</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->id }}</td>
                <td>{{ $transaksi->nama_pembeli }}</td>
                <td>
                    @foreach($transaksi->detailTransaksi as $detail)
                        {{ $detail->produk->nama_produk }} ({{ $detail->jumlah }})<br>
                    @endforeach
                </td>
                <td>{{ number_format($transaksi->total_harga, 2, ',', '.') }}</td>
                <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                <td>{{ $transaksi->created_at->format('d-m-Y H:i') }}</td>
                <td>
                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-info">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
