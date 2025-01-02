@if (!isset($isPdf) || !$isPdf)
    @extends('layouts.app')
@endif

@section('content')
<div class="container">
    <div class="header text-center mb-4">
        <h1>Nota Transaksi</h1>
        <p>Brader Kopi - Jl. Pintas Sambangan, Angsau, Pelaihari</p>
    </div>

    <div class="details mb-4">
        <p><strong>ID Transaksi:</strong> {{ $transaksi->id }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal_transaksi }}</p>
        <p><strong>Nama Pembeli:</strong> {{ $transaksi->nama_pembeli }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $detail)
                <tr>
                    <td>{{ $detail->produk->nama_produk }}</td>
                    <td>{{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="text-right font-weight-bold">Total Harga: Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

    <p class="text-center">Terima kasih telah berbelanja di Brader Kopi!</p>

    <div class="mb-3 mt-1">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>
@endsection
