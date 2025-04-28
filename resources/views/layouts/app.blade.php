<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dewa Motor')</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <a href="index.html" class="logo">
                    <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav nav-secondary">
                    <li class="nav-item">
                        <a href="{{ route('kendaraans.index') }}"> <!-- Ubah rute ke rute yang valid -->
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kendaraans.index') }}">
                            <i class="fas fa-motorcycle"></i>
                            <p>Kelola Kendaraan</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <div class="main-header">
                <div class="logo-header">
                    <a href="index.html" class="logo">
                        <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20">
                    </a>
                </div>
            </div>

            <div class="container">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container">
                    <p class="text-center">© 2023 Dewa Motor. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
</body>
</html>
