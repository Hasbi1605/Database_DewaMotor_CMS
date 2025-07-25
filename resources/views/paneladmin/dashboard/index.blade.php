@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="card fade-in">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-2">Selamat Datang di Dashboard Admin</h4>
                <p class="text-muted mb-0">Kelola database kendaraan Dewa Motor dengan mudah dan efisien</p>
            </div>
            <div class="text-end">
                <small class="text-muted">{{ date('d F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="row g-4">
    <!-- Total Kendaraan -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card hover-card">
            <div class="stats-icon primary">
                <i class="fas fa-motorcycle"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $totalKendaraan }}</h3>
                <p class="text-muted mb-0">Total Kendaraan</p>
            </div>
        </div>
    </div>
    
    <!-- Kendaraan Tersedia -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card hover-card">
            <div class="stats-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $totalKendaraan - $totalTerjual }}</h3>
                <p class="text-muted mb-0">Kendaraan Tersedia</p>
            </div>
        </div>
    </div>
    
    <!-- Kendaraan Terjual -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card hover-card">
            <div class="stats-icon danger">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div>
                <h3 class="mb-1">{{ $totalTerjual }}</h3>
                <p class="text-muted mb-0">Kendaraan Terjual</p>
            </div>
        </div>
    </div>
    
    <!-- Total Keuntungan -->
    <div class="col-lg-3 col-md-6">
        <div class="stats-card hover-card">
            <div class="stats-icon warning">
                <i class="fas fa-coins"></i>
            </div>
            <div>
                <h3 class="mb-1">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                <p class="text-muted mb-0">Total Keuntungan</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row g-4 mt-2">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Ringkasan Aktivitas
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="stats-icon primary me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Tambah Kendaraan</h6>
                                <a href="{{ route('kendaraans.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Baru
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <div class="stats-icon success me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Kelola Dokumen</h6>
                                <a href="{{ route('dokumen-kendaraans.index') }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-folder me-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-link me-2"></i>
                    Akses Cepat
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('store.index') }}" class="btn btn-outline-primary" target="_blank">
                        <i class="fas fa-store me-2"></i>
                        Lihat Halaman Store
                    </a>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-tags me-2"></i>
                        Kelola Kategori
                    </a>
                    <a href="{{ route('admin.token-info') }}" class="btn btn-outline-warning">
                        <i class="fas fa-key me-2"></i>
                        Token Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Vehicles Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-motorcycle me-2"></i>
                    Kendaraan Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if(isset($kendaraans) && $kendaraans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kendaraan</th>
                                    <th>Nomor Polisi</th>
                                    <th>Tahun</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kendaraans->take(5) as $index => $kendaraan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($kendaraan->photos && count($kendaraan->photos) > 0)
                                                <img src="{{ asset('storage/' . $kendaraan->photos[0]) }}" 
                                                     alt="Foto {{ $kendaraan->merek }}" 
                                                     class="img-thumbnail me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $kendaraan->merek }} {{ $kendaraan->model }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $kendaraan->nomor_polisi }}</td>
                                    <td>{{ $kendaraan->tahun_pembuatan }}</td>
                                    <td>
                                        <span class="fw-semibold text-success">
                                            Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $kendaraan->status == 'tersedia' ? 'success' : 'danger' }}">
                                            {{ ucfirst($kendaraan->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('kendaraans.show', $kendaraan->id) }}" 
                                               class="btn btn-sm btn-primary" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada kendaraan yang tersedia</h6>
                        <a href="{{ route('kendaraans.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Kendaraan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Section Kendaraan Tersedia Detail -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-motorcycle me-2"></i>
                    Kendaraan Tersedia Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if(isset($kendaraans) && $kendaraans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Polisi</th>
                                    <th>Nomor Rangka</th>
                                    <th>Nomor Mesin</th>
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Tahun</th>
                                    <th>Harga Jual</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($kendaraans->currentPage() - 1) * $kendaraans->perPage() + 1; @endphp
                                @foreach($kendaraans as $kendaraan)
                                <tr>
                                    <!-- Nomor Urut -->
                                    <td>{{ $no++ }}</td>
                                    
                                    <!-- Data Identitas Kendaraan -->
                                    <td>{{ $kendaraan->nomor_polisi }}</td>
                                    <td>{{ $kendaraan->nomor_rangka }}</td>
                                    <td>{{ $kendaraan->nomor_mesin }}</td>
                                    <td>{{ $kendaraan->merek }}</td>
                                    <td>{{ $kendaraan->model }}</td>
                                    <td>{{ $kendaraan->tahun_pembuatan }}</td>
                                    
                                    <!-- Harga Jual dengan Format Rupiah -->
                                    <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                                    
                                    <!-- Tombol Aksi Lihat Detail -->
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination untuk Kendaraan Tersedia -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $kendaraans->firstItem() ?? 0 }} sampai {{ $kendaraans->lastItem() ?? 0 }} dari {{ $kendaraans->total() }} kendaraan tersedia
                        </div>
                        <div>
                            {{ $kendaraans->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada kendaraan yang tersedia</h6>
                        <a href="{{ route('kendaraans.create') }}" class="btn btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Kendaraan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Section Kendaraan Terjual -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card" id="kendaraanTerjual">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-check me-2"></i>
                    Kendaraan Terjual
                </h5>
            </div>
            <div class="card-body">
                @if(isset($kendaraanTerjual) && $kendaraanTerjual->count() > 0)
                    <!-- Tabel Kendaraan Terjual -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Polisi</th>
                                    <th>Merek & Model</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                    <th>Keuntungan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = ($kendaraanTerjual->currentPage() - 1) * $kendaraanTerjual->perPage() + 1; @endphp
                                @foreach($kendaraanTerjual as $kendaraan)
                                <tr>
                                    <!-- Nomor Urut -->
                                    <td>{{ $no++ }}</td>
                                    
                                    <!-- Data Kendaraan -->
                                    <td>{{ $kendaraan->nomor_polisi }}</td>
                                    <td>{{ $kendaraan->merek }} {{ $kendaraan->model }}</td>
                                    
                                    <!-- Harga dengan Format Rupiah -->
                                    <td>Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                                    
                                    <!-- Keuntungan (Harga Jual - Harga Modal) -->
                                    <td>Rp {{ number_format($kendaraan->getProfit(), 0, ',', '.') }}</td>
                                    
                                    <!-- Tombol Aksi Lihat Detail -->
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination untuk Kendaraan Terjual -->
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $kendaraanTerjual->firstItem() ?? 0 }} sampai {{ $kendaraanTerjual->lastItem() ?? 0 }} dari {{ $kendaraanTerjual->total() }} kendaraan terjual
                        </div>
                        <div>
                            {{ $kendaraanTerjual->appends(request()->query())->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Belum ada kendaraan yang terjual</h6>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/layouts/home.css') }}">
@endpush
