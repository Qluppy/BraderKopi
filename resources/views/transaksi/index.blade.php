@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Keranjang Transaksi</h1>

    <!-- Form Pencarian Produk dengan Saran Otomatis -->
    <div class="position-relative mb-4">
        <input type="text" id="search" class="form-control" placeholder="Cari Produk..." autocomplete="off">
        <ul id="suggestions"></ul>
    </div>

    <!-- Keranjang Transaksi dan Form Penyelesaian Transaksi -->
    <div class="mt-5 d-flex justify-content-between">
        <!-- Tabel Keranjang -->
        <div style="flex: 2; margin-right: 20px;">
            <h3>Keranjang Belanja</h3>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="keranjangTableBody">
                        @php $total = 0; @endphp
                        @if(session('keranjang') && count(session('keranjang')) > 0)
                            @foreach(session('keranjang') as $key => $item)
                                <tr>
                                    <td>{{ $item['nama_produk'] }}</td>
                                    <td>
                                        <form action="{{ route('keranjang.update', $key) }}" method="POST" class="d-flex">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" class="form-control me-2" style="width: 80px;">
                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($item['harga_produk'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item['harga_produk'] * $item['jumlah'], 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('keranjang.hapus', $key) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $total += $item['harga_produk'] * $item['jumlah']; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Keranjang kosong.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <h4 class="text-end">Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
        </div>

        <!-- Form Penyelesaian Transaksi -->
        <div style="flex: 1;">
            <div class="card">
                <div class="card-header bg-success text-white">Selesaikan Transaksi</div>
                <div class="card-body">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                            <input type="text" name="nama_pembeli" id="nama_pembeli" placeholder="Nama Pembeli" required class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label for="nomor_whatsapp" class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" placeholder="Nomor WhatsApp" class="form-control" />
                        </div>
                        

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="qr_code">QR Code</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Selesaikan Transaksi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
