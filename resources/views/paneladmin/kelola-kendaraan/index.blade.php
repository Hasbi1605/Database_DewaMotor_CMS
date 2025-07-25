@extends('layouts.app')

@section('title', 'Kelola Kendaraan')
@section('page-title', 'Kelola Kendaraan')

@section('content')
<!-- Header Section -->
<div class="card fade-in">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-2">Daftar Kendaraan</h4>
                <div class="d-flex gap-2">
                    <span class="badge bg-success">
                        <i class="fas fa-check me-1"></i>
                        Total Terjual: {{ $totalTerjual }}
                    </span>
                    <span class="badge bg-info">
                        <i class="fas fa-coins me-1"></i>
                        Total Profit: Rp {{ number_format($totalProfit, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <a href="{{ route('kendaraans.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Kendaraan
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Filter and Search Section -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('kendaraans.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-search me-1"></i>
                    Pencarian
                </label>
                <input type="text" name="search" class="form-control" 
                       placeholder="No. Rangka/Mesin/Polisi" 
                       value="{{ request('search') }}">
            </div>
            
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-tags me-1"></i>
                    Kategori
                </label>
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories->groupBy('type') as $type => $typeCategories)
                        <optgroup label="{{ ucfirst($type) }}">
                            @foreach($typeCategories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-motorcycle me-1"></i>
                    Merek
                </label>
                <select name="merek" class="form-select">
                    <option value="">Semua Merek</option>
                    @foreach($kendaraans->unique('merek') as $k)
                        <option value="{{ $k->merek }}" {{ request('merek') == $k->merek ? 'selected' : '' }}>
                            {{ $k->merek }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-info-circle me-1"></i>
                    Status
                </label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar me-1"></i>
                    Tahun
                </label>
                <input type="text" name="tahun" class="form-control" 
                       placeholder="Tahun Pembuatan" 
                       value="{{ request('tahun') }}">
            </div>
            
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Data Table Section -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Identitas Kendaraan</th>
                        <th>Detail</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kendaraans as $kendaraan)
                    <tr>
                        <td>{{ $kendaraans->firstItem() + $loop->index }}</td>
                        
                        <!-- Identitas Kendaraan -->
                        <td>
                            <div class="fw-semibold">{{ $kendaraan->merek }} {{ $kendaraan->model }}</div>
                            <small class="text-muted">{{ $kendaraan->nomor_polisi }}</small><br>
                            <small class="text-muted">Rangka: {{ $kendaraan->nomor_rangka }}</small><br>
                            <small class="text-muted">Mesin: {{ $kendaraan->nomor_mesin }}</small>
                        </td>
                        
                        <!-- Detail -->
                        <td>
                            <div class="text-muted">
                                <small>Tahun: {{ $kendaraan->tahun_pembuatan }}</small><br>
                                @if($kendaraan->cc)
                                    <small>CC: {{ $kendaraan->cc }}</small><br>
                                @endif
                                @if($kendaraan->warna)
                                    <small>Warna: {{ $kendaraan->warna }}</small>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Kategori -->
                        <td>
                            @foreach($kendaraan->categories->take(2) as $category)
                                <span class="badge bg-{{ 
                                    $category->type === 'class' ? 'primary' : 
                                    ($category->type === 'brand' ? 'info' : 
                                    ($category->type === 'document' ? 'warning' : 
                                    ($category->type === 'condition' ? 'success' : 'secondary')))
                                }} me-1 mb-1">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                            @if($kendaraan->categories->count() > 2)
                                <span class="badge bg-secondary">+{{ $kendaraan->categories->count() - 2 }}</span>
                            @endif
                        </td>
                        
                        <!-- Foto -->
                        <td>
                            @if($kendaraan->photos && count($kendaraan->photos) > 0)
                                <div class="position-relative">
                                    <img src="{{ asset('storage/' . $kendaraan->photos[0]) }}" 
                                         alt="Foto {{ $kendaraan->merek }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                    @if(count($kendaraan->photos) > 1)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                                            {{ count($kendaraan->photos) }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="text-muted text-center d-flex align-items-center justify-content-center border rounded" style="width: 60px; height: 60px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        
                        <!-- Harga -->
                        <td>
                            <div class="fw-semibold text-success">Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</div>
                            <small class="text-muted">Modal: Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</small>
                            @if($kendaraan->harga_jual > $kendaraan->harga_modal)
                                <br><small class="text-info">Profit: Rp {{ number_format($kendaraan->harga_jual - $kendaraan->harga_modal, 0, ',', '.') }}</small>
                            @endif
                        </td>
                        
                        <!-- Status -->
                        <td>
                            <span class="badge bg-{{ $kendaraan->status == 'tersedia' ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $kendaraan->status == 'tersedia' ? 'check' : 'times' }} me-1"></i>
                                {{ ucfirst($kendaraan->status) }}
                            </span>
                        </td>
                        
                        <!-- Dokumen -->
                        <td>
                            @php
                                $totalDocs = $kendaraan->dokumen->count();
                                $badge = $totalDocs === 0 ? 'danger' : ($totalDocs < 3 ? 'warning' : 'success');
                                $icon = $totalDocs === 0 ? 'times' : ($totalDocs < 3 ? 'exclamation' : 'check');
                            @endphp
                            <span class="badge bg-{{ $badge }}">
                                <i class="fas fa-{{ $icon }} me-1"></i>
                                {{ $totalDocs }}/3
                            </span>
                        </td>
                        
                        <!-- Aksi -->
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('kendaraans.show', $kendaraan->id) }}" 
                                   class="btn btn-outline-primary" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" 
                                   class="btn btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($kendaraan->status == 'tersedia')
                                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="terjual">
                                        <button type="submit" class="btn btn-outline-success" 
                                                onclick="return confirm('Tandai sebagai terjual?')" 
                                                title="Tandai Terjual">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="tersedia">
                                        <button type="submit" class="btn btn-outline-warning" 
                                                onclick="return confirm('Kembalikan ke tersedia?')" 
                                                title="Kembalikan">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Yakin ingin menghapus?')" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($kendaraans->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $kendaraans->firstItem() ?? 0 }} sampai {{ $kendaraans->lastItem() ?? 0 }} dari {{ $kendaraans->total() }} data
                </div>
                <div>
                    {{ $kendaraans->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection