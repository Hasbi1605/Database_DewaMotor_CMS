<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dewa Motor')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/layouts/app.css') }}">

    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-wrapper">
                <div class="sidebar-header text-center p-3">
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <i class="fas fa-motorcycle fa-2x me-2" style="color: rgba(255, 255, 255, 0.95);"></i>
                        <h1 style="color: rgba(255, 255, 255, 0.95); font-size: 24px; font-weight: bold; margin: 0;">Dewa Motor</h1>
                    </div>
                    <small style="color: rgba(255, 255, 255, 0.7); font-size: 12px;">database management</small>
                </div>
                <!-- Divider -->
                <hr class="sidebar-divider">
                <ul class="nav nav-secondary">
                    <li class="nav-item">
                        <a href="/" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kendaraans.index') }}" class="nav-link">
                            <i class="fas fa-motorcycle"></i>
                            <p>Kelola Kendaraan</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="container py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/kaiadmin.js"></script>
</body>
</html>
