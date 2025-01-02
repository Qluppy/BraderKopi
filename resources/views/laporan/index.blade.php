@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-3 mt-1">
            <div class="col-sm-6">
                <h1>Laporan Penjualan</h1>
            </div>
            <div class="col-sm-6">
                <!-- Filter Tanggal -->
                <form method="GET" action="{{ route('laporan.index') }}"
                    class="d-flex justify-content-end align-items-center">
                    <!-- Start Date -->
                    <div class="d-flex align-items-center mx-2">
                        <label for="start_date" class="mr-2">Start:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                            class="form-control">
                    </div>

                    <!-- End Date -->
                    <div class="d-flex align-items-center mx-2">
                        <label for="end_date" class="mr-2">End:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                            class="form-control">
                    </div>

                    <!-- Filter Button -->
                    <div class="d-flex align-items-center mx-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>






        <div class="row mb-4">
            <!-- Tabel Rekap Penjualan -->
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Judul Tabel di sebelah kiri -->
                        <h5 class="card-title mb-0">Rekap Penjualan</h5>

                        <!-- Dropdown dan tombol export di sebelah kanan -->
                        <div class="d-flex ml-auto">
                            <!-- Dropdown untuk memilih jumlah data per halaman (lebih kecil) -->
                            <form action="{{ route('laporan.index') }}" method="GET"
                                class="d-flex align-items-center ms-auto">
                                <label for="per_page" class="mb-0 me-2" style="font-weight: normal;">Tampilkan:</label>
                                <select name="per_page" id="per_page" class="form-select form-select-sm me-3"
                                    onchange="this.form.submit()">
                                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                                </select>
                            </form>

                            <!-- Tombol Export (lebih kecil) -->
                            <a href="{{ route('laporan.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                                class="btn btn-success btn-sm">Export Excel</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Terjual</th>
                                        <th>Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rekapProduk as $item)
                                        <tr>
                                            <td>{{ $item->nama_produk }}</td>
                                            <td>Rp {{ number_format($item->harga_produk, 2) }}</td>
                                            <td>{{ $item->total_terjual }}</td>
                                            <td>Rp {{ number_format($item->total_pendapatan, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data laporan ditemukan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    
                        <!-- Total Penjualan -->
                        <h5 class="mb-2">Total Penjualan: Rp{{ number_format($totalPenjualan, 2) }}</h5>
                    </div>
                    

                    <!-- Pagination -->
                    <div class="card-footer d-flex justify-content-between align-items-center py-0">
                        <p class="my-3">
                            Menampilkan {{ $rekapProduk->count() }} dari {{ $rekapProduk->total() }} data.
                        </p>

                        <!-- Pagination dengan Bootstrap styling -->
                        <div class="row mt-3 ml-auto">
                            {{ $rekapProduk->appends(['search' => request('search'), 'start_date' => request('start_date'), 'end_date' => request('end_date'), 'per_page' => request('per_page')])->links('pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>



            <!-- Grafik Penjualan -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Grafik Penjualan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="salesChart" width="400" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($rekapProduk->pluck('nama_produk')),
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: @json($rekapProduk->pluck('total_terjual')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1  // Setiap kenaikan pada sumbu Y adalah 1
                            }
                        },
                        x: {
                            autoSkip: true
                        },
                    },
                }
            });
        });
    </script>
    
@endsection
