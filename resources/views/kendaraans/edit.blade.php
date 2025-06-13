@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">
                Edit Kendaraan
                <span class="badge bg-{{ $kendaraan->status === 'tersedia' ? 'success' : 'danger' }}">
                    {{ ucfirst($kendaraan->status) }}
                </span>
            </h4>
            <a href="{{ route('kendaraans.index') }}" class="btn btn-pr btn-danger ms-auto">
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
            <!-- Informasi Identitas Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Informasi Identitas Kendaraan</h5>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_rangka" class="form-label">Nomor Rangka</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-fingerprint"></i></span>
                            <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka', $kendaraan->nomor_rangka) }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_mesin" class="form-label">Nomor Mesin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-cog"></i></span>
                            <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-car"></i></span>
                            <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi', $kendaraan->nomor_polisi) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Kendaraan -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Detail Kendaraan</h5>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek', $kendaraan->merek) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="model" class="form-label">Model</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-motorcycle"></i></span>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $kendaraan->model) }}" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="harga_modal" class="form-label">Harga Modal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                            <input type="number" class="form-control" id="harga_modal" name="harga_modal" value="{{ old('harga_modal', $kendaraan->harga_modal) }}" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-tag"></i></span>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $kendaraan->harga_jual) }}" step="0.01" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Kategori Kendaraan</h5>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="class_category" class="form-label">Kelas Kendaraan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-layer-group"></i></span>
                            <select class="form-select" id="class_category" name="class_category">
                                <option value="">Pilih Kelas Kendaraan</option>
                                @foreach($categories['class'] ?? [] as $category)
                                    @php
                                        $isSelected = $kendaraan->categories->where('type', 'class')->pluck('id')->contains($category->id);
                                    @endphp
                                    <option value="{{ $category->id }}" 
                                        {{ old('class_category', $isSelected ? $category->id : '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="brand_category" class="form-label">Kategori Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <select class="form-select" id="brand_category" name="brand_category">
                                <option value="">Pilih Kategori Merek</option>
                                @foreach($categories['brand'] ?? [] as $category)
                                    @php
                                        $isSelected = $kendaraan->categories->where('type', 'brand')->pluck('id')->contains($category->id);
                                    @endphp
                                    <option value="{{ $category->id }}" 
                                        {{ old('brand_category', $isSelected ? $category->id : '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="document_category" class="form-label">Kelengkapan Dokumen</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-file-alt"></i></span>
                            <select class="form-select" id="document_category" name="document_category">
                                <option value="">Pilih Kelengkapan Dokumen</option>
                                @foreach($categories['document'] ?? [] as $category)
                                    @php
                                        $isSelected = $kendaraan->categories->where('type', 'document')->pluck('id')->contains($category->id);
                                    @endphp
                                    <option value="{{ $category->id }}" 
                                        {{ old('document_category', $isSelected ? $category->id : '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="condition_category" class="form-label">Kondisi Kendaraan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-wrench"></i></span>
                            <select class="form-select" id="condition_category" name="condition_category">
                                <option value="">Pilih Kondisi Kendaraan</option>
                                @foreach($categories['condition'] ?? [] as $category)
                                    @php
                                        $isSelected = $kendaraan->categories->where('type', 'condition')->pluck('id')->contains($category->id);
                                    @endphp
                                    <option value="{{ $category->id }}" 
                                        {{ old('condition_category', $isSelected ? $category->id : '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
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