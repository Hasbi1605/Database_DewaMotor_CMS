@extends('layouts.app')

@section('title', 'Token Admin')
@section('page-title', 'Token Admin')

@section('content')
<!-- Header Section -->
<div class="card fade-in">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">
                    <i class="fas fa-key me-2"></i>
                    Token Registrasi Admin
                </h4>
                <p class="text-muted mb-0">Kelola token untuk registrasi admin baru</p>
            </div>
            <a href="/" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Security Alert -->
<div class="alert alert-warning">
    <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
        <div>
            <h6 class="mb-1">Penting untuk Keamanan!</h6>
            <p class="mb-0">Token ini bersifat rahasia dan hanya boleh dibagikan kepada orang yang berwenang untuk menjadi admin.</p>
        </div>
    </div>
</div>

<!-- Current Token Section -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-shield-alt me-2"></i>
            Token Aktif
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-lg-8">
                <label class="form-label fw-semibold">Token Admin Saat Ini</label>
                <div class="input-group">
                    <input type="text" 
                           class="form-control font-monospace" 
                           value="{{ config('app.admin_registration_token') }}" 
                           id="adminToken" 
                           readonly>
                    <button class="btn btn-outline-primary" 
                            type="button" 
                            onclick="copyToken()"
                            title="Copy Token">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                <small class="text-muted">Token ini digunakan untuk registrasi admin baru</small>
            </div>
                    </div>
                    <small class="form-text text-muted">Klik tombol copy untuk menyalin token</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Status Token</label>
                    <div class="input-group">
                        <span class="form-control bg-success text-white">
                            <i class="fas fa-check me-2"></i>
                            Aktif
                        </span>
                    </div>
                    <small class="form-text text-muted">Token sedang aktif dan dapat digunakan</small>
                </div>
            </div>
            <div class="col-12 mt-3">
                <div class="d-flex gap-2">
                            <button class="btn btn-warning" 
                                    type="button" 
                                    onclick="generateNewToken()"
                                    id="generateTokenBtn">
                                <i class="fas fa-dice me-2"></i>
                                Generate Token Baru
                            </button>
                            <button class="btn btn-info" 
                                    type="button" 
                                    onclick="refreshPage()"
                                    id="refreshPageBtn"
                                    style="display: none;">
                                <i class="fas fa-sync-alt me-2"></i>
                                Refresh Halaman
                            </button>
                        </div>
                  
                        <small class="form-text text-warning d-block">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Perhatian:</strong> Generate token baru akan membuat token lama tidak valid
                        </small>
            </div>
        </div>
        
        <!-- Section 2: Panduan Penggunaan -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Cara Penggunaan Token
                </h5>
            </div>
            <div class="col-md-12">
                <div class="card bg-light border-info">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="fas fa-list-ol me-2"></i>
                            Langkah-langkah Registrasi Admin:
                        </h6>
                        <ol class="mb-0">
                            <li class="mb-2">Bagikan token ini kepada calon admin yang berwenang</li>
                            <li class="mb-2">Instruksikan mereka untuk mengakses halaman registrasi: <code>/register</code></li>
                            <li class="mb-2">Token harus dimasukkan di field "Token Admin" pada form registrasi</li>
                            <li class="mb-0">Registrasi hanya akan berhasil dengan token yang benar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
       
        <!-- Section 5: Tips Keamanan -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="mb-3">
                    <i class="fas fa-shield-alt me-2"></i>
                    Tips Keamanan
                </h5>
            </div>
            <div class="col-md-12">
                <div class="alert alert-info border-info">
                    <h6 class="alert-heading">
                        <i class="fas fa-lightbulb me-2"></i>
                        Rekomendasi Keamanan:
                    </h6>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="mb-2">
                                <li>Generate token baru secara berkala</li>
                                <li>Token otomatis menggunakan format aman</li>
                                <li>Dokumentasikan pemberian token</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="mb-2">
                                <li>Hindari sharing melalui media tidak aman</li>
                                <li>Generate ulang jika token bocor</li>
                                <li>Monitor log aktivitas registrasi</li>
                            </ul>
                        </div>
                    </div>
                    <hr class="my-2">
                    <small class="mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Selalu prioritaskan keamanan dalam pengelolaan token admin.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToken() {
    const tokenInput = document.getElementById('adminToken');
    tokenInput.select();
    tokenInput.setSelectionRange(0, 99999); // For mobile devices
    
    navigator.clipboard.writeText(tokenInput.value).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');
        
        setTimeout(function() {
            button.innerHTML = originalContent;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
        
        // Show temporary success message
        const tokenGroup = tokenInput.closest('.input-group');
        const successMsg = document.createElement('small');
        successMsg.className = 'form-text text-success';
        successMsg.innerHTML = '<i class="fas fa-check me-1"></i>Token berhasil disalin!';
        
        // Remove existing small text temporarily
        const existingSmall = tokenGroup.parentElement.querySelector('.text-muted');
        if (existingSmall) {
            existingSmall.style.display = 'none';
            tokenGroup.parentElement.appendChild(successMsg);
            
            setTimeout(function() {
                successMsg.remove();
                existingSmall.style.display = 'block';
            }, 2000);
        }
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        alert('Gagal menyalin token. Silakan copy manual.');
    });
}

function generateNewToken() {
    if (!confirm('Apakah Anda yakin ingin generate token baru?\n\nPerhatian: Token lama akan menjadi tidak valid dan semua yang menggunakan token lama tidak akan bisa registrasi.')) {
        return;
    }
    
    const generateBtn = document.getElementById('generateTokenBtn');
    const refreshBtn = document.getElementById('refreshPageBtn');
    const tokenInput = document.getElementById('adminToken');
    
    // Disable button dan show loading
    generateBtn.disabled = true;
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';
    
    // CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                     document.querySelector('input[name="_token"]')?.value;
    
    fetch('{{ route("admin.generate-token") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update token di input
            tokenInput.value = data.new_token;
            
            // Show success message
            generateBtn.innerHTML = '<i class="fas fa-check me-2"></i>Token Baru Berhasil!';
            generateBtn.classList.remove('btn-warning');
            generateBtn.classList.add('btn-success');
            
            // Show refresh button
            refreshBtn.style.display = 'inline-block';
            
            // Show alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success alert-dismissible fade show mt-3';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> ${data.message}
                <br><small>Token baru: <code>${data.new_token}</code></small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insert alert after the warning alert
            const warningAlert = document.querySelector('.alert-warning');
            warningAlert.parentNode.insertBefore(alertDiv, warningAlert.nextSibling);
            
            // Auto hide success message after 5 seconds
            setTimeout(function() {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
            
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Show error message
        generateBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Gagal Generate';
        generateBtn.classList.remove('btn-warning');
        generateBtn.classList.add('btn-danger');
        
        alert('Gagal generate token baru: ' + error.message);
        
        // Reset button after 3 seconds
        setTimeout(function() {
            generateBtn.disabled = false;
            generateBtn.innerHTML = '<i class="fas fa-dice me-2"></i>Generate Token Baru';
            generateBtn.classList.remove('btn-danger');
            generateBtn.classList.add('btn-warning');
        }, 3000);
    });
}

function refreshPage() {
    window.location.reload();
}
</script>
@endsection
