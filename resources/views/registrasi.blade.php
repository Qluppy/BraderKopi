<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Brader Kopi</title>
    <!-- Tambahkan Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom right, #4caf50, #81c784);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="card shadow" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h1 class="text-center mb-4 text-success">BRADER KOPI</h1>
            <h4 class="text-center mb-4">Registrasi</h4>

            <!-- Validasi Error -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Registrasi -->
            <form action="/registrasi" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        class="form-control @error('username') is-invalid @enderror" 
                        placeholder="Masukkan username" 
                        value="{{ old('username') }}" 
                        required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="Masukkan password" 
                        required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select 
                        name="role" 
                        id="role" 
                        class="form-select" 
                        required>
                        <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
