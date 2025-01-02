@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-3 mt-1">
            <div class="col-sm-6">
                <h1>Manajemen Produk</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
                <!-- Tombol Tambah Produk Baru -->
                <a href="{{ route('produk.create') }}" class="btn btn-success me-3">
                    Tambah Produk
                </a>

                <!-- Form Pencarian -->
                <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..."
                        value="{{ request()->get('search') }}" onkeydown="if(event.key === 'Enter'){this.form.submit();}">
                </form>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" id="error-alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabel Daftar Produk -->
        <div class="card mb-2 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Produk</h5>
                <form action="{{ route('produk.index') }}" method="GET" class="d-flex align-items-center ms-auto">
                    <label for="per_page" class="mb-0 me-2" style="font-weight: normal;">Tampilkan:</label>
                    <select name="per_page" id="per_page" class="form-select me-3" onchange="this.form.submit()">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>

                    <div class="dropdown ms-3 position-relative">
                        <select name="filter" id="filter" class="form-select" onchange="this.form.submit()"
                            style="padding-left: 30px; min-width: 200px;">
                            <option value="newest" {{ request('filter') == 'newest' ? 'selected' : '' }}>Paling Baru</option>
                            <option value="oldest" {{ request('filter') == 'oldest' ? 'selected' : '' }}>Paling Lama</option>
                            <option value="lowest_price" {{ request('filter') == 'lowest_price' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="highest_price" {{ request('filter') == 'highest_price' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                        <i class="fas fa-filter position-absolute"
                            style="top: 50%; left: 10px; transform: translateY(-50%);"></i>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produk as $produkItem)
                                <tr>
                                    <td>{{ $produkItem->nama_produk }}</td>
                                    <td>Rp{{ number_format($produkItem->harga_produk, 2, ',', '.') }}</td>
                                    <td>
                                        @if ($produkItem->gambar_produk)
                                            <img src="{{ Storage::url($produkItem->gambar_produk) }}"
                                                alt="{{ $produkItem->nama_produk }}" style="width: 50px; height: 50px;">
                                        @else
                                            <i class="bi bi-image" style="font-size: 50px; color: gray;"></i>
                                        @endif
                                    </td>
                                    <td>{{ $produkItem->deskripsi_produk }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modalEditProduk{{ $produkItem->id }}">
                                            <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modalHapusProduk{{ $produkItem->id }}">
                                            <i class="fas fa-trash-alt"></i> <!-- Ikon Hapus -->
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data produk ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center py-0">
                <p class="my-3">
                    Menampilkan {{ $produk->count() }} dari {{ $produk->total() }} data.
                </p>

                <!-- Pagination dengan Bootstrap styling -->
                <div class="row mt-3 ml-auto">
                    {{ $produk->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination.custom') }}
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit Produk -->
    @foreach ($produk as $produkItem)
        <div class="modal fade" id="modalEditProduk{{ $produkItem->id }}" tabindex="-1"
            aria-labelledby="modalEditProdukLabel{{ $produkItem->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditProdukLabel{{ $produkItem->id }}">Edit
                            Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('produk.update', $produkItem->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk"
                                    value="{{ $produkItem->nama_produk }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_produk" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga_produk" name="harga_produk"
                                    value="{{ $produkItem->harga_produk }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="gambar_produk" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="gambar_produk" name="gambar_produk"
                                    accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_produk" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi_produk" id="deskripsi_produk" class="form-control" >{{ $produkItem->deskripsi_produk }}</textarea>
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
    @foreach ($produk as $produkItem)
        <div class="modal fade" id="modalHapusProduk{{ $produkItem->id }}" tabindex="-1"
            aria-labelledby="modalHapusProdukLabel{{ $produkItem->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusProdukLabel{{ $produkItem->id }}">
                            Hapus Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus produk
                            <strong>{{ $produkItem->nama_produk }}</strong>?
                        </p>
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
@endsection
