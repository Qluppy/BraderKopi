@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Manajemen Stok Bahan</h1>
            </div>
        </div>
    </div>
</section>

    <!-- Notifikasi -->
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

    <!-- Tabel Daftar Bahan dan Stok -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Daftar Bahan</h5>
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
                        @foreach($stok as $item)
                        <tr>
                            <td>{{ $item->masterBahan->nama_bahan }}</td>
                            <td>{{ $item->jumlah_stok }}</td>
                            <td>{{ $item->masterBahan->satuan }}</td>
                            <td>{{ $item->masterBahan->deskripsi_bahan }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditBahan{{ $item->masterBahan->id }}">
                                    Edit
                                </button>
                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapusBahan{{ $item->masterBahan->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Bahan -->
                        <div class="modal fade" id="modalEditBahan{{ $item->masterBahan->id }}" tabindex="-1" aria-labelledby="modalEditBahanLabel{{ $item->masterBahan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditBahanLabel{{ $item->masterBahan->id }}">Edit Bahan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('masterbahan.update', $item->masterBahan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                                <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ $item->masterBahan->nama_bahan }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="satuan" class="form-label">Satuan</label>
                                                <select name="satuan" id="satuan" class="form-control" required>
                                                    <option value="kilogram" {{ $item->masterBahan->satuan == 'kilogram' ? 'selected' : '' }}>Kilogram</option>
                                                    <option value="gram" {{ $item->masterBahan->satuan == 'gram' ? 'selected' : '' }}>Gram</option>
                                                    <option value="liter" {{ $item->masterBahan->satuan == 'liter' ? 'selected' : '' }}>Liter</option>
                                                    <option value="mililiter" {{ $item->masterBahan->satuan == 'mililiter' ? 'selected' : '' }}>Mililiter</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi_bahan" class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi_bahan" id="deskripsi_bahan" class="form-control">{{ $item->masterBahan->deskripsi_bahan }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                                                <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" value="{{ $item->jumlah_stok }}" min="0" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Hapus Bahan -->
                        <div class="modal fade" id="modalHapusBahan{{ $item->masterBahan->id }}" tabindex="-1" aria-labelledby="modalHapusBahanLabel{{ $item->masterBahan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalHapusBahanLabel{{ $item->masterBahan->id }}">Hapus Bahan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus bahan <strong>{{ $item->masterBahan->nama_bahan }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('masterbahan.destroy', $item->masterBahan->id) }}" method="POST">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah Stok -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah Stok Bahan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('stok.tambah') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="bahan_id" class="form-label">Pilih Bahan</label>
                            <select name="bahan_id" id="bahan_id" class="form-control" required>
                                <option value="">-- Pilih Bahan --</option>
                                @foreach($stok as $item)
                                    <option value="{{ $item->masterBahan->id }}">{{ $item->masterBahan->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                            <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select name="satuan" id="satuan" class="form-control" required>
                                <option value="kilogram">Kilogram</option>
                                <option value="gram">Gram</option>
                                <option value="liter">Liter</option>
                                <option value="mililiter">Mililiter</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Tambah Stok</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Opsi Tambah Bahan Baru -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h5 class="card-title mb-0">Tambah Bahan Baru</h5>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalTambahBahan">
                        Tambah Bahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Bahan Baru -->
<div class="modal fade" id="modalTambahBahan" tabindex="-1" aria-labelledby="modalTambahBahanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahBahanLabel">Tambah Bahan Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('masterbahan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_bahan" class="form-label">Nama Bahan</label>
                        <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select name="satuan" id="satuan" class="form-control" required>
                            <option value="kilogram">Kilogram</option>
                            <option value="gram">Gram</option>
                            <option value="liter">Liter</option>
                            <option value="mililiter">Mililiter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi_bahan" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi_bahan" id="deskripsi_bahan" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Bahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-hide alerts after 3 seconds
        setTimeout(function() {
            $('#success-alert, #error-alert').fadeOut();
        }, 3000);
    });
</script>
@endsection
