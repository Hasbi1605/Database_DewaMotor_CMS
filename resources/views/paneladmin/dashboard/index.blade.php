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

<!-- Vehicle Category Composition Chart with Pagination -->
<div class="row g-4 mt-2">
    <!-- Komposisi Kendaraan per Kategori -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    <span id="chartTitle">Komposisi Kendaraan berdasarkan Kategori Kelas</span>
                </h5>
                
                <!-- Category Navigation Tabs -->
                <div class="category-nav">
                    <ul class="nav nav-pills nav-sm" id="categoryTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="class-tab" data-bs-toggle="pill" data-bs-target="#class-chart" 
                                    type="button" role="tab" aria-controls="class-chart" aria-selected="true" 
                                    data-title="Komposisi Kendaraan berdasarkan Kategori Kelas">
                                <i class="fas fa-layer-group me-1"></i>Kelas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="brand-tab" data-bs-toggle="pill" data-bs-target="#brand-chart" 
                                    type="button" role="tab" aria-controls="brand-chart" aria-selected="false"
                                    data-title="Komposisi Kendaraan berdasarkan Kategori Merek">
                                <i class="fas fa-trademark me-1"></i>Merek
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="document-tab" data-bs-toggle="pill" data-bs-target="#document-chart" 
                                    type="button" role="tab" aria-controls="document-chart" aria-selected="false"
                                    data-title="Komposisi Kendaraan berdasarkan Kelengkapan Dokumen">
                                <i class="fas fa-file-alt me-1"></i>Dokumen
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="condition-tab" data-bs-toggle="pill" data-bs-target="#condition-chart" 
                                    type="button" role="tab" aria-controls="condition-chart" aria-selected="false"
                                    data-title="Komposisi Kendaraan berdasarkan Kondisi Kendaraan">
                                <i class="fas fa-tools me-1"></i>Kondisi
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Chart Container -->
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="vehiclesByCategoryChart"></canvas>
                </div>
                
                <!-- Tab Content for Statistics -->
                <div class="tab-content mt-3" id="categoryTabContent">
                    <!-- Class Categories Statistics -->
                    <div class="tab-pane fade show active" id="class-chart" role="tabpanel" aria-labelledby="class-tab">
                        <div class="row">
                            @forelse($vehiclesByClass as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-primary small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Kendaraan</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada data kategori kelas</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Brand Categories Statistics -->
                    <div class="tab-pane fade" id="brand-chart" role="tabpanel" aria-labelledby="brand-tab">
                        <div class="row">
                            @forelse($vehiclesByBrand as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-success small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Kendaraan</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-trademark fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada data kategori merek</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Document Categories Statistics -->
                    <div class="tab-pane fade" id="document-chart" role="tabpanel" aria-labelledby="document-tab">
                        <div class="row">
                            @forelse($vehiclesByDocument as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-warning small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Kendaraan</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada data kategori dokumen</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Condition Categories Statistics -->
                    <div class="tab-pane fade" id="condition-chart" role="tabpanel" aria-labelledby="condition-tab">
                        <div class="row">
                            @forelse($vehiclesByCondition as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-info small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Kendaraan</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-tools fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada data kategori kondisi</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- No Data Message -->
                @if(count($vehiclesByClass) == 0 && count($vehiclesByBrand) == 0 && count($vehiclesByDocument) == 0 && count($vehiclesByCondition) == 0)
                <div class="text-center py-3">
                    <i class="fas fa-chart-bar fa-2x text-muted mb-2"></i>
                    <h6 class="text-muted small">Belum ada data kategori kendaraan</h6>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-plus me-1"></i>Tambah Kategori
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Statistik Penjualan per Kategori -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    <span id="salesChartTitle">Penjualan Kendaraan berdasarkan Kategori Kelas</span>
                </h5>
                
                <!-- Sales Category Navigation Tabs -->
                <div class="category-nav">
                    <ul class="nav nav-pills nav-sm" id="salesCategoryTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="sales-class-tab" data-bs-toggle="pill" 
                                    data-bs-target="#sales-class-chart" type="button" role="tab" 
                                    aria-controls="sales-class-chart" aria-selected="true"
                                    data-title="Penjualan Kendaraan berdasarkan Kategori Kelas">
                                <i class="fas fa-layer-group me-1"></i>Kelas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sales-brand-tab" data-bs-toggle="pill" 
                                    data-bs-target="#sales-brand-chart" type="button" role="tab" 
                                    aria-controls="sales-brand-chart" aria-selected="false"
                                    data-title="Penjualan Kendaraan berdasarkan Kategori Merek">
                                <i class="fas fa-trademark me-1"></i>Merek
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sales-document-tab" data-bs-toggle="pill" 
                                    data-bs-target="#sales-document-chart" type="button" role="tab" 
                                    aria-controls="sales-document-chart" aria-selected="false"
                                    data-title="Penjualan Kendaraan berdasarkan Kelengkapan Dokumen">
                                <i class="fas fa-file-alt me-1"></i>Dokumen
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sales-condition-tab" data-bs-toggle="pill" 
                                    data-bs-target="#sales-condition-chart" type="button" role="tab" 
                                    aria-controls="sales-condition-chart" aria-selected="false"
                                    data-title="Penjualan Kendaraan berdasarkan Kondisi Kendaraan">
                                <i class="fas fa-tools me-1"></i>Kondisi
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <!-- Sales Chart Container -->
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="salesByCategoryChart"></canvas>
                </div>

                <!-- Sales Tab Content for Statistics -->
                <div class="tab-content mt-3" id="salesTabContent">
                    <!-- Class Sales Statistics -->
                    <div class="tab-pane fade show active" id="sales-class-chart" role="tabpanel" aria-labelledby="sales-class-tab">
                        <div class="row">
                            @forelse($salesByClass as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-primary small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Terjual</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-layer-group fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada penjualan berdasarkan kelas</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Brand Sales Statistics -->
                    <div class="tab-pane fade" id="sales-brand-chart" role="tabpanel" aria-labelledby="sales-brand-tab">
                        <div class="row">
                            @forelse($salesByBrand as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-success small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Terjual</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-trademark fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada penjualan berdasarkan merek</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Document Sales Statistics -->
                    <div class="tab-pane fade" id="sales-document-chart" role="tabpanel" aria-labelledby="sales-document-tab">
                        <div class="row">
                            @forelse($salesByDocument as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-warning small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Terjual</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-file-alt fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada penjualan berdasarkan dokumen</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Condition Sales Statistics -->
                    <div class="tab-pane fade" id="sales-condition-chart" role="tabpanel" aria-labelledby="sales-condition-tab">
                        <div class="row">
                            @forelse($salesByCondition as $categoryName => $count)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-2">
                                <div class="text-center p-2 border rounded bg-light category-stat-card">
                                    <h6 class="mb-1 text-info small">{{ $categoryName }}</h6>
                                    <h5 class="mb-0 fw-bold text-dark">{{ $count }}</h5>
                                    <small class="text-muted">Terjual</small>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-3">
                                    <i class="fas fa-tools fa-2x text-muted mb-2"></i>
                                    <h6 class="text-muted small">Belum ada penjualan berdasarkan kondisi</h6>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- No Data Message for Sales -->
                @if(count($salesByClass) == 0 && count($salesByBrand) == 0 && count($salesByDocument) == 0 && count($salesByCondition) == 0)
                <div class="text-center py-3">
                    <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                    <h6 class="text-muted small">Belum ada data penjualan kategori</h6>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm mt-2">
                        <i class="fas fa-plus me-1"></i>Tambah Kategori
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Vehicle Addition Activity Section -->
<div class="row mt-4 equal-height-row">
    <!-- Aktivitas Penambahan Kendaraan -->
    <div class="col-lg-6">
        <div class="card vehicle-activity-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Aktivitas Penambahan Kendaraan
                </h5>
                
                <!-- Period Toggle Buttons -->
                <div class="btn-group" role="group" aria-label="Period toggle">
                    <input type="radio" class="btn-check" name="additionPeriod" id="monthlyView" autocomplete="off" checked>
                    <label class="btn btn-outline-primary btn-sm" for="monthlyView">
                        <i class="fas fa-calendar-alt me-1"></i>Bulanan
                    </label>
                    
                    <input type="radio" class="btn-check" name="additionPeriod" id="weeklyView" autocomplete="off">
                    <label class="btn btn-outline-primary btn-sm" for="weeklyView">
                        <i class="fas fa-calendar-week me-1"></i>Mingguan
                    </label>
                </div>
            </div>
            <div class="card-body">
                <!-- Chart Container -->
                <div class="chart-container" style="position: relative; height: 250px;">
                    <canvas id="vehicleAdditionChart"></canvas>
                </div>
                
                <!-- Summary Statistics -->
                <div class="row mt-3">
                    <div class="col-6 mb-2">
                        <div class="text-center p-2 addition-summary-card">
                            <h6 class="mb-1 text-primary small">Bulan Ini</h6>
                            <h5 class="mb-0 fw-bold text-dark" id="currentMonthAdditions">-</h5>
                            <small class="text-muted">Kendaraan</small>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="text-center p-2 addition-summary-card">
                            <h6 class="mb-1 text-success small">Minggu Ini</h6>
                            <h5 class="mb-0 fw-bold text-dark" id="currentWeekAdditions">-</h5>
                            <small class="text-muted">Kendaraan</small>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="text-center p-2 addition-summary-card">
                            <h6 class="mb-1 text-info small">Rata-rata</h6>
                            <h5 class="mb-0 fw-bold text-dark" id="averageMonthlyAdditions">-</h5>
                            <small class="text-muted">Per Bulan</small>
                        </div>
                    </div>
                    <div class="col-6 mb-2">
                        <div class="text-center p-2 addition-summary-card">
                            <h6 class="mb-1 text-warning small">Total</h6>
                            <h5 class="mb-0 fw-bold text-dark" id="totalYearAdditions">-</h5>
                            <small class="text-muted">12 Bulan</small>
                        </div>
                    </div>
                </div>
                
                <!-- No Data Message -->
                {{-- Debug: Show vehicle addition data status --}}
                @if(isset($vehicleAdditionData))
                    {{-- Data exists, show chart --}}
                    @php
                        $monthlySum = collect($vehicleAdditionData['monthly'] ?? [])->sum('count');
                        $weeklySum = collect($vehicleAdditionData['weekly'] ?? [])->sum('count');
                    @endphp
                    <!-- Debug info (remove in production) -->
                    <div style="display: none;" id="debug-info">
                        Monthly sum: {{ $monthlySum }}, Weekly sum: {{ $weeklySum }}
                    </div>
                    
                    @if($monthlySum == 0 && $weeklySum == 0)
                    <div class="text-center py-4" id="noAdditionData">
                        <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                        <h6 class="text-muted">Belum ada data penambahan kendaraan</h6>
                        <p class="text-muted small">Mulai tambahkan kendaraan untuk melihat grafik aktivitas</p>
                        <a href="{{ route('kendaraans.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Kendaraan Pertama
                        </a>
                    </div>
                    @else
                    <div class="text-center py-4" id="noAdditionData" style="display: none;">
                        <i class="fas fa-chart-line fa-2x text-muted mb-2"></i>
                        <h6 class="text-muted">Belum ada data penambahan kendaraan</h6>
                        <p class="text-muted small">Mulai tambahkan kendaraan untuk melihat grafik aktivitas</p>
                        <a href="{{ route('kendaraans.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Kendaraan Pertama
                        </a>
                    </div>
                    @endif
                @else
                <div class="text-center py-4" id="noAdditionData">
                    <i class="fas fa-exclamation-triangle fa-2x text-warning mb-2"></i>
                    <h6 class="text-warning">Data tidak tersedia</h6>
                    <p class="text-muted small">Terjadi kesalahan saat memuat data penambahan kendaraan</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kendaraan Termahal dan Termurah -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-money-bill-wave me-2"></i>
                    Kendaraan Termahal dan Termurah
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- 5 Kendaraan Termahal -->
                    <div class="col-12 mb-4">
                        <h6 class="text-danger mb-3">
                            <i class="fas fa-arrow-up me-2"></i>5 Kendaraan Termahal
                        </h6>
                        @if($expensiveVehicles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover price-table">
                                <thead class="table-danger">
                                    <tr>
                                        <th style="width: 45%;">Nama Kendaraan</th>
                                        <th style="width: 30%;">Merek</th>
                                        <th style="width: 25%;" class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expensiveVehicles as $vehicle)
                                    <tr>
                                        <td class="fw-medium">{{ $vehicle->merek }} {{ $vehicle->model }}</td>
                                        <td>
                                            @php
                                                $brandCategory = $vehicle->categories->where('type', 'brand')->first();
                                            @endphp
                                            <span class="badge bg-secondary">
                                                {{ $brandCategory ? $brandCategory->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-end text-danger fw-bold">
                                            Rp {{ number_format($vehicle->harga_jual, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-motorcycle fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">Belum ada kendaraan tersedia</p>
                        </div>
                        @endif
                    </div>

                    <!-- 5 Kendaraan Termurah -->
                    <div class="col-12">
                        <h6 class="text-success mb-3">
                            <i class="fas fa-arrow-down me-2"></i>5 Kendaraan Termurah
                        </h6>
                        @if($cheapestVehicles->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover price-table">
                                <thead class="table-success">
                                    <tr>
                                        <th style="width: 45%;">Nama Kendaraan</th>
                                        <th style="width: 30%;">Merek</th>
                                        <th style="width: 25%;" class="text-end">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cheapestVehicles as $vehicle)
                                    <tr>
                                        <td class="fw-medium">{{ $vehicle->merek }} {{ $vehicle->model }}</td>
                                        <td>
                                            @php
                                                $brandCategory = $vehicle->categories->where('type', 'brand')->first();
                                            @endphp
                                            <span class="badge bg-secondary">
                                                {{ $brandCategory ? $brandCategory->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-end text-success fw-bold">
                                            Rp {{ number_format($vehicle->harga_jual, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-3">
                            <i class="fas fa-motorcycle fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">Belum ada kendaraan tersedia</p>
                        </div>
                        @endif
                    </div>
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
<!-- Vite Dashboard Assets -->
@vite(['resources/css/dashboard.css'])
<style>
/* Styling for Vehicle Addition Chart Section */
.chart-container {
    position: relative;
    width: 100%;
}

.category-nav .nav-pills .nav-link {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
}

.category-nav .nav-pills .nav-link.active {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
}

.btn-group .btn-check:checked + .btn {
    background-color: var(--bs-primary);
    border-color: var(--bs-primary);
    color: white;
}

.stats-card.hover-card:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease-in-out;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

#vehicleAdditionChart {
    max-height: 250px;
}

.addition-summary-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

.addition-summary-card:hover {
    border-color: #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

/* Price Tables Styling */
.price-table {
    font-size: 0.875rem;
}

.price-table th {
    font-weight: 600;
    font-size: 0.8rem;
    padding: 0.5rem 0.75rem;
}

.price-table td {
    padding: 0.5rem 0.75rem;
    vertical-align: middle;
}

.price-table tbody tr:hover {
    background-color: rgba(0,0,0,0.025);
}

.table-danger {
    --bs-table-bg: rgba(220, 53, 69, 0.1);
}

.table-success {
    --bs-table-bg: rgba(25, 135, 84, 0.1);
}

.badge {
    font-size: 0.7rem;
}

/* Equal height cards for vehicle activity and price sections */
.equal-height-row {
    display: flex;
    align-items: stretch;
}

.equal-height-row .card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.equal-height-row .card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Ensure the chart container maintains its aspect ratio within the flexible layout */
.vehicle-activity-card .chart-container {
    flex: 1;
    min-height: 250px;
    max-height: 400px;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .price-table {
        font-size: 0.8rem;
    }
    
    .price-table th,
    .price-table td {
        padding: 0.4rem 0.5rem;
    }
    
    .badge {
        font-size: 0.65rem;
    }
    
    /* On mobile, disable equal height to prevent issues */
    .equal-height-row {
        display: block;
    }
    
    .equal-height-row .card {
        height: auto;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk semua kategori
    const categoryData = {
        class: @json($vehiclesByClass),
        brand: @json($vehiclesByBrand),
        document: @json($vehiclesByDocument),
        condition: @json($vehiclesByCondition)
    };
    
    // Data untuk statistik penjualan
    const salesData = {
        class: @json($salesByClass),
        brand: @json($salesByBrand),
        document: @json($salesByDocument),
        condition: @json($salesByCondition)
    };
    
    // Variabel chart global
    let currentChart = null;
    let salesChart = null;
    
    // Warna untuk setiap tipe kategori
    const colorSchemes = {
        class: {
            background: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)'
            ],
            border: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ]
        },
        brand: {
            background: [
                'rgba(34, 197, 94, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(249, 115, 22, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(236, 72, 153, 0.8)',
                'rgba(14, 165, 233, 0.8)'
            ],
            border: [
                'rgba(34, 197, 94, 1)',
                'rgba(59, 130, 246, 1)',
                'rgba(249, 115, 22, 1)',
                'rgba(168, 85, 247, 1)',
                'rgba(236, 72, 153, 1)',
                'rgba(14, 165, 233, 1)'
            ]
        },
        document: {
            background: [
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(107, 114, 128, 0.8)'
            ],
            border: [
                'rgba(245, 158, 11, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(107, 114, 128, 1)'
            ]
        },
        condition: {
            background: [
                'rgba(6, 182, 212, 0.8)',
                'rgba(16, 185, 129, 0.8)',
                'rgba(251, 191, 36, 0.8)',
                'rgba(239, 68, 68, 0.8)'
            ],
            border: [
                'rgba(6, 182, 212, 1)',
                'rgba(16, 185, 129, 1)',
                'rgba(251, 191, 36, 1)',
                'rgba(239, 68, 68, 1)'
            ]
        }
    };
    
    // Warna untuk chart penjualan
    const salesColors = {
        background: [
            'rgba(34, 197, 94, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(249, 115, 22, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(236, 72, 153, 0.8)'
        ],
        border: [
            'rgba(34, 197, 94, 1)',
            'rgba(59, 130, 246, 1)',
            'rgba(249, 115, 22, 1)',
            'rgba(168, 85, 247, 1)',
            'rgba(236, 72, 153, 1)'
        ]
    };
    
    // Fungsi untuk membuat chart komposisi
    function createChart(categoryType) {
        const data = categoryData[categoryType];
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        // Hancurkan chart sebelumnya jika ada
        if (currentChart) {
            currentChart.destroy();
        }
        
        // Cek jika tidak ada data
        if (labels.length === 0) {
            const chartContainer = document.querySelector('#vehiclesByCategoryChart').parentElement;
            chartContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Tidak ada data untuk kategori ini</h6>
                    <p class="text-muted small">Silakan tambahkan kategori dan kendaraan terlebih dahulu</p>
                </div>
            `;
            return;
        } else {
            // Pastikan canvas ada
            const chartContainer = document.querySelector('#vehiclesByCategoryChart').parentElement;
            chartContainer.innerHTML = '<canvas id="vehiclesByCategoryChart"></canvas>';
        }
        
        const colors = colorSchemes[categoryType];
        const ctx = document.getElementById('vehiclesByCategoryChart').getContext('2d');
        
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Kendaraan',
                    data: values,
                    backgroundColor: colors.background.slice(0, labels.length),
                    borderColor: colors.border.slice(0, labels.length),
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: false
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' kendaraan';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + ' unit';
                            },
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
    
    // Fungsi untuk membuat chart penjualan
    function createSalesChart(salesType = 'class') {
        const data = salesData[salesType];
        const labels = Object.keys(data);
        const values = Object.values(data);
        
        // Hancurkan chart sebelumnya jika ada
        if (salesChart) {
            salesChart.destroy();
        }
        
        // Cek jika tidak ada data
        if (labels.length === 0) {
            const chartContainer = document.querySelector('#salesByCategoryChart').parentElement;
            chartContainer.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Tidak ada data penjualan</h6>
                    <p class="text-muted small">Belum ada kendaraan yang terjual untuk kategori ini</p>
                </div>
            `;
            return;
        } else {
            // Pastikan canvas ada
            const chartContainer = document.querySelector('#salesByCategoryChart').parentElement;
            chartContainer.innerHTML = '<canvas id="salesByCategoryChart"></canvas>';
        }
        
        const colors = getSalesColorsForType(salesType);
        const ctx = document.getElementById('salesByCategoryChart').getContext('2d');
        
        salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kendaraan Terjual',
                    data: values,
                    backgroundColor: colors.background.slice(0, labels.length),
                    borderColor: colors.border.slice(0, labels.length),
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: false
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' kendaraan';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + ' unit';
                            },
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 800,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
    
    // Fungsi untuk mendapatkan warna berdasarkan tipe penjualan
    function getSalesColorsForType(salesType) {
        const colorSchemes = {
            class: {
                background: [
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                border: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)'
                ]
            },
            brand: {
                background: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(249, 115, 22, 0.8)',
                    'rgba(168, 85, 247, 0.8)',
                    'rgba(236, 72, 153, 0.8)',
                    'rgba(14, 165, 233, 0.8)'
                ],
                border: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(59, 130, 246, 1)',
                    'rgba(249, 115, 22, 1)',
                    'rgba(168, 85, 247, 1)',
                    'rgba(236, 72, 153, 1)',
                    'rgba(14, 165, 233, 1)'
                ]
            },
            document: {
                background: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(107, 114, 128, 0.8)'
                ],
                border: [
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)',
                    'rgba(107, 114, 128, 1)'
                ]
            },
            condition: {
                background: [
                    'rgba(6, 182, 212, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                border: [
                    'rgba(6, 182, 212, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(251, 191, 36, 1)',
                    'rgba(239, 68, 68, 1)'
                ]
            }
        };
        
        return colorSchemes[salesType] || colorSchemes.class;
    }
    
    // Fungsi untuk mendapatkan judul berdasarkan kategori
    function getTitleForCategory(categoryType) {
        const titles = {
            class: 'Kelas',
            brand: 'Merek',
            document: 'Kelengkapan Dokumen',
            condition: 'Kondisi'
        };
        return titles[categoryType];
    }
    
    // Event listener untuk tab navigation komposisi
    const tabButtons = document.querySelectorAll('#categoryTabs button[data-bs-toggle="pill"]');
    tabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const target = event.target.getAttribute('data-bs-target');
            const categoryType = target.replace('#', '').replace('-chart', '');
            const title = event.target.getAttribute('data-title');
            
            // Update judul
            document.getElementById('chartTitle').textContent = title;
            
            // Buat chart baru
            createChart(categoryType);
        });
    });
    
    // Event listener untuk tab navigation penjualan
    const salesTabButtons = document.querySelectorAll('#salesCategoryTabs button[data-bs-toggle="pill"]');
    salesTabButtons.forEach(button => {
        button.addEventListener('shown.bs.tab', function(event) {
            const target = event.target.getAttribute('data-bs-target');
            const salesType = target.replace('#sales-', '').replace('-chart', '');
            const title = event.target.getAttribute('data-title');
            
            // Update judul chart penjualan
            document.getElementById('salesChartTitle').textContent = title;
            
            // Buat chart penjualan baru
            createSalesChart(salesType);
        });
    });
    
    // Data untuk aktivitas penambahan kendaraan
    const vehicleAdditionData = @json($vehicleAdditionData);
    
    // Debug: Output data immediately when script loads
    console.log('Raw vehicle addition data from PHP:', @json($vehicleAdditionData));
    
    // Check if data exists
    if (!vehicleAdditionData) {
        console.error('vehicleAdditionData is null or undefined');
    } else {
        console.log('Vehicle addition data loaded successfully');
        console.log('Monthly data count:', vehicleAdditionData.monthly ? vehicleAdditionData.monthly.length : 'undefined');
        console.log('Weekly data count:', vehicleAdditionData.weekly ? vehicleAdditionData.weekly.length : 'undefined');
        
        if (vehicleAdditionData.monthly) {
            console.log('Monthly data:', vehicleAdditionData.monthly);
            const monthlySum = vehicleAdditionData.monthly.reduce((sum, item) => sum + item.count, 0);
            console.log('Total monthly vehicles:', monthlySum);
        }
        
        if (vehicleAdditionData.weekly) {
            console.log('Weekly data:', vehicleAdditionData.weekly);
            const weeklySum = vehicleAdditionData.weekly.reduce((sum, item) => sum + item.count, 0);
            console.log('Total weekly vehicles:', weeklySum);
        }
    }
    
    // Variabel untuk chart penambahan kendaraan
    let additionChart = null;
    let currentPeriod = 'monthly';
    
    // Warna untuk chart penambahan kendaraan
    const additionChartColors = {
        background: 'rgba(34, 197, 94, 0.2)',
        border: 'rgba(34, 197, 94, 1)',
        point: 'rgba(34, 197, 94, 1)',
        pointHover: 'rgba(25, 135, 84, 1)'
    };
    
    // Fungsi untuk membuat chart penambahan kendaraan
    function createAdditionChart(period = 'monthly') {
        console.log('Creating addition chart for period:', period);
        console.log('Vehicle addition data:', vehicleAdditionData);
        
        const data = vehicleAdditionData[period];
        console.log('Data for period:', data);
        
        const labels = data.map(item => item.period);
        const values = data.map(item => item.count);
        
        console.log('Labels:', labels);
        console.log('Values:', values);
        
        // Hancurkan chart sebelumnya jika ada
        if (additionChart) {
            additionChart.destroy();
        }
        
        // Cek jika tidak ada data
        if (values.every(val => val === 0)) {
            console.log('All values are zero, showing no data message');
            document.getElementById('noAdditionData').style.display = 'block';
            document.querySelector('#vehicleAdditionChart').parentElement.style.display = 'none';
            return;
        } else {
            console.log('Data found, showing chart');
            document.getElementById('noAdditionData').style.display = 'none';
            document.querySelector('#vehicleAdditionChart').parentElement.style.display = 'block';
        }
        
        const ctx = document.getElementById('vehicleAdditionChart').getContext('2d');
        
        additionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kendaraan Ditambahkan',
                    data: values,
                    backgroundColor: additionChartColors.background,
                    borderColor: additionChartColors.border,
                    borderWidth: 3,
                    pointBackgroundColor: additionChartColors.point,
                    pointBorderColor: additionChartColors.border,
                    pointHoverBackgroundColor: additionChartColors.pointHover,
                    pointHoverBorderColor: additionChartColors.border,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: false
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' kendaraan';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + ' unit';
                            },
                            font: {
                                size: 11
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
        
        // Update summary statistics
        updateAdditionStatistics(period);
    }
    
    // Fungsi untuk update statistik ringkasan
    function updateAdditionStatistics(period) {
        const monthlyData = vehicleAdditionData.monthly;
        const weeklyData = vehicleAdditionData.weekly;
        
        // Current month additions (last item in monthly data)
        const currentMonth = monthlyData[monthlyData.length - 1]?.count || 0;
        document.getElementById('currentMonthAdditions').textContent = currentMonth;
        
        // Current week additions (last item in weekly data)
        const currentWeek = weeklyData[weeklyData.length - 1]?.count || 0;
        document.getElementById('currentWeekAdditions').textContent = currentWeek;
        
        // Average monthly additions
        const totalMonthly = monthlyData.reduce((sum, item) => sum + item.count, 0);
        const averageMonthly = Math.round(totalMonthly / monthlyData.length);
        document.getElementById('averageMonthlyAdditions').textContent = averageMonthly;
        
        // Total year additions
        document.getElementById('totalYearAdditions').textContent = totalMonthly;
    }
    
    // Event listener untuk toggle period
    document.getElementById('monthlyView').addEventListener('change', function() {
        if (this.checked) {
            currentPeriod = 'monthly';
            createAdditionChart('monthly');
        }
    });
    
    document.getElementById('weeklyView').addEventListener('change', function() {
        if (this.checked) {
            currentPeriod = 'weekly';
            createAdditionChart('weekly');
        }
    });
    
    // Inisialisasi charts
    createChart('class');
    createSalesChart('class');
    
    // Initialize addition chart with error handling
    try {
        console.log('Initializing addition chart...');
        createAdditionChart('monthly');
        console.log('Addition chart initialized successfully');
    } catch (error) {
        console.error('Error initializing addition chart:', error);
    }
});
</script>
@endpush
