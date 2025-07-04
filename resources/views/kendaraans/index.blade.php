@extends('layouts.app')

@section('title', 'Kelola Kendaraan')

@section('content')
<!-- Card Container untuk Daftar Kendaraan -->
<div class="card">
    <!-- Header Card dengan Statistik dan Tombol Tambah -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div>
                <h4 class="card-title mb-0">Daftar Kendaraan</h4>
                <!-- Badge Statistik Total Terjual dan Profit -->
                <div class="mt-2">
                    <span class="badge bg-success me-2">
                        <i class="fa fa-check"></i>
                        Total Terjual: {{ $totalTerjual }}
                    </span>
                    <span class="badge bg-info">
                        <i class="fa fa-money-bill"></i>
                        Total Profit: Rp {{ number_format($totalProfit, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <!-- Tombol Tambah Kendaraan -->
            <a href="{{ route('kendaraans.create') }}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                Tambah Kendaraan
            </a>
        </div>
    </div>
    
    <!-- Body Card berisi Form Filter dan Tabel -->
    <div class="card-body">
        <!-- Form Pencarian dan Filter -->
        <form action="{{ route('kendaraans.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <!-- Input Pencarian -->
                <div class="col-md-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari (No. Rangka/Mesin/Polisi)" value="{{ request('search') }}">
                </div>
                
                <!-- Filter Kategori -->
                <div class="col-md-2">
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
                
                <!-- Filter Merek -->
                <div class="col-md-2">
                    <select name="merek" class="form-select">
                        <option value="">Semua Merek</option>
                        @foreach($kendaraans->unique('merek') as $k)
                            <option value="{{ $k->merek }}" {{ request('merek') == $k->merek ? 'selected' : '' }}>
                                {{ $k->merek }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Filter Status -->
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                    </select>
                </div>
                
                <!-- Filter Tahun -->
                <div class="col-md-2">
                    <input type="text" name="tahun" class="form-control" placeholder="Tahun Pembuatan" value="{{ request('tahun') }}">
                </div>
                
                <!-- Tombol Cari dan Reset -->
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="{{ route('kendaraans.index') }}" class="btn btn-danger flex-fill">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Alert Success -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabel Daftar Kendaraan -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Rangka</th>
                        <th>Nomor Mesin</th>
                        <th>Nomor Polisi</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Harga Modal</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kendaraans as $kendaraan)
                    <tr>
                        <!-- Nomor Urut -->
                        <td>{{ $kendaraans->firstItem() + $loop->index }}</td>
                        
                        <!-- Data Identitas Kendaraan -->
                        <td>{{ $kendaraan->nomor_rangka }}</td>
                        <td>{{ $kendaraan->nomor_mesin }}</td>
                        <td>{{ $kendaraan->nomor_polisi }}</td>
                        <td>{{ $kendaraan->merek }}</td>
                        <td>{{ $kendaraan->model }}</td>
                        <td>{{ $kendaraan->tahun_pembuatan }}</td>
                        
                        <!-- Badge Kategori dengan Warna Berdasarkan Tipe -->
                        <td>
                            @foreach($kendaraan->categories as $category)
                                <span class="badge bg-{{ 
                                    $category->type === 'class' ? 'primary' : 
                                    ($category->type === 'brand' ? 'info' : 
                                    ($category->type === 'document' ? 'warning' : 
                                    ($category->type === 'condition' ? 'success' : 'secondary')))
                                }} me-1">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </td>
                        
                        <!-- Foto Kendaraan dengan Counter -->
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
                                <div class="text-muted text-center" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border: 1px dashed #dee2e6; border-radius: 0.375rem;">
                                    <i class="fa fa-image fa-lg"></i>
                                </div>
                            @endif
                        </td>
                        
                        <!-- Harga Modal dan Jual -->
                        <td>Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                        
                        <!-- Status Kendaraan -->
                        <td>
                            <span class="badge bg-{{ $kendaraan->status == 'tersedia' ? 'success' : 'danger' }}">
                                {{ ucfirst($kendaraan->status) }}
                            </span>
                        </td>
                        
                        <!-- Status Kelengkapan Dokumen -->
                        <td>
                            @php
                                $totalDocs = $kendaraan->dokumen->count();
                                $badge = $totalDocs === 0 ? 'danger' : ($totalDocs < 3 ? 'warning' : 'success');
                            @endphp
                            <span class="badge bg-{{ $badge }}">
                                {{ $totalDocs }}/3
                            </span>
                        </td>
                        
                        <!-- Tombol Aksi (Lihat, Edit, Status, Hapus) -->
                        <td>
                            <div class="btn-group" role="group">
                                <!-- Tombol Lihat Detail -->
                                <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                
                                <!-- Tombol Edit -->
                                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                                
                                <!-- Tombol Toggle Status -->
                                @if($kendaraan->status == 'tersedia')
                                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="terjual">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menandai kendaraan ini sebagai terjual?')" title="Tandai sebagai Terjual">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                @elseif($kendaraan->status == 'terjual')
                                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="tersedia">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin mengembalikan status kendaraan ini ke tersedia?')" title="Kembalikan ke Tersedia">
                                            <i class="fa fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- Tombol Hapus -->
                                <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination dan Info -->
        <div class="mt-4 d-flex justify-content-between align-items-center">
            <!-- Info Jumlah Data -->
            <div class="text-muted">
                Menampilkan {{ $kendaraans->firstItem() ?? 0 }} sampai {{ $kendaraans->lastItem() ?? 0 }} dari {{ $kendaraans->total() }} data
            </div>
            
            <!-- Pagination Links -->
            <div>
                {{ $kendaraans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection