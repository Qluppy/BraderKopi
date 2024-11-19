@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Bahan</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Edit Bahan -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('masterbahan.update', $bahan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_bahan">Nama Bahan</label>
                            <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $bahan->satuan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="jumlah_stok">Jumlah Stok</label>
                            <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" value="{{ $bahan->jumlah_stok }}" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control">{{ $bahan->deskripsi_bahan }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Perbarui Bahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
