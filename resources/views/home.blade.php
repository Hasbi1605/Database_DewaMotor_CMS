@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard Statistics Cards -->
<div class="row">
    <!-- Card Total Kendaraan -->
    <div class="col-md-3">
        <a href="" class="text-decoration-none">
            <div class="card bg-white shadow hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-primary">
                            <i class="fas fa-motorcycle fa-2x text-white"></i>
                        </div>
                        <div class="ms-3 text-dark">
                            <h6 class="mb-1">Total Kendaraan</h6>
                            <h3 class="mb-0">{{ $totalKendaraan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Kendaraan Tersedia -->
    <div class="col-md-3">
        <a href="#kendaraanTersedia" class="text-decoration-none">
            <div class="card bg-white shadow hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-success">
                            <i class="fas fa-check fa-2x text-white"></i>
                        </div>
                        <div class="ms-3 text-dark">
                            <h6 class="mb-1">Kendaraan Tersedia</h6>
                            <h3 class="mb-0">{{ $totalKendaraan - $totalTerjual }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Kendaraan Terjual -->
    <div class="col-md-3">
        <a href="#kendaraanTerjual" class="text-decoration-none">
            <div class="card bg-white shadow hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-danger">
                            <i class="fas fa-times fa-2x text-white"></i>
                        </div>
                        <div class="ms-3 text-dark">
                            <h6 class="mb-1">Kendaraan Terjual</h6>
                            <h3 class="mb-0">{{ $totalTerjual }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Total Keuntungan -->
    <div class="col-md-3">
        <a href="#kendaraanTerjual" class="text-decoration-none">
            <div class="card bg-white shadow hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-3 bg-info">
                            <i class="fas fa-money-bill fa-2x text-white"></i>
                        </div>
                        <div class="ms-3 text-dark">
                            <h6 class="mb-1">Total Keuntungan</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <!-- Chart Penjualan Berdasarkan Merek -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Statistik Penjualan Berdasarkan Merek
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Chart Penjualan Berdasarkan Kelas -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Statistik Penjualan Berdasarkan Kelas
                </h5>
            </div>
            <div class="card-body">
                <canvas id="classChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Section Kendaraan Tersedia -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card" id="kendaraanTersedia">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-motorcycle me-2"></i>
                    Kendaraan Tersedia
                </h5>
            </div>
            <div class="card-body">
                <!-- Form Filter Kategori -->
                <div class="mb-3">
                    <form action="{{ route('home') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label for="category" class="form-label">Filter by Category:</label>
                            <select name="category" id="category" class="form-select" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                
                                <!-- Dropdown Merek -->
                                <optgroup label="Merek">
                                    @foreach($categories->where('type', 'brand') as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <!-- Dropdown Kelas -->
                                <optgroup label="Kelas">
                                    @foreach($categories->where('type', 'class') as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <!-- Dropdown Kelengkapan Dokumen -->
                                <optgroup label="Kelengkapan Dokumen">
                                    @foreach($categories->where('type', 'document') as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <!-- Dropdown Kondisi Motor -->
                                <optgroup label="Kondisi Motor">
                                    @foreach($categories->where('type', 'condition') as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </form>
                </div>
                
                <!-- Tabel Kendaraan Tersedia -->
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
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk Styling Dashboard -->
<link rel="stylesheet" href="{{ asset('assets/css/pages/layouts/home.css') }}">

<!-- JavaScript untuk Chart.js -->
@push('scripts')
<script>
window.addEventListener('load', function() {
    // Data untuk Diagram Lingkaran Penjualan per Merek
    const salesData = {!! json_encode($kendaraanTerjualAll->groupBy('merek')
        ->map(function($items) {
            return $items->count();
        })) !!};
    
    // Buat Chart Penjualan per Merek jika ada data
    if (Object.keys(salesData).length > 0) {
        const salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(salesData),
                datasets: [{
                    data: Object.values(salesData),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#858796', '#5a5c69', '#2e59d9', '#17a673', '#2c9faf'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Penjualan per Merek'
                    }
                }
            }
        });
    }

    // Data untuk Diagram Lingkaran Penjualan per Kelas
    const classData = {!! json_encode($salesByClass) !!};

    // Buat Chart Penjualan per Kelas jika ada data
    if (Object.keys(classData).length > 0) {
        const classChart = new Chart(document.getElementById('classChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: Object.keys(classData),
                datasets: [{
                    data: Object.values(classData),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#858796', '#5a5c69', '#2e59d9', '#17a673', '#2c9faf'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Penjualan per Kelas Kendaraan'
                    }
                }
            }
        });
    }
});
</script>
@endpush
@endsection
