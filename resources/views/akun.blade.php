@extends('layouts.app') <!-- Gunakan layout yang sesuai -->

@section('content')
    <h1>Daftar Akun</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('akun.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('akun.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
