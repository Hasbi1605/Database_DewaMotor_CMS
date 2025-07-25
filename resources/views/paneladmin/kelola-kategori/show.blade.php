@extends('layouts.app')

@section('content')
<!-- Card Container untuk Detail Kategori -->
<div class="card">
    <!-- Header Card dengan Judul dan Tombol Aksi -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div>
                <h4 class="card-title mb-0">Detail Kategori</h4>
            </div>
            <!-- Tombol Edit dan Kembali -->
            <div class="ms-auto">
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Body Card berisi Detail Kategori -->
    <div class="card-body">
        <div class="row">
            <!-- Kolom untuk Tabel Detail -->
            <div class="col-md-6">
                <!-- Tabel Detail Kategori -->
                <table class="table table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $category->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama:</strong></td>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tipe:</strong></td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($category->type) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi:</strong></td>
                        <td>{{ $category->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Form Hapus Kategori -->
        <div class="mt-3">
            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" 
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
