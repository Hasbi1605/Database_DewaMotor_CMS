@extends('layouts.app-tanpa-sidebar')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="container-fluid p-4">
    <div class="max-w-screen-xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-2xl font-semibold text-gray-800">
                Tambah Kendaraan Baru
            </h1>
            <a href="{{ route('kendaraans.index') }}" class="btn-back">
                <i class="fa fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert-error mb-6">
                <div class="flex items-center">
                    <i class="fa fa-exclamation-circle text-xl me-3"></i>
                    <div>
                        <p class="font-medium">Mohon periksa kembali data yang diinput:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        <form action="{{ route('kendaraans.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informasi Identitas -->
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fa fa-id-card text-primary"></i>
                        <h2>Informasi Identitas Kendaraan</h2>
                    </div>
                    
                    <div class="form-group">
                        <label for="nomor_rangka">Nomor Rangka</label>
                        <div class="input-wrapper">
                            <i class="fa fa-fingerprint"></i>
                            <input type="text" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_mesin">Nomor Mesin</label>
                        <div class="input-wrapper">
                            <i class="fa fa-cog"></i>
                            <input type="text" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_polisi">Nomor Polisi</label>
                        <div class="input-wrapper">
                            <i class="fa fa-car"></i>
                            <input type="text" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}" required>
                        </div>
                    </div>
                </div>

                <!-- Detail Kendaraan -->
                <div class="form-section">
                    <div class="form-section-header">
                        <i class="fa fa-info-circle text-primary"></i>
                        <h2>Detail Kendaraan</h2>
                    </div>

                    <div class="form-group">
                        <label for="merek">Merek</label>
                        <div class="input-wrapper">
                            <i class="fa fa-trademark"></i>
                            <input type="text" id="merek" name="merek" value="{{ old('merek') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="model">Model</label>
                        <div class="input-wrapper">
                            <i class="fa fa-motorcycle"></i>
                            <input type="text" id="model" name="model" value="{{ old('model') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tahun_pembuatan">Tahun Pembuatan</label>
                        <div class="input-wrapper">
                            <i class="fa fa-calendar"></i>
                            <input type="number" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Harga -->
            <div class="form-section mt-6">
                <div class="form-section-header">
                    <i class="fa fa-money-bill text-primary"></i>
                    <h2>Informasi Harga</h2>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="harga_modal">Harga Modal</label>
                        <div class="input-wrapper">
                            <span class="currency">Rp</span>
                            <input type="number" id="harga_modal" name="harga_modal" value="{{ old('harga_modal') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <div class="input-wrapper">
                            <span class="currency">Rp</span>
                            <input type="number" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('kendaraans.index') }}" class="btn-secondary">
                    <i class="fa fa-times me-2"></i>
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/kendaraans/create.css') }}">
@endpush
@endsection