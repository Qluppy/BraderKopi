<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brader Kopi</title>

    <!-- CSS Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Inline Custom Styles -->
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
        <!-- Navbar -->
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
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="btn btn-default btn-flat float-right">Sign out</a>
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
                <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png"
                    class="brand-image img-circle elevation-3" alt="Logo">
                <span class="brand-text font-weight-light">Brader Kopi</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        @if (Auth::user()->isAdmin)
                            <li class="nav-item">
                                <a href="{{ route('stok.index') }}"
                                    class="nav-link {{ Request::routeIs('stok.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box"></i>
                                    <p>Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('produk.index') }}"
                                    class="nav-link {{ Request::routeIs('produk.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cubes"></i>
                                    <p>Produk</p>
                                </a>
                            </li>
                            <li
                                class="nav-item has-treeview {{ Request::routeIs('result', 'laporan.index') ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ Request::routeIs('result', 'laporan.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>
                                        Laporan Penjualan
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('result') }}" class="nav-link">
                                            <i
                                                class="{{ Request::routeIs('result') ? 'fas fa-circle text-white' : 'far fa-circle' }} nav-icon"></i>
                                            <p class="{{ Request::routeIs('result') ? 'text-white' : '' }}">SAW</p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('laporan.index') }}" class="nav-link">
                                            <i
                                                class="{{ Request::routeIs('laporan.index') ? 'fas fa-circle text-white' : 'far fa-circle' }} nav-icon"></i>
                                            <p class="{{ Request::routeIs('result') ? 'text-white' : '' }}">Laporan</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link {{ Request::routeIs('users.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Pengguna</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('transaksi.index') }}"
                                class="nav-link {{ Request::routeIs('transaksi.index') ? 'active' : '' }}">
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

    <!-- JS Dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}?v={{ time() }}"></script>

    @stack('scripts')
</body>

</html>
