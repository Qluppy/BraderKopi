@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Penjualan</h1>
            </div>
        </div>
    </div>
</section>

<!-- Notifikasi di sini -->
@if(session('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger" id="error-alert">
        {{ session('error') }}
    </div>
@endif

<!-- Form untuk memilih periode laporan -->
<form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
    <div class="form-group">
        <label for="periode">Pilih Periode:</label>
        <select id="periode" name="periode" class="form-control">
            <option value="harian" {{ request('periode') == 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="bulanan" {{ request('periode') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ request('periode') == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan Laporan</button>
</form>

<!-- Tombol download laporan Excel -->
<div class="mt-4">
    <a href="{{ route('laporan.export', ['periode' => request('periode')]) }}" class="btn btn-success">Download Laporan Excel</a>
    <button id="download-graph" class="btn btn-info">Download Grafik PNG</button>
</div>

<!-- Grafik Penjualan -->
<div class="mt-4">
    <h4>Grafik Penjualan</h4>
    <canvas id="grafikPenjualan" width="400" height="200"></canvas>
</div>

<!-- Tabel Detail Penjualan -->
<div class="card mb-4 shadow-sm">
    <div class="card-header">
        <h5 class="card-title mb-0">Detail Penjualan</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualans as $penjualan)
                    <tr>
                        <td>{{ $penjualan->tanggal->format('d-m-Y') }}</td>
                        <td>{{ $penjualan->produk->nama_produk }}</td>
                        <td>{{ $penjualan->jumlah }}</td>
                        <td>Rp{{ number_format($penjualan->total_harga, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Chart.js untuk grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('grafikPenjualan').getContext('2d');
    const grafikPenjualan = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($label), // Labels untuk grafik
            datasets: [{
                label: 'Total Penjualan',
                data: @json($data), // Data untuk grafik
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Script untuk mendownload grafik sebagai PNG
    document.getElementById('download-graph').addEventListener('click', function() {
        const link = document.createElement('a');
        link.href = ctx.canvas.toDataURL('image/png');
        link.download = 'grafik-penjualan.png';
        link.click();
    });
</script>

@endsection
