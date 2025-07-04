@extends('layouts.store')

@section('title', $kendaraan->merek . ' ' . $kendaraan->model . ' - Dewa Motor')

@section('content')
<!-- Container Detail Motor -->
<div class="container py-5">
    <div class="row">
        <!-- Breadcrumb Navigation -->
        <div class="col-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('store.index') }}" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>
                            Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('store.index') }}" class="text-decoration-none">Motor</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $kendaraan->merek }} {{ $kendaraan->model }}
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Kolom Kiri: Detail Motor Utama -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <!-- Section Gambar Motor -->
                    <div class="motor-image-detail">
                        @if($kendaraan->photos && count($kendaraan->photos) > 0)
                            <div class="position-relative">
                                <!-- Carousel Gambar Utama -->
                                <div id="motorCarousel" class="carousel slide" data-bs-ride="false">
                                    <div class="carousel-inner">
                                        @foreach($kendaraan->photos as $index => $photo)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $photo) }}" 
                                                 alt="{{ $kendaraan->merek }} {{ $kendaraan->model }} - Foto {{ $index + 1 }}"
                                                 class="d-block w-100"
                                                 style="height: 400px; object-fit: cover; border-radius: 15px 15px 0 0; cursor: pointer;"
                                                 onclick="showFullscreenImage('{{ asset('storage/' . $photo) }}', '{{ $kendaraan->merek }} {{ $kendaraan->model }} - Foto {{ $index + 1 }}')">
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Tombol Navigasi Carousel -->
                                    @if(count($kendaraan->photos) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#motorCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#motorCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                    @endif
                                </div>
                                
                                <!-- Badge Jumlah Foto -->
                                <div class="photo-count-detail">
                                    <i class="fas fa-images me-1"></i>
                                    {{ count($kendaraan->photos) }} Foto
                                </div>
                            </div>
                            
                            <!-- Gallery Thumbnail -->
                            @if(count($kendaraan->photos) > 1)
                            <div class="photo-thumbnails mt-3">
                                @foreach($kendaraan->photos as $index => $photo)
                                <div class="photo-thumbnail {{ $index === 0 ? 'active' : '' }}" 
                                     onclick="changeCarouselSlide({{ $index }})">
                                    <img src="{{ asset('storage/' . $photo) }}" 
                                         alt="Thumbnail {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        @else
                            <!-- Placeholder jika tidak ada foto -->
                            <div style="height: 400px; background: linear-gradient(45deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; border-radius: 15px 15px 0 0;">
                                <div class="text-center">
                                    <i class="fas fa-motorcycle" style="font-size: 6rem; color: #6b7280;"></i>
                                    <p class="text-muted mt-3">Belum ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Informasi Motor -->
                    <div class="p-4">
                        <!-- Header: Nama dan Harga -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h1 class="h2 mb-1">{{ $kendaraan->merek }} {{ $kendaraan->model }}</h1>
                                <p class="text-muted mb-0">Tahun {{ $kendaraan->tahun_pembuatan }}</p>
                            </div>
                            <div class="text-end">
                                <div class="h3 text-primary mb-0">
                                    Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}
                                </div>
                                <small class="text-muted">Harga Jual</small>
                            </div>
                        </div>

                        <!-- Badge Kategori -->
                        @if($kendaraan->categories->count() > 0)
                            <div class="mb-3">
                                @foreach($kendaraan->categories as $category)
                                    <span class="badge bg-warning text-dark me-2 mb-2">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Badge Status -->
                        <div class="mb-4">
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check me-1"></i>
                                {{ ucfirst($kendaraan->status) }}
                            </span>
                        </div>

                        <!-- Section Spesifikasi dan Dokumen -->
                        <div class="row g-4 mb-4">
                            <!-- Kolom Spesifikasi -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-cog text-primary me-2"></i>
                                    Spesifikasi
                                </h5>
                                <div class="spec-list">
                                    <div class="spec-item d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Merek:</span>
                                        <span class="fw-semibold">{{ $kendaraan->merek }}</span>
                                    </div>
                                    <div class="spec-item d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Model:</span>
                                        <span class="fw-semibold">{{ $kendaraan->model }}</span>
                                    </div>
                                    <div class="spec-item d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Tahun Pembuatan:</span>
                                        <span class="fw-semibold">{{ $kendaraan->tahun_pembuatan }}</span>
                                    </div>
                                    <div class="spec-item d-flex justify-content-between border-bottom py-2">
                                        <span class="text-muted">Nomor Rangka:</span>
                                        <span class="fw-semibold">{{ $kendaraan->nomor_rangka }}</span>
                                    </div>
                                    <div class="spec-item d-flex justify-content-between py-2">
                                        <span class="text-muted">Nomor Mesin:</span>
                                        <span class="fw-semibold">{{ $kendaraan->nomor_mesin }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Dokumen -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-file-alt text-primary me-2"></i>
                                    Dokumen
                                </h5>
                                @if($kendaraan->dokumen && $kendaraan->dokumen->count() > 0)
                                    <div class="document-list">
                                        @foreach($kendaraan->dokumen as $dokumen)
                                            <div class="d-flex align-items-center border-bottom py-2">
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <span>{{ $dokumen->jenis_dokumen }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted">Tidak ada dokumen yang tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Card Kontak -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-phone text-primary me-2"></i>
                        Hubungi Kami
                    </h5>
                    
                    <!-- Tombol Kontak -->
                    <div class="d-grid gap-3">
                        <!-- Tombol WhatsApp -->
                        <a href="https://wa.me/6282135277434?text=Halo, saya tertarik dengan motor {{ $kendaraan->merek }} {{ $kendaraan->model }} tahun {{ $kendaraan->tahun_pembuatan }}. Bisakah saya mendapatkan informasi lebih lanjut?" 
                           target="_blank" 
                           class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i>
                            Chat WhatsApp
                        </a>

                        <!-- Tombol Telepon -->
                        <a href="tel:+6282135277434" class="btn btn-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            Telepon Sekarang
                        </a>

                        <!-- Tombol Kunjungi Toko -->
                        <a href="https://maps.app.goo.gl/GDqPT6xRwyg5KmgdA" target="_blank" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Kunjungi Toko
                        </a>
                    </div>

                    <hr class="my-4">

                    <!-- Informasi Toko -->
                    <div class="store-info">
                        <h6 class="mb-3">
                            <i class="fas fa-store text-primary me-2"></i>
                            Informasi Toko
                        </h6>
                        
                        <div class="info-item mb-2">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <small>Jl. Pandanaran - Uii</small>
                        </div>
                        
                        <div class="info-item mb-2">
                            <i class="fas fa-clock text-muted me-2"></i>
                            <small>Senin - Sabtu: 08:00 - 17:00</small>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <small>infodewamotor@gmail.com</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Motor Serupa -->
    @if($relatedMotors->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">
                    <i class="fas fa-motorcycle text-primary me-2"></i>
                    Motor Serupa
                </h3>
                
                <!-- Grid Motor Serupa -->
                <div class="row g-4">
                    @foreach($relatedMotors as $motor)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="motor-card">
                                <!-- Gambar Motor Placeholder -->
                                <div class="motor-image">
                                    <i class="fas fa-motorcycle"></i>
                                </div>

                                <!-- Info Motor -->
                                <div class="motor-info">
                                    <h5 class="motor-title">{{ $motor->merek }} {{ $motor->model }}</h5>
                                    
                                    <div class="motor-price">
                                        Rp {{ number_format($motor->harga_jual, 0, ',', '.') }}
                                    </div>

                                    <div class="motor-details">
                                        <span>
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $motor->tahun_pembuatan }}
                                        </span>
                                    </div>

                                    <!-- Badge Kategori -->
                                    @if($motor->categories->count() > 0)
                                        <div class="mb-3">
                                            @foreach($motor->categories->take(2) as $category)
                                                <span class="category-badge">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Tombol Lihat Detail -->
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('store.show', $motor->id) }}" class="btn btn-primary">
                                            <i class="fas fa-eye me-1"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

