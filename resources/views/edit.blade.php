@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">Edit User</h4>
    </div>
    <div class="pb-20 px-3">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" placeholder="Leave blank if not changing">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="isAdmin" class="form-control">
                    <option value="0" {{ old('isAdmin', $user->isAdmin) == 0 ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('isAdmin', $user->isAdmin) == 1 ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
