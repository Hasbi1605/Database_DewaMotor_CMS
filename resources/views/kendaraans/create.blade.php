@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Tambah Kendaraan Baru</h4>
            <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary btn-sm ms-auto">
                <i class="fa fa-arrow-left me-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <div>
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('kendaraans.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fa fa-id-card me-2"></i>
                                Informasi Identitas Kendaraan
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Rangka</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-fingerprint text-primary"></i>
                                    </span>
                                    <input type="text" name="nomor_rangka" class="form-control" value="{{ old('nomor_rangka') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Mesin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-cog text-primary"></i>
                                    </span>
                                    <input type="text" name="nomor_mesin" class="form-control" value="{{ old('nomor_mesin') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Polisi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-car text-primary"></i>
                                    </span>
                                    <input type="text" name="nomor_polisi" class="form-control" value="{{ old('nomor_polisi') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-light border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fa fa-info-circle me-2"></i>
                                Detail Kendaraan
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Merek</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-trademark text-primary"></i>
                                    </span>
                                    <input type="text" name="merek" class="form-control" value="{{ old('merek') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Model</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-motorcycle text-primary"></i>
                                    </span>
                                    <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tahun Pembuatan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="fa fa-calendar text-primary"></i>
                                    </span>
                                    <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <div class="card bg-light border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fa fa-money-bill me-2"></i>
                                Informasi Harga
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Harga Modal</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">Rp</span>
                                            <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Harga Jual</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white">Rp</span>
                                            <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary">
                    <i class="fa fa-times me-2"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.card {
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.input-group-text {
    border-right: 0;
}
.input-group .form-control {
    border-left: 0;
}
.input-group:focus-within {
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
    border-radius: 0.375rem;
}
.input-group:focus-within .input-group-text,
.input-group:focus-within .form-control {
    border-color: #86b7fe;
}
.form-control:focus {
    box-shadow: none;
}
.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.btn {
    padding: 0.5rem 1rem;
}
.btn-sm {
    padding: 0.25rem 0.5rem;
}
.alert {
    border: 0;
}
</style>
@endpush
@endsection