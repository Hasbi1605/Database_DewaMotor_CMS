@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Tambah Kendaraan Baru</h4>
            <a href="{{ route('kendaraans.index') }}" class="btn btn-danger btn-round ms-auto">
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

        <form action="{{ route('kendaraans.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3">Informasi Identitas Kendaraan</h5>
                    
                    <div class="form-group mb-3">
                        <label for="nomor_rangka" class="form-label">Nomor Rangka</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-fingerprint"></i></span>
                            <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_mesin" class="form-label">Nomor Mesin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-cog"></i></span>
                            <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-car"></i></span>
                            <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3">Detail Kendaraan</h5>

                    <div class="form-group mb-3">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="model" class="form-label">Model</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-motorcycle"></i></span>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan') }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga_modal" class="form-label">Harga Modal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                            <input type="number" class="form-control" id="harga_modal" name="harga_modal" value="{{ old('harga_modal') }}" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-tag"></i></span>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" step="0.01" required>
                        </div>
                    </div>
                </div>

                <!-- Kategori Kendaraan -->
                <div class="col-12">
                    <h5 class="mb-3">Kategori Kendaraan</h5>
                    
                    <!-- Kelas Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label">Kelas Kendaraan</label>
                        <div class="row">
                            @foreach($categories['class'] ?? [] as $category)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                        value="{{ $category->id }}" id="category{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Merek -->
                    <div class="mb-3">
                        <label class="form-label">Merek</label>
                        <div class="row">
                            @foreach($categories['brand'] ?? [] as $category)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                        value="{{ $category->id }}" id="category{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kelengkapan Dokumen -->
                    <div class="mb-3">
                        <label class="form-label">Kelengkapan Dokumen</label>
                        <div class="row">
                            @foreach($categories['document'] ?? [] as $category)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                        value="{{ $category->id }}" id="category{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kondisi Kendaraan -->
                    <div class="mb-3">
                        <label class="form-label">Kondisi Kendaraan</label>
                        <div class="row">
                            @foreach($categories['condition'] ?? [] as $category)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="categories[]" 
                                        value="{{ $category->id }}" id="category{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection