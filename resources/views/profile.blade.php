@extends('layouts.app')

@section('title')
    Profile
@endsection

@section('content')
    <div class="card-box mb-30">
        <div class="pd-20">
            <h4 class="text-blue h4">User Profile</h4>
        </div>
        <div class="pb-20 px-3">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="profile-image">
                        <!-- Gambar Profil -->
                        <img src="https://via.placeholder.com/150" alt="{{ $user->name }}" class="rounded-circle"
                            style="width: 150px; height: 150px;">
                    </div>
                    <h4 class="mt-3">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->username }}</p>
                </div>
                <div class="col-md-8">
                    <h5>Profile Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Is Admin:</strong>
                                @if ($user->isAdmin)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $user->created_at->format('d-m-Y H:i:s') }}</p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at->format('d-m-Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pd-20">
            <h4 class="text-blue h4">Edit Profile</h4>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h5>Update Profile</h5>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username', $user->username) }}" required>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('profile.change-password') }}" method="POST" class="mt-4">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <h5>Change Password</h5>
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" required>
                            @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                id="new_password_confirmation" name="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
