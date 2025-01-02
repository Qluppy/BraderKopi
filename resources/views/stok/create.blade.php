@extends('layouts.app')

@section('content')
    <!-- Content Header -->
    <section class="content-header">
        <div class="mb-3 mt-1">
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    
        <div class="card mb-2 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Tambah Bahan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('stok.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_bahan" class="form-label">Nama Bahan</label>
                        <input type="text" name="nama_bahan" id="nama_bahan" 
                               class="form-control @error('nama_bahan') is-invalid @enderror" 
                               value="{{ old('nama_bahan') }}" required>
                        @error('nama_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <label for="jenis_bahan" class="form-label">Jenis Bahan</label>
                        <select name="jenis_bahan" id="jenis_bahan" 
                                class="form-control @error('jenis_bahan') is-invalid @enderror">
                            <option value="padat" {{ old('jenis_bahan') == 'padat' ? 'selected' : '' }}>Padat</option>
                            <option value="cair" {{ old('jenis_bahan') == 'cair' ? 'selected' : '' }}>Cair</option>
                        </select>
                        @error('jenis_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select name="satuan" id="satuan" 
                                class="form-control @error('satuan') is-invalid @enderror" required>
                            <option value="kilogram" {{ old('satuan') == 'kilogram' ? 'selected' : '' }}>Kilogram</option>
                            <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>Gram</option>
                            <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                            <option value="mililiter" {{ old('satuan') == 'mililiter' ? 'selected' : '' }}>Mililiter</option>
                        </select>
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                        <input type="number" name="jumlah_stok" id="jumlah_stok" 
                               class="form-control @error('jumlah_stok') is-invalid @enderror" 
                               value="{{ old('jumlah_stok') }}" step="1" min="1" required>
                        @error('jumlah_stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="mb-3">
                        <label for="deskripsi_bahan" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi_bahan" id="deskripsi_bahan" 
                                  class="form-control @error('deskripsi_bahan') is-invalid @enderror" 
                                  required>{{ old('deskripsi_bahan') }}</textarea>
                        @error('deskripsi_bahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Bahan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Form Tambah Bahan -->




@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Optional: Additional JavaScript
        });
    </script>
@endsection