<!-- Modal Fullscreen untuk Gambar -->
<div class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h5 class="modal-title text-white" id="fullscreenModalLabel">Foto Kendaraan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center justify-content-center p-0">
                <img id="fullscreenImage" src="" alt="Fullscreen Image" class="img-fluid" style="max-height: 90vh; max-width: 90vw; object-fit: contain;">
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS untuk Styling -->
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/store/show.css') }}">
@endpush

<!-- JavaScript untuk Interaksi -->
@push('scripts')
<script>
// Fungsi untuk mengubah slide carousel
function changeCarouselSlide(index) {
    var carousel = document.getElementById('motorCarousel');
    var carouselInstance = new bootstrap.Carousel(carousel);
    carouselInstance.to(index);
    
    // Perbarui thumbnail aktif
    document.querySelectorAll('.photo-thumbnail').forEach(function(thumb, i) {
        thumb.classList.toggle('active', i === index);
    });
}

// Event listener untuk interaksi carousel dan modal
document.addEventListener('DOMContentLoaded', function() {
    var carousel = document.getElementById('motorCarousel');
    if (carousel) {
        // Sinkronisasi thumbnail dengan carousel
        carousel.addEventListener('slid.bs.carousel', function(event) {
            var activeIndex = event.to;
            document.querySelectorAll('.photo-thumbnail').forEach(function(thumb, i) {
                thumb.classList.toggle('active', i === activeIndex);
            });
        });
    }
    
    // Keyboard navigation untuk modal fullscreen
    document.addEventListener('keydown', function(event) {
        var modal = document.getElementById('fullscreenModal');
        if (modal && modal.classList.contains('show')) {
            if (event.key === 'Escape') {
                bootstrap.Modal.getInstance(modal).hide();
            }
        }
    });
});

// Fungsi untuk menampilkan gambar fullscreen
function showFullscreenImage(src, title) {
    var modal = new bootstrap.Modal(document.getElementById('fullscreenModal'));
    document.getElementById('fullscreenImage').src = src;
    document.getElementById('fullscreenModalLabel').textContent = title;
    modal.show();
}
</script>
@endpush
