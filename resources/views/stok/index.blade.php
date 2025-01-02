@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row mb-3 mt-1">
            <div class="col-sm-6">
                <h1>Manajemen Stok Bahan</h1>
            </div>
            <div class="col-sm-6 d-flex justify-content-end">
                <!-- Tombol Tambah bahan baru -->
                <a href="{{ route('stok.create') }}" class="btn btn-success me-3">
                    Tambah Bahan
                </a>

                <!-- Form Pencarian -->
                <form action="{{ route('stok.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control" placeholder="Cari bahan..."
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

        <!-- Tabel Daftar Bahan dan Stok -->
        <div class="card mb-2 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Bahan</h5>
                <form action="{{ route('stok.index') }}" method="GET" class="d-flex align-items-center ms-auto">
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
                            <option value="newest" {{ request('filter') == 'newest' ? 'selected' : '' }}>Paling Baru
                            </option>
                            <option value="oldest" {{ request('filter') == 'oldest' ? 'selected' : '' }}>Paling Lama
                            </option>
                            <option value="lowest_stock" {{ request('filter') == 'lowest_stock' ? 'selected' : '' }}>Stok
                                Paling Sedikit</option>
                            <option value="highest_stock" {{ request('filter') == 'highest_stock' ? 'selected' : '' }}>Stok
                                Paling Banyak</option>
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
                                <th>Nama Bahan</th>
                                <th>Jumlah Stok</th>
                                <th>Satuan</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($stok as $item)
                                <tr>
                                    <td>{{ $item->masterBahan->nama_bahan }}</td>
                                    <td>{{ $item->jumlah_stok_tampilan }}</td>
                                    <td>{{ $item->satuan_tampilan }}</td>
                                    <td>{{ $item->masterBahan->deskripsi_bahan }}</td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modalEditBahan{{ $item->masterBahan->id }}">
                                            <i class="fas fa-edit"></i> <!-- Ikon Edit -->
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modalHapusBahan{{ $item->masterBahan->id }}">
                                            <i class="fas fa-trash-alt"></i> <!-- Ikon Hapus -->
                                        </button>

                                        <!-- Tombol Tambah Stok -->
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modalTambahStok{{ $item->masterBahan->id }}">
                                            <i class="fas fa-plus"></i> <!-- Ikon Tambah -->
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data bahan ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center py-0">
                <p class="my-3">
                    Menampilkan {{ $stok->count() }} dari {{ $stok->total() }} data.
                </p>
            
                <!-- Pagination dengan Bootstrap styling -->
                <div class="row mt-3 ml-auto">
                    {{ $stok->appends(['search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-4') }}
                </div>
            </div>
            
            
            
        </div>
    </section>

    <!-- Modal Edit Bahan -->
    @foreach ($stok as $item)
        <div class="modal fade" id="modalEditBahan{{ $item->masterBahan->id }}" tabindex="-1"
            aria-labelledby="modalEditBahanLabel{{ $item->masterBahan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditBahanLabel{{ $item->masterBahan->id }}">
                            Edit Bahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('stok.update', $item->masterBahan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                <input type="text" name="nama_bahan" id="nama_bahan" class="form-control"
                                    value="{{ $item->masterBahan->nama_bahan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi_bahan" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi_bahan" id="deskripsi_bahan" class="form-control">{{ $item->masterBahan->deskripsi_bahan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Hapus Bahan -->
        <div class="modal fade" id="modalHapusBahan{{ $item->masterBahan->id }}" tabindex="-1"
            aria-labelledby="modalHapusBahanLabel{{ $item->masterBahan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapusBahanLabel{{ $item->masterBahan->id }}">
                            Hapus Bahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus bahan
                            <strong>{{ $item->masterBahan->nama_bahan }}</strong>?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('stok.destroy', $item->masterBahan->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Stok -->
        <div class="modal fade" id="modalTambahStok{{ $item->masterBahan->id }}" tabindex="-1"
            aria-labelledby="modalTambahStokLabel{{ $item->masterBahan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahStokLabel{{ $item->masterBahan->id }}">
                            Tambah Stok Bahan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('stok.tambah') }}" method="POST">
                            @csrf
                            <input type="hidden" name="bahan_id" value="{{ $item->masterBahan->id }}">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <select name="satuan" id="satuan_tambah_stok{{ $item->masterBahan->id }}"
                                    class="form-control" required>
                                    @if ($item->masterBahan->jenis_bahan == 'cair')
                                        <option value="liter">Liter</option>
                                        <option value="mililiter">Mililiter</option>
                                    @elseif($item->masterBahan->jenis_bahan == 'padat')
                                        <option value="kilogram">Kilogram</option>
                                        <option value="gram">Gram</option>
                                    @else
                                        <option value="kilogram">Kilogram</option>
                                        <option value="gram">Gram</option>
                                        <option value="liter">Liter</option>
                                        <option value="mililiter">Mililiter</option>
                                    @endif
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                                <input type="number" name="jumlah_stok" id="jumlah_stok{{ $item->masterBahan->id }}"
                                    class="form-control" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-success">Tambah Stok</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Auto-hide alerts after 1 seconds
            setTimeout(function() {
                $('#success-alert, #error-alert').fadeOut();
            }, 200);
        });
    </script>
@endsection
