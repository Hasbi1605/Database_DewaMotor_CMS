@extends('layouts.app')

@section('title', 'Tambah Kendaraan')

@section('content')
<!-- Card Container untuk Form Tambah Kendaraan -->
<div class="card">
    <!-- Header Card dengan Judul dan Tombol Kembali -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Tambah Kendaraan Baru</h4>
            <a href="{{ route('kendaraans.index') }}" class="btn btn-danger btn-round ms-auto">
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

        <!-- Form Tambah Kendaraan dengan Upload -->
        <form action="{{ route('kendaraans.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Section 1: Informasi Identitas Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Informasi Identitas Kendaraan</h5>
                </div>
                <!-- Input Nomor Rangka -->
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_rangka" class="form-label">Nomor Rangka</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-fingerprint"></i></span>
                            <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka') }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Input Nomor Mesin -->
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_mesin" class="form-label">Nomor Mesin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-cog"></i></span>
                            <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin') }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Input Nomor Polisi -->
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-car"></i></span>
                            <input type="text" class="form-control" id="nomor_polisi" name="nomor_polisi" value="{{ old('nomor_polisi') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Detail Kendaraan -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Detail Kendaraan</h5>
                </div>
                <!-- Kolom Kiri: Merek, Model, Tahun -->
                <div class="col-md-6">
                    <!-- Input Merek -->
                    <div class="form-group mb-3">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek') }}" required>
                        </div>
                    </div>

                    <!-- Input Model -->
                    <div class="form-group mb-3">
                        <label for="model" class="form-label">Model</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-motorcycle"></i></span>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" required>
                        </div>
                    </div>

                    <!-- Input Tahun Pembuatan -->
                    <div class="form-group mb-3">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan') }}" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Harga Modal dan Jual -->
                <div class="col-md-6">
                    <!-- Input Harga Modal -->
                    <div class="form-group mb-3">
                        <label for="harga_modal" class="form-label">Harga Modal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                            <input type="number" class="form-control" id="harga_modal" name="harga_modal" value="{{ old('harga_modal') }}" step="0.01" required>
                        </div>
                    </div>

                    <!-- Input Harga Jual -->
                    <div class="form-group mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-tag"></i></span>
                            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" step="0.01" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kategori Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Kategori Kendaraan</h5>
                </div>
                <!-- Dropdown Kelas Kendaraan -->
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="class_category" class="form-label">Kelas Kendaraan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-layer-group"></i></span>
                            <select class="form-select" id="class_category" name="class_category">
                                <option value="">Pilih Kelas Kendaraan</option>
                                @foreach($categories['class'] ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('class_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Dropdown Kategori Merek -->
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="brand_category" class="form-label">Kategori Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <select class="form-select" id="brand_category" name="brand_category">
                                <option value="">Pilih Kategori Merek</option>
                                @foreach($categories['brand'] ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('brand_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Dropdown Kelengkapan Dokumen -->
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="document_category" class="form-label">Kelengkapan Dokumen</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-file-alt"></i></span>
                            <select class="form-select" id="document_category" name="document_category">
                                <option value="">Pilih Kelengkapan Dokumen</option>
                                @foreach($categories['document'] ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('document_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Dropdown Kondisi Kendaraan -->
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="condition_category" class="form-label">Kondisi Kendaraan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-wrench"></i></span>
                            <select class="form-select" id="condition_category" name="condition_category">
                                <option value="">Pilih Kondisi Kendaraan</option>
                                @foreach($categories['condition'] ?? [] as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('condition_category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Upload Foto Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Foto Kendaraan</h5>
                </div>
                <div class="col-12">
                    <!-- Drag & Drop Zone untuk Upload Foto -->
                    <div class="form-group mb-3">
                        <label for="photos" class="form-label">Upload Foto</label>
                        <div class="photo-upload-zone" id="photo-upload-zone">
                            <div class="text-center">
                                <i class="fa fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <h6>Drag & Drop foto di sini</h6>
                                <p class="text-muted">atau</p>
                                <input type="file" class="form-control" id="photos" name="photos[]" multiple accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('photos').click()">
                                    <i class="fa fa-plus"></i> Pilih Foto
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">
                            Pilih beberapa foto sekaligus. Format yang didukung: JPG, PNG, GIF. Maksimal 2MB per foto.
                        </small>
                    </div>
                    
                    <!-- Container Preview Foto -->
                    <div id="photo-preview" class="row mt-3" style="display: none;">
                        <div class="col-12">
                            <h6>Preview Foto:</h6>
                            <div id="preview-container" class="photo-preview-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save me-2"></i>
                    Simpan Kendaraan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript untuk Drag & Drop dan Preview Foto -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photos');
    const previewContainer = document.getElementById('preview-container');
    const photoPreview = document.getElementById('photo-preview');
    const uploadZone = document.getElementById('photo-upload-zone');
    let selectedFiles = [];

    // Event handler untuk drag and drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        handleFiles(files);
    });

    // Event handler untuk file input
    photoInput.addEventListener('change', function(e) {
        const files = e.target.files;
        handleFiles(files);
    });

    // Fungsi untuk menangani file yang dipilih
    function handleFiles(files) {
        selectedFiles = Array.from(files);
        displayPreviews();
    }

    // Fungsi untuk menampilkan preview foto
    function displayPreviews() {
        previewContainer.innerHTML = '';
        
        if (selectedFiles.length > 0) {
            photoPreview.style.display = 'block';
            
            selectedFiles.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const imageContainer = document.createElement('div');
                        imageContainer.className = 'photo-preview-item';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'photo-preview-remove';
                        removeBtn.innerHTML = '<i class="fa fa-times"></i>';
                        removeBtn.onclick = function() {
                            selectedFiles.splice(index, 1);
                            updateFileInput();
                            displayPreviews();
                        };
                        
                        imageContainer.appendChild(img);
                        imageContainer.appendChild(removeBtn);
                        previewContainer.appendChild(imageContainer);
                    };
                    
                    reader.readAsDataURL(file);
                }
            });
        } else {
            photoPreview.style.display = 'none';
        }
    }

    // Fungsi untuk update file input
    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        photoInput.files = dt.files;
    }
});
</script>

@endsection
