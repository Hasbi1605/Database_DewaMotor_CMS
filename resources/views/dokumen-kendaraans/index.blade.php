@extends('layouts.app')

@section('title', 'Dokumen Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Daftar Dokumen Kendaraan</h4>
            <a href="{{ route('dokumen-kendaraans.create') }}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                Tambah Dokumen
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Pencarian -->
        <form action="{{ route('dokumen-kendaraans.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="kendaraan_id" class="form-select">
                        <option value="">Semua Kendaraan</option>
                        @foreach($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}" {{ request('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                {{ $kendaraan->merek }} {{ $kendaraan->model }} - {{ $kendaraan->nomor_polisi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nomor dokumen" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <div class="d-grid gap-2 d-md-flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-search"></i> Cari
                        </button>
                        <a href="{{ route('dokumen-kendaraans.index') }}" class="btn btn-secondary">
                            <i class="fa fa-refresh"></i> Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kendaraan</th>
                        <th>Dokumen</th>
                        <th>Detail Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedDokumen = $dokumenKendaraans->groupBy('kendaraan_id');
                    @endphp
                    
                    @forelse($groupedDokumen as $kendaraanId => $dokumenGroup)
                    <tr>
                        <td>{{ ($kendaraans_page->currentPage() - 1) * $kendaraans_page->perPage() + $loop->iteration }}</td>
                        <td>
                            {{ $dokumenGroup->first()->kendaraan->merek }} 
                            {{ $dokumenGroup->first()->kendaraan->model }}
                            <br>
                            <small class="text-muted">{{ $dokumenGroup->first()->kendaraan->nomor_polisi }}</small>
                            <br>
                            <span class="badge {{ $dokumenGroup->first()->kendaraan->status === 'tersedia' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($dokumenGroup->first()->kendaraan->status) }}
                            </span>
                        </td>
                        <td>
                            <select class="form-select form-select-sm dokumen-selector" 
                                    data-row="{{ $loop->index }}"
                                    style="width: 120px;">
                                <option value="">Pilih Dokumen</option>
                                @foreach($dokumenGroup as $dokumen)
                                    <option value="{{ $dokumen->id }}">{{ $dokumen->jenis_dokumen }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            @foreach($dokumenGroup as $dokumen)
                            <div class="dokumen-detail-{{ $loop->parent->index }} dokumen-info" 
                                 data-dokumen-id="{{ $dokumen->id }}" 
                                 style="display: none;">
                                <strong>Nomor:</strong> {{ $dokumen->nomor_dokumen }}<br>
                                <strong>Terbit:</strong> {{ $dokumen->tanggal_terbit->format('d/m/Y') }}<br>
                                <strong>Expired:</strong> {{ $dokumen->tanggal_expired ? $dokumen->tanggal_expired->format('d/m/Y') : '-' }}<br>
                                @if($dokumen->file_path)
                                    <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank" class="btn btn-sm btn-info mt-1">
                                        <i class="fa fa-file"></i> Lihat File
                                    </a>
                                @endif
                            </div>
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('dokumen-kendaraans.edit', $dokumenGroup->first()->id) }}" 
                                   class="btn btn-sm btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form action="{{ route('dokumen-kendaraans.destroy', $dokumenGroup->first()->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data dokumen</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Menampilkan {{ $kendaraans_page->firstItem() }} 
                sampai {{ $kendaraans_page->lastItem() }}
                dari {{ $kendaraans_page->total() }} kendaraan
            </div>
            <div>
                {{ $kendaraans_page->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectors = document.querySelectorAll('.dokumen-selector');
    selectors.forEach(selector => {
        selector.addEventListener('change', function() {
            const row = this.dataset.row;
            const selectedId = this.value;
            
            // Hide all dokumen info in this row
            document.querySelectorAll(`.dokumen-detail-${row}`).forEach(el => {
                el.style.display = 'none';
            });
            
            // Show selected dokumen info
            if (selectedId) {
                document.querySelector(`.dokumen-detail-${row}[data-dokumen-id="${selectedId}"]`).style.display = 'block';
            }
        });
    });
});
</script>
@endpush

@endsection
