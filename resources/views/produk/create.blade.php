@extends('layouts.app')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="mb-3 mt-1">
            <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="card mb-2 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Produk</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" 
                               class="form-control @error('nama_produk') is-invalid @enderror" 
                               value="{{ old('nama_produk') }}" required>
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_produk" class="form-label">Harga Produk</label>
                        <input type="number" name="harga_produk" id="harga_produk" 
                               class="form-control @error('harga_produk') is-invalid @enderror" 
                               value="{{ old('harga_produk') }}" required>
                        @error('harga_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar_produk" class="form-label">Gambar Produk</label>
                        <input type="file" name="gambar_produk" id="gambar_produk" 
                               class="form-control @error('gambar_produk') is-invalid @enderror" 
                               accept="image/*">
                        @error('gambar_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="bahan" class="form-label">Bahan Terkait</label>
                        <select name="bahan[]" id="bahan" 
                                class="form-control bahan-select w-100 @error('bahan') is-invalid @enderror" 
                                multiple required>
                            @foreach ($bahan as $item)
                                <option value="{{ $item->id }}" {{ collect(old('bahan'))->contains($item->id) ? 'selected' : '' }}>
                                    {{ $item->nama_bahan }}
                                </option>
                            @endforeach
                        </select>
                        @error('bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tempat untuk input jumlah bahan terkait -->
                    <div class="mb-3" id="jumlah-bahan-container">
                        <!-- Kolom untuk jumlah bahan akan muncul di sini secara dinamis -->
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
                        <textarea name="deskripsi_produk" id="deskripsi_produk" 
                                  class="form-control @error('deskripsi_produk') is-invalid @enderror" 
                                  required>{{ old('deskripsi_produk') }}</textarea>
                        @error('deskripsi_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </form>
            </div>
        </div>
    </section>
@endsection
