@extends('layouts.app')

@section('title', 'Edit Dokumen Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Edit Dokumen Kendaraan</h4>
            <a href="{{ route('dokumen-kendaraans.index') }}" class="btn btn-danger btn-round ms-auto">
                <i class="fa fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
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

        <form action="{{ route('dokumen-kendaraans.update', $dokumenKendaraan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="kendaraan_id" class="form-label">Kendaraan</label>
                        <select name="kendaraan_id" id="kendaraan_id" class="form-select" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $dokumenKendaraan->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->merek }} {{ $kendaraan->model }} - {{ $kendaraan->nomor_polisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                        <select name="jenis_dokumen" id="jenis_dokumen" class="form-select" required>
                            <option value="">Pilih Jenis Dokumen</option>
                            <option value="STNK" {{ old('jenis_dokumen', $dokumenKendaraan->jenis_dokumen) == 'STNK' ? 'selected' : '' }}>STNK</option>
                            <option value="BPKB" {{ old('jenis_dokumen', $dokumenKendaraan->jenis_dokumen) == 'BPKB' ? 'selected' : '' }}>BPKB</option>
                            <option value="Faktur" {{ old('jenis_dokumen', $dokumenKendaraan->jenis_dokumen) == 'Faktur' ? 'selected' : '' }}>Faktur</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_dokumen" class="form-label">Nomor Dokumen</label>
                        <input type="text" class="form-control" id="nomor_dokumen" name="nomor_dokumen" value="{{ old('nomor_dokumen', $dokumenKendaraan->nomor_dokumen) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" value="{{ old('tanggal_terbit', $dokumenKendaraan->tanggal_terbit->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_expired" class="form-label">Tanggal Expired</label>
                        <input type="date" class="form-control" id="tanggal_expired" name="tanggal_expired" value="{{ old('tanggal_expired', $dokumenKendaraan->tanggal_expired ? $dokumenKendaraan->tanggal_expired->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="file" class="form-label">File Dokumen</label>
                        @if($dokumenKendaraan->file_path)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $dokumenKendaraan->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fa fa-file me-2"></i>Lihat File Saat Ini
                                </a>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Format yang diizinkan: PDF, JPG, JPEG, PNG. Biarkan kosong jika tidak ingin mengubah file.</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $dokumenKendaraan->keterangan) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
