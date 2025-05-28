@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">
                Detail Kendaraan
                <span class="badge bg-{{ $kendaraan->status === 'aktif' ? 'success' : 'secondary' }}">
                    {{ ucfirst($kendaraan->status) }}
                </span>
            </h4>
            <div class="ms-auto">
                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-warning btn-sm me-2">
                    <i class="fa fa-edit"></i>
                    Edit Data
                </a>
                <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary btn-sm">
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
                <div class="card">
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
                    <div class="card-header bg-info text-white">
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
                                                    <i class="fa fa-calendar me-1"></i>
                                                    Berlaku: {{ \Carbon\Carbon::parse($dokumen->tanggal_berlaku)->format('d/m/Y') }}
                                                </small>
                                            </div>
                                            @if($dokumen->file_path)
                                                <a href="{{ Storage::url($dokumen->file_path) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted mb-0">Tidak ada dokumen yang tersedia.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection