<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brader Kopi</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <!-- icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <style>
        .select2-container .select2-selection--multiple {
            height: auto;
            min-height: 38px;
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="https://via.placeholder.com/150" class="user-image img-circle" alt="User Image">
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="https://via.placeholder.com/150" class="img-circle" alt="User Image">
                            <p>{{ Auth::user()->name }} - Role</p>
                        </li>
                        <li class="user-footer">
                            <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat float-right">Sign out</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

       <!-- Sidebar -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" class="brand-image img-circle elevation-3" alt="Logo">
        <span class="brand-text font-weight-light">Brader Kopi</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Menu Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Menu untuk Admin -->
                @if(Auth::user()->isAdmin)
                <li class="nav-item">
                    <a href="{{ route('stok.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Stok</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cubes"></i>
                        <p>Produk</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i> <!-- Ikon untuk SAW -->
                        <p>
                            Laporan Penjualan
                            <i class="right fas fa-angle-left"></i> <!-- Ikon dropdown -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('result') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SAW</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('laporan.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('akun.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Kelola Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-power"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i> <!-- Ikon pengguna -->
                        <p>Pengguna</p>
                    </a>
                </li>
                @endif

                <!-- Menu untuk Semua Pengguna -->
                <li class="nav-item">
                    <a href="{{ route('transaksi.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Transaksi</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <strong>Copyright &copy; 2024 <a href="#">Brader Kopi</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       // Script untuk menghilangkan notifikasi setelah 5 detik
       setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
            if (errorAlert) {
                errorAlert.style.display = 'none';
            }
        }, 5000);

        $(document).ready(function() {
        // Inisialisasi Select2
        $('#bahan').select2({
            placeholder: "Pilih bahan",
            allowClear: true,
            closeOnSelect: false
        });

        // Event saat bahan dipilih
        $('#bahan').on('change', function() {
            let selectedBahan = $(this).val();
            let container = $('#jumlah-bahan-container');
            container.empty();

            if (selectedBahan && selectedBahan.length > 0) {
                selectedBahan.forEach(function(bahanId) {
                    let bahanText = $('#bahan option[value="' + bahanId + '"]').text();

                    container.append(`
                        <div class="mb-3">
                            <label for="jumlah_bahan_${bahanId}" class="form-label">Jumlah ${bahanText}</label>
                            <input type="number" class="form-control" id="jumlah_bahan_${bahanId}" name="jumlah_stok[]" placeholder="Masukkan jumlah ${bahanText}" required>
                        </div>
                    `);
                });
            }
        });

        // Menambahkan event listener untuk input pencarian
        $('#search').on('input', function() {
            const query = $(this).val();
            const suggestions = $('#suggestions');

            if (query.length > 0) {
                $.ajax({
                    url: `/transaksi/cari-produk`,
                    type: 'GET',
                    data: { query: query },
                    success: function(data) {
                        let html = '';
                        data.forEach(function(item) {
                            html += `
                                <li class="list-group-item d-flex justify-content-between align-items-center" 
                                    style="cursor: pointer;" 
                                    data-id="${item.id}" 
                                    data-nama="${item.nama_produk}" 
                                    data-harga="${item.harga_produk}">
                                    ${item.nama_produk} - Rp ${item.harga_produk}
                                </li>
                            `;
                        });
                        suggestions.html(html).show();
                    }
                });
            } else {
                suggestions.hide();
            }
        });

        // Menangani klik pada saran produk
        $('#suggestions').on('click', 'li', function() {
            const idProduk = $(this).data('id');
            const namaProduk = $(this).data('nama');
            const hargaProduk = $(this).data('harga');

            // Menambahkan produk ke keranjang
            $.ajax({
                url: `/keranjang/tambah/${idProduk}`,
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    id: idProduk,
                    nama_produk: namaProduk,
                    harga_produk: hargaProduk,
                    jumlah: 1
                }),
                success: function() {
                    // Menyembunyikan saran dan mengosongkan kolom pencarian
                    $('#search').val('');
                    $('#suggestions').hide();

                    // Refresh halaman untuk memperbarui keranjang
                    location.reload();
                }
            });
        });
    });
    </script>

    @stack('scripts')
</body>
</html>