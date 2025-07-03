@extends('layouts.store')

@section('title', $kendaraan->merek . ' ' . $kendaraan->model . ' - Dewa Motor')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Breadcrumb -->
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

        <!-- Motor Detail -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <!-- Motor Image -->
                    <div class="motor-image-detail">
                        <div style="height: 400px; background: linear-gradient(45deg, #f3f4f6, #e5e7eb); display: flex; align-items: center; justify-content: center; border-radius: 15px 15px 0 0;">
                            <i class="fas fa-motorcycle" style="font-size: 6rem; color: #6b7280;"></i>
                        </div>
                    </div>

                    <div class="p-4">
                        <!-- Title and Price -->
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

                        <!-- Categories -->
                        @if($kendaraan->categories->count() > 0)
                            <div class="mb-3">
                                @foreach($kendaraan->categories as $category)
                                    <span class="badge bg-warning text-dark me-2 mb-2">{{ $category->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="mb-4">
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-check me-1"></i>
                                {{ ucfirst($kendaraan->status) }}
                            </span>
                        </div>

                        <!-- Specifications -->
                        <div class="row g-4 mb-4">
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

        <!-- Contact Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">
                        <i class="fas fa-phone text-primary me-2"></i>
                        Hubungi Kami
                    </h5>
                    
                    <div class="d-grid gap-3">
                        <!-- WhatsApp Button -->
                        <a href="https://wa.me/6282135277434?text=Halo, saya tertarik dengan motor {{ $kendaraan->merek }} {{ $kendaraan->model }} tahun {{ $kendaraan->tahun_pembuatan }}. Bisakah saya mendapatkan informasi lebih lanjut?" 
                           target="_blank" 
                           class="btn btn-success btn-lg">
                            <i class="fab fa-whatsapp me-2"></i>
                            Chat WhatsApp
                        </a>

                        <!-- Phone Button -->
                        <a href="tel:+6282135277434" class="btn btn-primary btn-lg">
                            <i class="fas fa-phone me-2"></i>
                            Telepon Sekarang
                        </a>

                        <!-- Visit Store Button -->
                        <a href="https://maps.app.goo.gl/GDqPT6xRwyg5KmgdA" target="_blank" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Kunjungi Toko
                        </a>
                    </div>

                    <hr class="my-4">

                    <!-- Store Info -->
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

    <!-- Related Motors -->
    @if($relatedMotors->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">
                    <i class="fas fa-motorcycle text-primary me-2"></i>
                    Motor Serupa
                </h3>
                
                <div class="row g-4">
                    @foreach($relatedMotors as $motor)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="motor-card">
                                <!-- Motor Image Placeholder -->
                                <div class="motor-image">
                                    <i class="fas fa-motorcycle"></i>
                                </div>

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

                                    <!-- Categories -->
                                    @if($motor->categories->count() > 0)
                                        <div class="mb-3">
                                            @foreach($motor->categories->take(2) as $category)
                                                <span class="category-badge">{{ $category->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif

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

@push('styles')
<style>
    .motor-image-detail {
        position: relative;
        overflow: hidden;
    }

    .spec-list .spec-item:last-child {
        border-bottom: none !important;
    }

    .document-list .d-flex:last-child {
        border-bottom: none !important;
    }

    .store-info .info-item {
        display: flex;
        align-items: center;
    }

    @media (max-width: 991px) {
        .sticky-top {
            position: relative !important;
            top: auto !important;
        }
    }
</style>
@endpush
