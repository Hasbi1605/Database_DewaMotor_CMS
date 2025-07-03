@extends('layouts.store')

@section('title', 'Motor Tersedia - Dewa Motor')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1><i class="fas fa-motorcycle me-3"></i>Motor Berkualitas Tinggi</h1>
        <p>Temukan motor impian Anda dengan kualitas terbaik dan harga terjangkau</p>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $kendaraans->total() }}</div>
                        <small>Motor Tersedia</small>
                    </div>
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $brands->count() }}</div>
                        <small>Merek Tersedia</small>
                    </div>
                    <div class="text-center">
                        <div class="h3 mb-0">{{ $categories->count() }}</div>
                        <small>Kategori</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-card">
            <form method="GET" action="{{ route('store.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Search by Brand -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-search me-1"></i>
                            Cari Merek
                        </label>
                        <input type="text" class="form-control" name="brand" 
                               value="{{ request('brand') }}" 
                               placeholder="Contoh: Honda, Yamaha">
                    </div>

                    <!-- Category Filter -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-tags me-1"></i>
                            Kategori
                        </label>
                        <select class="form-select" name="category">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-money-bill me-1"></i>
                            Rentang Harga
                        </label>
                        <div class="row g-1">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="min_price" value="{{ request('min_price') }}" 
                                       placeholder="Min" min="0">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="max_price" value="{{ request('max_price') }}" 
                                       placeholder="Max" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Year Range -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-calendar me-1"></i>
                            Tahun
                        </label>
                        <div class="row g-1">
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="min_year" value="{{ request('min_year') }}" 
                                       placeholder="{{ $yearRange['min'] }}" min="{{ $yearRange['min'] }}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control form-control-sm" 
                                       name="max_year" value="{{ request('max_year') }}" 
                                       placeholder="{{ $yearRange['max'] }}" max="{{ $yearRange['max'] }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
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

<!-- Motors Grid -->
<section class="py-5">
    <div class="container">
        @if($kendaraans->count() > 0)
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">
                    <i class="fas fa-motorcycle me-2 text-primary"></i>
                    Motor Tersedia
                </h3>
                <div class="text-muted">
                    Menampilkan {{ $kendaraans->firstItem() }}-{{ $kendaraans->lastItem() }} 
                    dari {{ $kendaraans->total() }} motor
                </div>
            </div>

            <!-- Motors Grid -->
            <div class="row g-4">
                @foreach($kendaraans as $kendaraan)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="motor-card">
                            <!-- Motor Image Placeholder -->
                            <div class="motor-image">
                                <i class="fas fa-motorcycle"></i>
                            </div>

                            <div class="motor-info">
                                <h5 class="motor-title">{{ $kendaraan->merek }} {{ $kendaraan->model }}</h5>
                                
                                <div class="motor-price">
                                    Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}
                                </div>

                                <div class="motor-details">
                                    <span>
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ $kendaraan->tahun_pembuatan }}
                                    </span>
                                </div>

                                <!-- Categories -->
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

                                <div class="d-grid gap-2">
                                    <a href="{{ route('store.show', $kendaraan->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i>
                                        Lihat Detail
                                    </a>
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
            <!-- Empty State -->
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

<!-- Contact Section -->
<section id="contact" class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="mb-4">
                    <i class="fas fa-phone text-primary me-2"></i>
                    Butuh Bantuan?
                </h2>
                <p class="lead mb-4">
                    Tim kami siap membantu Anda menemukan motor yang tepat. 
                    Hubungi kami sekarang juga!
                </p>
                <div class="row g-3">
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

@push('scripts')
<script>
    // Auto submit form when sorting changes
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.querySelector('select[name="sort"]');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }
    });
</script>
@endpush
