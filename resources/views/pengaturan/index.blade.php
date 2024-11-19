@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pengaturan Aplikasi</h2>

    <!-- Form untuk mengubah informasi toko -->
    <form method="POST" action="{{ route('pengaturan.update') }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_toko">Nama Toko:</label>
            <input type="text" id="nama_toko" name="nama_toko" class="form-control" value="{{ $setting->nama_toko }}" required>
        </div>
        <div class="form-group">
            <label for="alamat_toko">Alamat Toko:</label>
            <input type="text" id="alamat_toko" name="alamat_toko" class="form-control" value="{{ $setting->alamat_toko }}" required>
        </div>
        <div class="form-group">
            <label for="nomor_telepon">Nomor Telepon:</label>
            <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" value="{{ $setting->nomor_telepon }}" required>
        </div>
        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select id="metode_pembayaran" name="metode_pembayaran[]" class="form-control" multiple>
                <option value="cash" {{ in_array('cash', $metode_pembayaran) ? 'selected' : '' }}>Cash</option>
                <option value="qr_code" {{ in_array('qr_code', $metode_pembayaran) ? 'selected' : '' }}>QR Code</option>
                <!-- Tambahkan metode pembayaran lainnya sesuai kebutuhan -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
    </form>

    <!-- Daftar Pengguna yang Dapat Mengakses Sistem -->
    <h4 class="mt-4">Daftar Pengguna</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Peran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('pengaturan.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
