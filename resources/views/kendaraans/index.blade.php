@extends('layouts.app')

@section('title', 'Kelola Kendaraan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div>
                <h4 class="card-title mb-0">Daftar Kendaraan</h4>
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
            <a href="{{ route('kendaraans.create') }}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus"></i>
                Tambah Kendaraan
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Form Pencarian dan Filter -->
        <form action="{{ route('kendaraans.index') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari (No. Rangka/Mesin/Polisi)" value="{{ request('search') }}">
                </div>
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
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="terjual" {{ request('status') == 'terjual' ? 'selected' : '' }}>Terjual</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text">Harga</span>
                        <input type="number" name="harga_min" class="form-control" placeholder="Min" value="{{ request('harga_min') }}">
                        <input type="number" name="harga_max" class="form-control" placeholder="Max" value="{{ request('harga_max') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                    <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary">
                        <i class="fa fa-refresh"></i> Reset
                    </a>
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
                        <th>Nomor Rangka</th>
                        <th>Nomor Mesin</th>
                        <th>Nomor Polisi</th>
                        <th>Merek</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Harga Modal</th>
                        <th>Harga Jual</th>
                        <th>Status</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kendaraans as $index => $kendaraan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kendaraan->nomor_rangka }}</td>
                        <td>{{ $kendaraan->nomor_mesin }}</td>
                        <td>{{ $kendaraan->nomor_polisi }}</td>
                        <td>{{ $kendaraan->merek }}</td>
                        <td>{{ $kendaraan->model }}</td>
                        <td>{{ $kendaraan->tahun_pembuatan }}</td>
                        <td>Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $kendaraan->status == 'tersedia' ? 'success' : 'secondary' }}">
                                {{ ucfirst($kendaraan->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                                @if($kendaraan->status == 'tersedia')
                                    <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="terjual">
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menandai kendaraan ini sebagai terjual?')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                @endif
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
    </div>
</div>
@endsection