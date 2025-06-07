@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">
                Detail Kendaraan
                <span class="badge bg-{{ $kendaraan->status === 'tersedia' ? 'success' : 'danger' }}">
                    {{ ucfirst($kendaraan->status) }}
                </span>
            </h4>
            <div class="ms-auto">
                @if($kendaraan->status == 'tersedia')
                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline me-2">
                        @csrf
                        <input type="hidden" name="status" value="terjual">
                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menandai kendaraan ini sebagai terjual?')" title="Tandai sebagai Terjual">
                            <i class="fa fa-check"></i>
                            Tandai Terjual
                        </button>
                    </form>
                @elseif($kendaraan->status == 'terjual')
                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline me-2">
                        @csrf
                        <input type="hidden" name="status" value="tersedia">
                        <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengembalikan status kendaraan ini ke tersedia?')" title="Kembalikan ke Tersedia">
                            <i class="fa fa-undo"></i>
                            Kembalikan ke Tersedia
                        </button>
                    </form>
                @endif
                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-sm btn-info">
                    <i class="fa fa-edit"></i>
                    Edit Data
                </a>
                <a href="{{ route('kendaraans.index') }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <!-- Informasi Identitas -->
                <div class="card mb-4">
                    <div class="card-header">
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

                <!-- Detail Kendaraan -->
                <div class="card mb-4">
                    <div class="card-header">
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

                <!-- Kategori -->
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
@endsection