@extends('layouts.app')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<!-- Header Section -->
<div class="card fade-in">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Kelola Kategori</h4>
                <p class="text-muted mb-0">Atur kategori kendaraan berdasarkan kelas, merek, dokumen, dan kondisi</p>
            </div>
            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Kategori
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

<!-- Categories Grid -->
<div class="row g-4">
    <!-- Kategori Kelas -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="fas fa-layer-group me-2"></i>
                    Kelas Kendaraan
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th width="20%">Aksi</th>
                            </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories['class'] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data kelas kendaraan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Kategori Merek -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fa fa-trademark me-2"></i>
                            Merek Kendaraan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories['brand'] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data merek kendaraan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Dokumen -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fa fa-file-alt me-2"></i>
                            Kelengkapan Dokumen
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories['document'] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data dokumen</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kategori Kondisi -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="fa fa-check-circle me-2"></i>
                            Kondisi Kendaraan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories['condition'] as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data kondisi</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
