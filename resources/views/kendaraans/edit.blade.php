@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
<style>
.price-input {
    text-align: left;
}
.price-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
.price-input.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}
.price-input.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}
</style>

<!-- Card Container untuk Form Edit Kendaraan -->
<div class="card">
    <!-- Header Card dengan Status dan Tombol Kembali -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">
                Edit Kendaraan
                <!-- Badge Status Kendaraan -->
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
    
    <!-- Body Card berisi Form Edit -->
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

        <!-- Form Edit Kendaraan -->
        <form action="{{ route('kendaraans.update', $kendaraan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Section 1: Informasi Identitas Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Informasi Identitas Kendaraan</h5>
                </div>
                <!-- Input Nomor Rangka (Pre-filled) -->
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_rangka" class="form-label">Nomor Rangka</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-fingerprint"></i></span>
                            <input type="text" class="form-control" id="nomor_rangka" name="nomor_rangka" value="{{ old('nomor_rangka', $kendaraan->nomor_rangka) }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Input Nomor Mesin (Pre-filled) -->
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="nomor_mesin" class="form-label">Nomor Mesin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-cog"></i></span>
                            <input type="text" class="form-control" id="nomor_mesin" name="nomor_mesin" value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}" required>
                        </div>
                    </div>
                </div>
                
                <!-- Input Nomor Polisi (Pre-filled) -->
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

            <!-- Section 2: Detail Kendaraan -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">Detail Kendaraan</h5>
                </div>
                <!-- Kolom Kiri: Merek, Model, Tahun -->
                <div class="col-md-6">
                    <!-- Input Merek (Pre-filled) -->
                    <div class="form-group mb-3">
                        <label for="merek" class="form-label">Merek</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-trademark"></i></span>
                            <input type="text" class="form-control" id="merek" name="merek" value="{{ old('merek', $kendaraan->merek) }}" required>
                        </div>
                    </div>

                    <!-- Input Model (Pre-filled) -->
                    <div class="form-group mb-3">
                        <label for="model" class="form-label">Model</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-motorcycle"></i></span>
                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model', $kendaraan->model) }}" required>
                        </div>
                    </div>

                    <!-- Input Tahun Pembuatan (Pre-filled) -->
                    <div class="form-group mb-3">
                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="number" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}" required>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Harga Modal dan Jual -->
                <div class="col-md-6">
                    <!-- Input Harga Modal (Pre-filled) -->
                    <div class="form-group mb-3">
                        <label for="harga_modal" class="form-label">Harga Modal</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-money-bill"></i></span>
                            <input type="text" class="form-control price-input" id="harga_modal_display" value="{{ old('harga_modal', $kendaraan->harga_modal) ? number_format(old('harga_modal', $kendaraan->harga_modal), 0, ',', '.') : '' }}" placeholder="0" required>
                            <input type="hidden" id="harga_modal" name="harga_modal" value="{{ old('harga_modal', $kendaraan->harga_modal) }}">
                        </div>
                    </div>

                    <!-- Input Harga Jual (Pre-filled) -->
                    <div class="form-group mb-3">
                        <label for="harga_jual" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-tag"></i></span>
                            <input type="text" class="form-control price-input" id="harga_jual_display" value="{{ old('harga_jual', $kendaraan->harga_jual) ? number_format(old('harga_jual', $kendaraan->harga_jual), 0, ',', '.') : '' }}" placeholder="0" required>
                            <input type="hidden" id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $kendaraan->harga_jual) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Kategori Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Kategori Kendaraan</h5>
                </div>
                <!-- Dropdown Kelas Kendaraan (Pre-selected) -->
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
                
                <!-- Dropdown Kategori Merek (Pre-selected) -->
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
                
                <!-- Dropdown Kelengkapan Dokumen (Pre-selected) -->
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
                
                <!-- Dropdown Kondisi Kendaraan (Pre-selected) -->
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

            <!-- Foto Kendaraan -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">Foto Kendaraan</h5>
                </div>
                
                <!-- Existing Photos -->
                @if($kendaraan->photos && count($kendaraan->photos) > 0)
                <div class="col-12 mb-3">
                    <h6>Foto Saat Ini:</h6>
                    <div class="row" id="existing-photos">
                        @foreach($kendaraan->photos as $index => $photo)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $photo) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeExistingPhoto('{{ $photo }}', {{ $index }})">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upload New Photos -->
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label for="photos" class="form-label">Tambah Foto Baru</label>
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
                    
                    <!-- Preview Container -->
                    <div id="photo-preview" class="row mt-3" style="display: none;">
                        <div class="col-12">
                            <h6>Preview Foto Baru:</h6>
                            <div id="preview-container" class="photo-preview-container"></div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photos');
    const previewContainer = document.getElementById('preview-container');
    const photoPreview = document.getElementById('photo-preview');
    const uploadZone = document.getElementById('photo-upload-zone');
    let selectedFiles = [];

    // Fungsi drag and drop
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

    photoInput.addEventListener('change', function(e) {
        const files = e.target.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        selectedFiles = Array.from(files);
        displayPreviews();
    }

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

    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        photoInput.files = dt.files;
    }

    // Fungsi untuk format harga dengan titik pemisah ribuan
    function formatPrice(value) {
        // Hapus semua karakter non-digit
        const numericValue = value.replace(/\D/g, '');
        
        // Format dengan titik sebagai pemisah ribuan
        return numericValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Fungsi untuk hapus format dan dapatkan nilai numerik
    function getNumericValue(value) {
        return value.replace(/\./g, '');
    }

    // Fungsi untuk validasi harga
    function validatePrices() {
        const hargaModal = parseInt(getNumericValue(hargaModalDisplay.value || '0'));
        const hargaJual = parseInt(getNumericValue(hargaJualDisplay.value || '0'));
        
        if (hargaJual > 0 && hargaModal > 0 && hargaJual < hargaModal) {
            return false;
        }
        return true;
    }

    // Fungsi untuk menampilkan peringatan
    function showPriceWarning() {
        // Hapus peringatan yang sudah ada
        const existingWarning = document.getElementById('price-warning');
        if (existingWarning) {
            existingWarning.remove();
        }

        // Buat peringatan baru
        const warning = document.createElement('div');
        warning.id = 'price-warning';
        warning.className = 'alert alert-warning alert-dismissible fade show mt-2';
        warning.innerHTML = `
            <i class="fa fa-exclamation-triangle me-2"></i>
            <strong>Peringatan:</strong> Harga jual tidak boleh lebih rendah dari harga modal!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Tambahkan setelah input harga jual
        hargaJualDisplay.closest('.form-group').appendChild(warning);
        
        // Tambahkan class error ke input
        hargaJualDisplay.classList.add('is-invalid');
    }

    // Fungsi untuk menghapus peringatan
    function removePriceWarning() {
        const warning = document.getElementById('price-warning');
        if (warning) {
            warning.remove();
        }
        hargaJualDisplay.classList.remove('is-invalid');
    }

    // Event listener untuk input harga modal
    const hargaModalDisplay = document.getElementById('harga_modal_display');
    const hargaModalHidden = document.getElementById('harga_modal');
    
    if (hargaModalDisplay && hargaModalHidden) {
        hargaModalDisplay.addEventListener('input', function(e) {
            const formatted = formatPrice(e.target.value);
            e.target.value = formatted;
            hargaModalHidden.value = getNumericValue(formatted);
            
            // Validasi ulang harga jika harga jual sudah diisi
            if (hargaJualDisplay.value) {
                if (validatePrices()) {
                    removePriceWarning();
                } else {
                    showPriceWarning();
                }
            }
        });

        // Set nilai awal jika ada
        if (hargaModalDisplay.value) {
            hargaModalHidden.value = getNumericValue(hargaModalDisplay.value);
        }
    }

    // Event listener untuk input harga jual
    const hargaJualDisplay = document.getElementById('harga_jual_display');
    const hargaJualHidden = document.getElementById('harga_jual');
    
    if (hargaJualDisplay && hargaJualHidden) {
        hargaJualDisplay.addEventListener('input', function(e) {
            const formatted = formatPrice(e.target.value);
            e.target.value = formatted;
            hargaJualHidden.value = getNumericValue(formatted);
            
            // Validasi harga
            if (validatePrices()) {
                removePriceWarning();
            } else {
                showPriceWarning();
            }
        });

        // Set nilai awal jika ada
        if (hargaJualDisplay.value) {
            hargaJualHidden.value = getNumericValue(hargaJualDisplay.value);
        }
    }

    // Validasi saat form akan disubmit
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (!validatePrices()) {
            e.preventDefault();
            showPriceWarning();
            
            // Scroll ke peringatan
            document.getElementById('price-warning').scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            
            return false;
        }
    });

    // Validasi awal saat halaman dimuat
    if (hargaModalDisplay && hargaJualDisplay && hargaModalDisplay.value && hargaJualDisplay.value) {
        if (!validatePrices()) {
            showPriceWarning();
        }
    }
});

// Fungsi untuk menghapus foto yang sudah ada
function removeExistingPhoto(photoPath, index) {
    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
        fetch(`{{ route('kendaraans.remove-photo', $kendaraan->id) }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                photo_path: photoPath
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hapus elemen foto dari tampilan
                const photoElements = document.querySelectorAll('#existing-photos .col-md-3');
                if (photoElements[index]) {
                    photoElements[index].remove();
                }
                
                // Tampilkan pesan sukses
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    ${data.success}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.querySelector('.card-body').insertBefore(alert, document.querySelector('.card-body').firstChild);
                
                // Otomatis hilang setelah 3 detik
                setTimeout(() => {
                    alert.remove();
                }, 3000);
            } else {
                alert('Gagal menghapus foto: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus foto');
        });
    }
}
</script>

@endsection