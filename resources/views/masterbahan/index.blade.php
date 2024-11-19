@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Bahan Baru</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('masterbahan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_bahan">Nama Bahan</label>
            <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="satuan">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="deskripsi_bahan">Deskripsi</label>
            <textarea name="deskripsi_bahan" id="deskripsi_bahan" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="jumlah_stok">Jumlah Stok</label>
            <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Tambah Bahan</button>
    </form>
</div>
@endsection
