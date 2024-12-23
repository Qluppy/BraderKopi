@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h4 class="text-blue h4">User Management</h4>
    </div>
    <div class="pb-20 px-3">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Tombol Tambah User -->
    <!-- Tombol Tambah User -->
<a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add User</a>


        <!-- Form Tambah User -->
       <!-- Form Tambah User -->
<div id="create-user-form" class="d-none">
    <h5>Create New User</h5>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="isAdmin" required>
                <option value="1">Admin</option>
                <option value="0">Kasir</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" id="cancel-create-user" class="btn btn-secondary">Cancel</button>
    </form>
</div>


        <!-- Tabel Daftar User -->
        <div id="user-table" class="table-responsive">
            <table class="table table-striped hover nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Is Admin</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->isAdmin ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->isAdmin ? 'Yes' : 'No' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                        <i class="dw dw-more"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ route('users.edit', $user) }}"><i class="dw dw-edit2"></i> Edit</a>
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure?')">
                                                <i class="dw dw-delete-3"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No users available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Event listener untuk tombol "Add User"
    document.getElementById('show-create-user').addEventListener('click', function () {
        console.log('Tombol Add User diklik');
        document.getElementById('create-user-form').classList.remove('d-none');
        document.getElementById('user-table').classList.add('d-none');
    });

    // Event listener untuk tombol "Cancel"
    document.getElementById('cancel-create-user').addEventListener('click', function () {
        document.getElementById('create-user-form').classList.add('d-none');
        document.getElementById('user-table').classList.remove('d-none');
    });
</script>
@endsection
