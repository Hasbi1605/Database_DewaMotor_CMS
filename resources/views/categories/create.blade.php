@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<!-- Card Container untuk Form Tambah Kategori -->
<div class="card">
    <!-- Header Card dengan Judul dan Tombol Kembali -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Tambah Kategori</h4>
            <a href="{{ route('categories.index') }}" class="btn btn-danger btn-round ms-auto">
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

        <!-- Form Tambah Kategori -->
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Kolom Kiri: Input Nama dan Tipe -->
                <div class="col-md-6">
                    <!-- Input Nama Kategori -->
                    <div class="form-group mb-3">
                        <label for="name" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <!-- Dropdown Tipe Kategori -->
                    <div class="form-group mb-3">
                        <label for="type" class="form-label">Tipe Kategori</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">Pilih Tipe Kategori</option>
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>
                                    @if($type == 'class')
                                        Kelas Kendaraan
                                    @elseif($type == 'brand')
                                        Merek
                                    @elseif($type == 'document')
                                        Kelengkapan Dokumen
                                    @elseif($type == 'condition')
                                        Kondisi Kendaraan
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Kolom Kanan: Textarea Deskripsi -->
                <div class="col-md-6">
                    <!-- Textarea Deskripsi Kategori -->
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="6">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
