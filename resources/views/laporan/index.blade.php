@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Laporan Penjualan</h1>

    <!-- Form Filter -->
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
        <div class="form-row">
            <div class="col-md-3">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <!-- Tombol Export -->
                <a href="{{ route('laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                   class="btn btn-success">
                    Export Excel
                </a>
            </div>
        </div>
    </form>

    <!-- Total Penjualan -->
    <h2 class="my-4">Total Penjualan: Rp{{ number_format($totalPenjualan, 2) }}</h2>

    <!-- Tabel & Grafik Side by Side -->
    <div class="row">
        <!-- Tabel Rekap Penjualan -->
        <div class="col-md-6">
            <h3>Rekap Penjualan</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Total Terjual</th>
                            <th>Total Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapProduk as $item)
                            <tr>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->total_terjual }}</td>
                                <td>Rp {{ number_format($item->total_pendapatan, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Grafik Penjualan -->
        <div class="col-md-6">
            <h3>Grafik Penjualan</h3>
            <canvas id="salesChart" width="400" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar', // Menggunakan grafik batang
        data: {
            labels: @json($rekapProduk->pluck('nama_produk')), // Nama produk sebagai label
            datasets: [{
                label: 'Jumlah Terjual',
                data: @json($rekapProduk->pluck('total_terjual')), // Data jumlah terjual
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna latar batang
                borderColor: 'rgba(75, 192, 192, 1)', // Warna tepi batang
                borderWidth: 1,
                barThickness: 50, // Atur lebar batang lebih kecil
                maxBarThickness: 80 // Atur lebar maksimal batang
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
                        autoSkip: true // Menghindari label yang terlalu padat jika sedikit data
                    }
                }
            }
        }
    });
});
</script>
@endsection
