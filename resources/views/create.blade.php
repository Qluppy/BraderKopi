@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pengguna</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="isAdmin">Apakah Admin?</label>
            <select class="form-control" id="isAdmin" name="isAdmin" required>
                <option value="1" {{ old('isAdmin') == 1 ? 'selected' : '' }}>Ya</option>
                <option value="0" {{ old('isAdmin') == 0 ? 'selected' : '' }}>Tidak</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
    </form>
</div>
@endsection
