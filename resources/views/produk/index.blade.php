@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Produk</h1>
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

    <!-- Tabel Daftar Produk -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Produk</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $produkItem)
                        <tr>
                            <td>{{ $produkItem->nama_produk }}</td>
                            <td>Rp{{ number_format($produkItem->harga_produk, 2, ',', '.') }}</td>
                            <td>
                                @if($produkItem->gambar_produk)
                                    <img src="{{ Storage::url($produkItem->gambar_produk) }}" alt="{{ $produkItem->nama_produk }}" style="width: 50px; height: 50px;">
                                @else
                                    <i class="bi bi-image" style="font-size: 50px; color: gray;"></i>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditProduk{{ $produkItem->id }}">
                                    Edit
                                </button>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusProduk{{ $produkItem->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Produk -->
                        @foreach($produk as $produkItem)
                        <div class="modal fade" id="modalEditProduk{{ $produkItem->id }}" tabindex="-1" aria-labelledby="modalEditProdukLabel{{ $produkItem->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditProdukLabel{{ $produkItem->id }}">Edit Produk</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('produk.update', $produkItem->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ $produkItem->nama_produk }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="harga_produk" class="form-label">Harga</label>
                                                <input type="number" class="form-control" id="harga_produk" name="harga_produk" value="{{ $produkItem->harga_produk }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                                <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- End of Modal Edit Produk -->

                        <!-- Modal Hapus Produk -->
                        @foreach($produk as $produkItem)
                        <div class="modal fade" id="modalHapusProduk{{ $produkItem->id }}" tabindex="-1" aria-labelledby="modalHapusProdukLabel{{ $produkItem->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusProdukLabel{{ $produkItem->id }}">Hapus Produk</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus produk <strong>{{ $produkItem->nama_produk }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('produk.destroy', $produkItem->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!-- End of Modal Hapus Produk -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Form Input Produk Baru -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah Produk Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_produk" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga_produk" name="harga_produk" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar_produk" name="gambar_produk" accept="image/*">
                        </div>
                        <div class="mb-3 ">
                            <label for="bahan" class="form-label">Bahan Terkait</label>
                            <select class="form-select bahan-select w-100" id="bahan" name="bahan[]" multiple required>
                                @foreach($bahan as $item)
                                    <option value="{{ $item->id }}  ">{{ $item->nama_bahan }} </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tempat untuk input jumlah bahan terkait -->
                        <div class="mb-3" id="jumlah-bahan-container">
                            <!-- Kolom untuk jumlah bahan akan muncul di sini secara dinamis -->
                        </div>

                        <button type="submit" class="btn btn-success">Tambah Produk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection