<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dewa Motor</title>
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />
    
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: { families: ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands"], urls: ["assets/css/fonts.min.css"] },
        active: function () { sessionStorage.fonts = true; },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <a href="index.html" class="logo">
            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
          </a>
        </div>
        <div class="sidebar-wrapper">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a href="#dashboard" data-bs-toggle="collapse">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('kendaraans.index') }}">
                <i class="fas fa-motorcycle"></i>
                <p>Kelola Kendaraan</p> <!-- Link menuju halaman kendaraans -->
              </a>
            </li>
            <!-- Add more sections as needed -->
          </ul>
        </div>
      </div>

      <!-- Main Panel -->
      <div class="main-panel">
        <div class="main-header">
          <div class="logo-header">
            <a href="index.html" class="logo">
              <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
          </div>
        </div>

        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left flex-column flex-md-row pt-2 pb-4">
              <div>
                <h3 class="fw-bold mb-3">Dashboard</h3>
                <h6 class="op-7 mb-2">Selamat Datang Di Database Dewa Motor</h6>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-icon">
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                          <i class="fas fa-motorcycle"></i> <!-- Ikon motor -->
                        </div>
                      </div>
                      <div class="col col-stats ms-3 ms-sm-0">
                        <div class="numbers">
                          <p class="card-category">Kendaraan</p> <!-- Label Kendaraan -->
                          <h4 class="card-title">{{ $totalKendaraan }}</h4> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Add more cards as needed -->
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card card-round">
                  <div class="card-header">
                    <h4 class="card-title">Data Kendaraan</h4> <!-- Judul diubah menjadi Data Kendaraan -->
                  </div>
                  <div class="card-body">
                    <table class="table table-striped table-bordered">
                      <thead class="table-primary">
                        <tr>
                          <th>Nomor Rangka</th>
                          <th>Nomor Mesin</th>
                          <th>Nomor Polisi</th>
                          <th>Merek</th>
                          <th>Model</th>
                          <th>Tahun Pembuatan</th>
                          <th>Harga Modal</th>
                          <th>Harga Jual</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kendaraans as $kendaraan)
                        <tr>
                          <td>{{ $kendaraan->nomor_rangka }}</td>
                          <td>{{ $kendaraan->nomor_mesin }}</td>
                          <td>{{ $kendaraan->nomor_polisi }}</td>
                          <td>{{ $kendaraan->merek }}</td>
                          <td>{{ $kendaraan->model }}</td>
                          <td>{{ $kendaraan->tahun_pembuatan }}</td>
                          <td>{{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                          <td>{{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- JS Files -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
  </body>
</html>
