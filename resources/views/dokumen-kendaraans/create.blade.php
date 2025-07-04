@extends('layouts.app')

@section('title', 'Tambah Dokumen Kendaraan')

@section('content')
<!-- Card Container untuk Form Tambah Dokumen -->
<div class="card">
    <!-- Header Card dengan Judul dan Tombol Kembali -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Tambah Dokumen Kendaraan</h4>
            <a href="{{ route('dokumen-kendaraans.index') }}" class="btn btn-danger btn-round ms-auto">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
    
    <!-- Body Card berisi Form -->
    <div class="card-body">
        <!-- Alert untuk menampilkan Error Validasi -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Form Tambah Dokumen dengan Upload File -->
        <form action="{{ route('dokumen-kendaraans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Kolom Kiri: Data Utama Dokumen -->
                <div class="col-md-6">
                    <!-- Dropdown Pilih Kendaraan -->
                    <div class="form-group mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan</label>
                        <select name="kendaraan_id" id="kendaraan_id" class="form-select" required {{ isset($selectedKendaraanId) ? 'disabled' : '' }}>
                            <option value="">Pilih Kendaraan</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ (old('kendaraan_id', $selectedKendaraanId) == $kendaraan->id) ? 'selected' : '' }}>
                                    {{ $kendaraan->merek }} {{ $kendaraan->model }} - {{ $kendaraan->nomor_polisi }}
                                </option>
                            @endforeach
                        </select>
                        @if(isset($selectedKendaraanId))
                            <input type="hidden" name="kendaraan_id" value="{{ $selectedKendaraanId }}">
                        @endif
                    </div>

                    <!-- Dropdown Jenis Dokumen -->
                    <div class="form-group mb-3">
                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                        <select name="jenis_dokumen" id="jenis_dokumen" class="form-select" required {{ isset($selectedJenisDokumen) ? 'disabled' : '' }}>
                            <option value="">Pilih Jenis Dokumen</option>
                            <option value="STNK" {{ old('jenis_dokumen', $selectedJenisDokumen) == 'STNK' ? 'selected' : '' }}>STNK</option>
                            <option value="BPKB" {{ old('jenis_dokumen', $selectedJenisDokumen) == 'BPKB' ? 'selected' : '' }}>BPKB</option>
                            <option value="Faktur" {{ old('jenis_dokumen', $selectedJenisDokumen) == 'Faktur' ? 'selected' : '' }}>Faktur</option>
                        </select>
                        @if(isset($selectedJenisDokumen))
                            <input type="hidden" name="jenis_dokumen" value="{{ $selectedJenisDokumen }}">
                        @endif
                    </div>

                    <!-- Input Nomor Dokumen -->
                    <div class="form-group mb-3">
                        <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                        <input type="text" class="form-control" id="nomor_dokumen" name="nomor_dokumen" value="{{ old('nomor_dokumen') }}" required>
                    </div>
                </div>

                <!-- Kolom Kanan: Tanggal dan File -->
                <div class="col-md-6">
                    <!-- Input Tanggal Terbit -->
                    <div class="form-group mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" required>
                    </div>

                    <!-- Input Tanggal Expired -->
                    <div class="form-group mb-3">
                        <label for="tanggal_expired" class="form-label">Tanggal Expired</label>
                        <input type="date" class="form-control" id="tanggal_expired" name="tanggal_expired" value="{{ old('tanggal_expired') }}">
                    </div>

                    <!-- Input File Upload -->
                    <div class="form-group mb-3">
                        <label for="file" class="form-label">File Dokumen</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG</small>
                    </div>

                    <!-- Textarea Keterangan -->
                    <div class="form-group mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Dokumen
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
