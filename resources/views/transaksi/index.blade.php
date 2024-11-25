@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Transaksi Penjualan</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Transaksi -->
    <div class="row mb-4"> <!-- Mengurangi margin bottom dari 4 ke 3 -->
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Transaksi Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi.store') }}" method="POST" id="transaksiForm">
                        @csrf

                        <div class="mb-3">
                            <label for="produk" class="form-label">Pilih Produk</label>
                            <select class="form-select" id="produk" name="produk_id[]" required>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-harga="{{ $produk->harga_produk }}">
                                        {{ $produk->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah[]" value="1"
                                min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_pembeli" class="form-label">Nama Pembeli</label>
                            <input type="text" class="form-control" id="nama_pembeli" name="nama_pembeli" required>
                        </div>

                  
                        <h4>Total Harga: <span id="total_harga">0</span></h4>

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="cash">Cash</option>
                                <option value="qr_code">QR Code</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Selesaikan Transaksi</button>
                    </form>
                </div>
            </div>



            <!-- Daftar Produk yang Dipesan -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Produk Dipesan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="daftar_produk">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Daftar produk yang dipesan akan ditambahkan disini melalui JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const produkSelect = document.getElementById('produk');
        const jumlahInput = document.getElementById('jumlah');
        const totalHargaElement = document.getElementById('total_harga');
        const daftarProdukTableBody = document.getElementById('daftar_produk').querySelector('tbody');

        let totalHarga = 0;

        // Event Listener untuk menghitung total harga
        function updateTotal() {
            const selectedOption = produkSelect.options[produkSelect.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-harga'));
            const jumlah = parseInt(jumlahInput.value);
            const total = harga * jumlah;

            totalHarga += total;
            totalHargaElement.innerText = totalHarga.toFixed(2);

            // Menambahkan produk ke daftar yang dipesan
            const row = daftarProdukTableBody.insertRow();
            row.insertCell(0).innerText = selectedOption.innerText;
            row.insertCell(1).innerText = jumlah;
            row.insertCell(2).innerText = harga.toFixed(2);
            row.insertCell(3).innerText = total.toFixed(2);
        }

        // Mengupdate total harga saat jumlah diubah
        jumlahInput.addEventListener('input', function() {
            totalHarga = 0; // Reset total harga
            updateTotal();
        });

        // Mengupdate total harga saat produk dipilih
        produkSelect.addEventListener('change', function() {
            totalHarga = 0; // Reset total harga
            updateTotal();
        });
    </script>
    </div>
@endsection
