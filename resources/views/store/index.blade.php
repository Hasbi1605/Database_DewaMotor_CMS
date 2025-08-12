@extends('layouts.store')

@section('title', 'Motor Tersedia - Dewa Motor')

@section('content')
<!-- Hero Section - Banner Utama -->
<section class="hero-section">
    <div class="container">
        <h1><i class="fas fa-motorcycle me-3"></i>Motor Bekas Jogja</h1>
        <p>Temukan motor impian Anda dengan kualitas terbaik dan harga terjangkau</p>
        
        <!-- Statistik Singkat -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <!-- Total Motor Tersedia -->
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $kendaraans->total() }}</div>
                        <small>Motor Tersedia</small>
                    </div>
                    
                    <!-- Total Merek -->
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $brands->count() }}</div>
                        <small>Merek Tersedia</small>
                    </div>
                    
                    <!-- Total Kategori -->
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $categories->count() }}</div>
                        <small>Kategori</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">

<!-- Filter Section - Area Pencarian dan Filter -->
<section class="filter-section">
    <div class="container">
        <div class="filter-card">
            <form method="GET" action="{{ route('store.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Input Pencarian Merek -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-search me-1"></i>
                            Cari Merek
                        </label>
                        <input type="text" class="form-control" name="brand" 
                               value="{{ request('brand') }}" 
                               placeholder="Contoh: Honda, Yamaha">
                    </div>

                    <!-- Dropdown Filter Kategori -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tags me-1"></i>
                            Kategori
                        </label>
                        <select class="form-select" name="category">
                            <option value="">Semua Kategori</option>
                            
                            <!-- Optgroup Merek -->
                            @if($categories->where('type', 'brand')->count() > 0)
                                <optgroup label="Merek">
                                    @foreach($categories->where('type', 'brand') as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            <!-- Optgroup Kelas -->
                            @if($categories->where('type', 'class')->count() > 0)
                                <optgroup label="Kelas">
                                    @foreach($categories->where('type', 'class') as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            <!-- Optgroup Kelengkapan Dokumen -->
                            @if($categories->where('type', 'document')->count() > 0)
                                <optgroup label="Kelengkapan Dokumen">
                                    @foreach($categories->where('type', 'document') as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif

                            <!-- Optgroup Kondisi Motor -->
                            @if($categories->where('type', 'condition')->count() > 0)
                                <optgroup label="Kondisi Motor">
                                    @foreach($categories->where('type', 'condition') as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>

                    <!-- Filter Rentang Harga -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-money-bill me-1"></i>
                            Rentang Harga
                        </label>
                        <div class="row g-1">
                            <!-- Harga Minimum -->
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" min="0">
                            </div>
                            <!-- Harga Maksimum -->
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Filter Rentang Tahun -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar me-1"></i>
                            Tahun
                        </label>
                        <div class="row g-1">
                            <!-- Tahun Minimum -->
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="min_year" value="{{ request('min_year') }}" 
                                       placeholder="{{ $yearRange['min'] }}" min="{{ $yearRange['min'] }}">
                            </div>
                            <!-- Tahun Maksimum -->
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="max_year" value="{{ request('max_year') }}" 
                                       placeholder="{{ $yearRange['max'] }}" max="{{ $yearRange['max'] }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Baris Kedua: Pengurutan dan Tombol Aksi -->
                <div class="row mt-3">
                    <!-- Dropdown Pengurutan -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-sort me-1"></i>
                            Urutkan
                        </label>
                        <select class="form-select" name="sort" onchange="document.getElementById('filterForm').submit()">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                            <option value="year_new" {{ request('sort') == 'year_new' ? 'selected' : '' }}>Tahun Terbaru</option>
                            <option value="year_old" {{ request('sort') == 'year_old' ? 'selected' : '' }}>Tahun Terlama</option>
                        </select>
                    </div>
                    
                    <!-- Tombol Filter dan Reset -->
                    <div class="col-md-6 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>
                            Filter
                        </button>
                        <a href="{{ route('store.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Motors Grid Section - Daftar Motor -->
<section class="py-5">
    <div class="container">
        @if($kendaraans->count() > 0)
            <!-- Header Hasil Pencarian -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-motorcycle me-2 text-primary"></i>
                    Motor Tersedia
                </h3>
            </div>

            <!-- Grid Card Motor -->
            <div class="row g-4">
                @foreach($kendaraans as $kendaraan)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="motor-card">
                            <!-- Gambar Motor -->
                            <div class="motor-image">
                                @if($kendaraan->photos && count($kendaraan->photos) > 0)
                                    <!-- Gambar Utama Motor (Clickable) -->
                                    <a href="{{ route('store.show', $kendaraan->id) }}" class="motor-image-link">
                                        <img src="{{ asset('storage/' . $kendaraan->photos[0]) }}" 
                                             alt="{{ $kendaraan->merek }} {{ $kendaraan->model }}" 
                                             class="img-fluid motor-preview-image">
                                    </a>
                                    
                                    <!-- Badge Jumlah Foto -->
                                    @if(count($kendaraan->photos) > 1)
                                        <div class="photo-count">
                                            <i class="fas fa-images"></i>
                                            {{ count($kendaraan->photos) }}
                                        </div>
                                    @endif
                                @else
                                    <!-- Placeholder jika tidak ada foto (Clickable) -->
                                    <a href="{{ route('store.show', $kendaraan->id) }}" class="motor-image-link">
                                        <div class="default-image">
                                            <i class="fas fa-motorcycle"></i>
                                        </div>
                                    </a>
                                @endif
                            </div>

                            <!-- Informasi Motor -->
                            <div class="motor-info">
                                <!-- Nama Motor -->
                                <h5 class="motor-title">{{ $kendaraan->merek }} {{ $kendaraan->model }}</h5>
                                
                                <!-- Harga Motor -->
                                <div class="motor-price">
                                    Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}
                                </div>

                                <!-- Detail Motor -->
                                <div class="motor-details">
                                    <span>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $kendaraan->tahun_pembuatan }}
                                    </span>
                                </div>

                                <!-- Badge Kategori Motor -->
                                @if($kendaraan->categories->count() > 0)
                                    <div class="mb-3">
                                        @foreach($kendaraan->categories->take(2) as $category)
                                            <span class="category-badge">{{ $category->name }}</span>
                                        @endforeach
                                        @if($kendaraan->categories->count() > 2)
                                            <span class="category-badge">+{{ $kendaraan->categories->count() - 2 }}</span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Tombol Aksi -->
                                <div class="d-grid gap-2">
                                    <!-- Tombol Lihat Detail -->
                                    <a href="{{ route('store.show', $kendaraan->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        Lihat Detail
                                    </a>
                                    
                                    <!-- Tombol WhatsApp -->
                                    <a href="https://wa.me/6282135277434?text=Halo, saya tertarik dengan motor {{ $kendaraan->merek }} {{ $kendaraan->model }} tahun {{ $kendaraan->tahun_pembuatan }}" 
                                       target="_blank" 
                                       class="btn btn-outline-success">
                                        <i class="fab fa-whatsapp me-1"></i>
                                        WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $kendaraans->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        @else
            <!-- Empty State - Tidak Ada Hasil -->
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h3>Motor Tidak Ditemukan</h3>
                <p>Maaf, tidak ada motor yang sesuai dengan kriteria pencarian Anda.</p>
                <a href="{{ route('store.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-1"></i>
                    Lihat Semua Motor
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Contact Section - Informasi Kontak -->
<section id="contact" class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <!-- Header Kontak -->
                <h2 class="mb-4">
                    <i class="fas fa-phone text-primary me-2"></i>
                    Butuh Bantuan?
                </h2>
                <p class="lead mb-4">
                    Tim kami siap membantu Anda menemukan motor yang tepat. 
                    Hubungi kami sekarang juga!
                </p>
                
                <!-- Card Kontak -->
                <div class="row g-3">
                    <!-- WhatsApp -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center py-4">
                                <i class="fab fa-whatsapp fa-3x text-success mb-3"></i>
                                <h5>WhatsApp</h5>
                                <p class="text-muted">+62 821-3527-7434</p>
                                <a href="https://wa.me/6282135277434" target="_blank" class="btn btn-success">
                                    Chat Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Telepon -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-phone fa-3x text-primary mb-3"></i>
                                <h5>Telepon</h5>
                                <p class="text-muted">+62 821-3527-7434</p>
                                <a href="tel:+6282135277434" class="btn btn-primary">
                                    Telepon Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Alamat -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body text-center py-4">
                                <i class="fas fa-map-marker-alt fa-3x text-danger mb-3"></i>
                                <h5>Alamat</h5>
                                <p class="text-muted">Jalan Pandanaran - Uii</p>
                                <a href="https://maps.app.goo.gl/GDqPT6xRwyg5KmgdA" target="_blank" class="btn btn-danger">
                                    Lihat Lokasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- CSS untuk Styling -->
@push('styles')
<!-- Vite Store Assets -->
@vite(['resources/css/store.css'])
@endpush

<!-- JavaScript untuk Interaksi -->
@push('scripts')
<script>
    // Auto submit form ketika pengurutan berubah
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.querySelector('select[name="sort"]');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }
        
        // Tambahkan smooth scrolling untuk link
        document.querySelectorAll('.motor-image-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                // Add a subtle loading effect
                this.style.opacity = '0.8';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 200);
            });
        });
    });
</script>
@endpush
