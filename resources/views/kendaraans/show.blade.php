@extends('layouts.app-tanpa-sidebar')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="container-fluid p-4">
    <div class="max-w-screen-xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">
                Detail Kendaraan
                <span class="badge-status status-{{ $kendaraan->status }}">{{ ucfirst($kendaraan->status) }}</span>
            </h1>
            <div class="flex gap-3">
                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn-edit">
                    <i class="fa fa-edit me-2"></i>
                    Edit Data
                </a>
                <a href="{{ route('kendaraans.index') }}" class="btn-back">
                    <i class="fa fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informasi Identitas -->
            <div class="lg:col-span-2">
                <div class="info-section">
                    <div class="info-header">
                        <i class="fa fa-id-card"></i>
                        <h2>Informasi Identitas Kendaraan</h2>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nomor Polisi</span>
                            <span class="info-value">{{ $kendaraan->nomor_polisi ?: '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Rangka</span>
                            <span class="info-value">{{ $kendaraan->nomor_rangka }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Nomor Mesin</span>
                            <span class="info-value">{{ $kendaraan->nomor_mesin }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-section mt-6">
                    <div class="info-header">
                        <i class="fa fa-info-circle"></i>
                        <h2>Detail Kendaraan</h2>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Merek</span>
                            <span class="info-value">{{ $kendaraan->merek }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Model</span>
                            <span class="info-value">{{ $kendaraan->model }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tahun Pembuatan</span>
                            <span class="info-value">{{ $kendaraan->tahun_pembuatan }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Harga -->
            <div class="lg:col-span-1">
                <div class="price-section">
                    <div class="info-header">
                        <i class="fa fa-money-bill"></i>
                        <h2>Informasi Harga</h2>
                    </div>
                    <div class="price-details">
                        <div class="price-item">
                            <span class="price-label">Harga Modal</span>
                            <span class="price-value">Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</span>
                        </div>
                        <div class="price-item">
                            <span class="price-label">Harga Jual</span>
                            <span class="price-value text-success">Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</span>
                        </div>
                        @if($kendaraan->status == 'terjual')
                        <div class="price-item profit">
                            <span class="price-label">Keuntungan</span>
                            <span class="price-value text-primary">Rp {{ number_format($kendaraan->harga_jual - $kendaraan->harga_modal, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if(isset($kendaraan->catatan) && $kendaraan->catatan)
                <div class="notes-section mt-6">
                    <div class="info-header">
                        <i class="fa fa-sticky-note"></i>
                        <h2>Catatan</h2>
                    </div>
                    <p class="notes-content">{{ $kendaraan->catatan }}</p>
                </div>
                @endif

                <div class="delete-section mt-6">
                    <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini? Operasi ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i class="fa fa-trash-alt me-2"></i>
                            Hapus Kendaraan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/kendaraans/show.css') }}">
@endpush
@endsection