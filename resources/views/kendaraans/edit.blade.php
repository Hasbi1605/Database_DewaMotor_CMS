@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Edit Kendaraan</h4>
            <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary btn-round ml-auto">
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

        <form action="{{ route('kendaraans.update', $kendaraan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" class="form-control" value="{{ old('nomor_rangka', $kendaraan->nomor_rangka) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" class="form-control" value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Polisi</label>
                        <input type="text" name="nomor_polisi" class="form-control" value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Merek</label>
                        <input type="text" name="merek" class="form-control" value="{{ old('merek', $kendaraan->merek) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Model</label>
                        <input type="text" name="model" class="form-control" value="{{ old('model', $kendaraan->model) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tahun Pembuatan</label>
                        <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Modal</label>
                        <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal', $kendaraan->harga_modal) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual', $kendaraan->harga_jual) }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection