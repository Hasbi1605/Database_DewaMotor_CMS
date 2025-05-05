@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <a href="#kendaraanTersedia" class="text-decoration-none">
            <div class="card bg-primary text-white hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-motorcycle fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Total Kendaraan</h6>
                            <h3 class="mb-0">{{ $totalKendaraan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="#kendaraanTerjual" class="text-decoration-none">
            <div class="card bg-success text-white hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Kendaraan Terjual</h6>
                            <h3 class="mb-0">{{ $totalTerjual }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="#kendaraanTerjual" class="text-decoration-none">
            <div class="card bg-info text-white hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-white bg-opacity-25 p-3">
                            <i class="fas fa-money-bill fa-2x"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-1">Total Keuntungan</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card" id="kendaraanTersedia">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-motorcycle me-2"></i>
                    Kendaraan Tersedia
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Polisi</th>
                                <th>Nomor Rangka</th>
                                <th>Nomor Mesin</th>
                                <th>Merek</th>
                                <th>Model</th>
                                <th>Tahun</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($kendaraans->where('status', 'tersedia') as $kendaraan)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $kendaraan->nomor_polisi }}</td>
                                <td>{{ $kendaraan->nomor_rangka }}</td>
                                <td>{{ $kendaraan->nomor_mesin }}</td>
                                <td>{{ $kendaraan->merek }}</td>
                                <td>{{ $kendaraan->model }}</td>
                                <td>{{ $kendaraan->tahun_pembuatan }}</td>
                                <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <form action="{{ route('kendaraans.updateStatus', $kendaraan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="terjual">
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin menandai kendaraan ini sebagai terjual?')">
                                                <i class="fa fa-check"></i>
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
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card" id="kendaraanTerjual">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-check me-2"></i>
                    Kendaraan Terjual
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Polisi</th>
                                <th>Merek & Model</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Keuntungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kendaraanTerjual as $index => $kendaraan)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kendaraan->nomor_polisi }}</td>
                                <td>{{ $kendaraan->merek }} {{ $kendaraan->model }}</td>
                                <td>Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($kendaraan->getProfit(), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <td colspan="5" class="text-end fw-bold">Total Keuntungan:</td>
                                <td class="fw-bold">Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
