@extends('layouts.app')

@section('title', 'Detail Kendaraan')
@section('page-title', 'Detail Kendaraan')

@section('content')
<!-- Header Section -->
<div class="card fade-in">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-2">
                    Detail Kendaraan
                    <span class="badge bg-{{ $kendaraan->status === 'tersedia' ? 'success' : 'danger' }}">
                        <i class="fas fa-{{ $kendaraan->status === 'tersedia' ? 'check' : 'times' }} me-1"></i>
                        {{ ucfirst($kendaraan->status) }}
                    </span>
                </h4>
                <p class="text-muted mb-0">{{ $kendaraan->merek }} {{ $kendaraan->model }} - {{ $kendaraan->nomor_polisi }}</p>
            </div>
            
            <div class="d-flex gap-2">
                @if($kendaraan->status == 'tersedia')
                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="terjual">
                        <button type="submit" class="btn btn-success" 
                                onclick="return confirm('Tandai sebagai terjual?')" 
                                title="Tandai sebagai Terjual">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Tandai Terjual
                        </button>
                    </form>
                @else
                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="tersedia">
                        <button type="submit" class="btn btn-warning" 
                                onclick="return confirm('Kembalikan ke tersedia?')" 
                                title="Kembalikan ke Tersedia">
                            <i class="fas fa-undo me-1"></i>
                            Kembalikan
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-info">
                    <i class="fas fa-edit me-1"></i>
                    Edit
                </a>
                
                <a href="{{ route('kendaraans.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
                    Kembali
                </a>
            </div>
        </div>
    </div>
    
    <!-- Body Card berisi Detail Kendaraan -->
    <div class="card-body">
        <div class="row">
            <!-- Section Foto Kendaraan -->
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-camera me-2"></i>
                            @if($kendaraan->photos && count($kendaraan->photos) > 0)
                                Foto Kendaraan ({{ count($kendaraan->photos) }} foto)
                            @else
                                Foto Kendaraan
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Grid Foto atau Pesan Kosong -->
                        @if($kendaraan->photos && count($kendaraan->photos) > 0)
                            <div class="row">
                                @foreach($kendaraan->photos as $index => $photo)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <!-- Gambar dengan Modal Click -->
                                        <img src="{{ asset('storage/' . $photo) }}" 
                                             class="card-img-top" 
                                             style="height: 250px; object-fit: cover; cursor: pointer;"
                                             onclick="showImageModal('{{ asset('storage/' . $photo) }}', 'Foto {{ $kendaraan->merek }} {{ $kendaraan->model }} #{{ $index + 1 }}')">
                                        <div class="card-body p-2 text-center">
                                            <small class="text-muted">Foto {{ $index + 1 }}</small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Pesan Tidak Ada Foto -->
                            <div class="text-center text-muted py-4">
                                <i class="fa fa-image fa-4x mb-3"></i>
                                <h6>Belum ada foto untuk kendaraan ini</h6>
                                <p class="mb-0">Klik <a href="{{ route('kendaraans.edit', $kendaraan->id) }}">Edit Data</a> untuk menambahkan foto.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Kiri: Informasi Detail -->
            <div class="col-md-8">
                <!-- Card Informasi Identitas -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white ">
                        <h5 class="mb-0">
                            <i class="fa fa-id-card me-2"></i>
                            Informasi Identitas Kendaraan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nomor Polisi</label>
                                <p>{{ $kendaraan->nomor_polisi ?: '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nomor Rangka</label>
                                <p>{{ $kendaraan->nomor_rangka }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nomor Mesin</label>
                                <p>{{ $kendaraan->nomor_mesin }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Detail Kendaraan -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-info-circle me-2"></i>
                            Detail Kendaraan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Merek</label>
                                <p>{{ $kendaraan->merek }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Model</label>
                                <p>{{ $kendaraan->model }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tahun Pembuatan</label>
                                <p>{{ $kendaraan->tahun_pembuatan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Kategori Kendaraan -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-tags me-2"></i>
                            Kategori Kendaraan
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $categoriesByType = $kendaraan->categories->groupBy('type');
                        @endphp

                        <div class="row">
                            <!-- Kelas Kendaraan -->
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Kelas Kendaraan:</h6>
                                @forelse($categoriesByType['class'] ?? [] as $category)
                                    <span class="badge bg-primary me-2">{{ $category->name }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>

                            <!-- Merek -->
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Merek:</h6>
                                @forelse($categoriesByType['brand'] ?? [] as $category)
                                    <span class="badge bg-info me-2">{{ $category->name }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>

                            <!-- Kelengkapan Dokumen -->
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Kelengkapan Dokumen:</h6>
                                @forelse($categoriesByType['document'] ?? [] as $category)
                                    <span class="badge bg-warning me-2">{{ $category->name }}</span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>

                            <!-- Kondisi -->
                            <div class="col-md-6 mb-3">
                                <h6 class="mb-2">Kondisi Kendaraan:</h6>
                                @forelse($categoriesByType['condition'] ?? [] as $category)
                                    <span class="badge bg-{{ $category->name === 'Mulus' ? 'success' : ($category->name === 'Normal' ? 'info' : 'danger') }} me-2">
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kolom Kanan: Informasi Harga dan Dokumen -->
            <div class="col-md-4">
                <!-- Informasi Harga -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-money-bill me-2"></i>
                            Informasi Harga
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Modal</label>
                            <p class="h5">Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga Jual</label>
                            <p class="h5 text-success">Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</p>
                        </div>
                        @if($kendaraan->status == 'terjual')
                            <div>
                                <label class="form-label fw-bold">Keuntungan</label>
                                <p class="h5 text-primary">Rp {{ number_format($kendaraan->harga_jual - $kendaraan->harga_modal, 0, ',', '.') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Dokumen Kendaraan -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fa fa-file-alt me-2"></i>
                            Dokumen Kendaraan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($kendaraan->dokumen->count() > 0)
                            <div class="list-group">
                                @foreach($kendaraan->dokumen as $dokumen)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">{{ $dokumen->jenis_dokumen }}</h6>
                                                <small class="text-muted">
                                                    No: {{ $dokumen->nomor_dokumen }}
                                                </small>
                                            </div>
                                            <div class="text-end d-flex align-items-center">
                                                <span class="badge bg-{{ $dokumen->tanggal_expired && $dokumen->tanggal_expired->isPast() ? 'danger' : 'success' }} me-2">
                                                    {{ $dokumen->tanggal_expired ? $dokumen->tanggal_expired->format('d/m/Y') : 'Tidak ada expired' }}
                                                </span>
                                                {{-- Tombol untuk melihat file dokumen --}}
                                                @if(isset($dokumen->file_path) && $dokumen->file_path)
                                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-info mt-1" title="Lihat File">
                                                        <i class="fa fa-file me-1"></i>Lihat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada dokumen terkait</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk menampilkan gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto Kendaraan" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(imageSrc, title) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModalLabel').textContent = title;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endsection