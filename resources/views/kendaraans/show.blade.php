@extends('layouts.app')

@section('title', 'Detail Kendaraan')

@section('content')
<div class="card shadow">
    <div class="card-header bg-white py-3">
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Detail Kendaraan</h4>
            <div class="ms-auto">
                <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-info btn-sm me-2">
                    <i class="fa fa-edit me-2"></i>
                    Edit
                </a>
                <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left me-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-id-card me-2"></i>
                            Informasi Identitas Kendaraan
                        </h5>

                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted fw-bold" width="40%">
                                    <i class="fa fa-fingerprint text-primary me-2"></i>
                                    Nomor Rangka
                                </td>
                                <td>{{ $kendaraan->nomor_rangka }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold">
                                    <i class="fa fa-cog text-primary me-2"></i>
                                    Nomor Mesin
                                </td>
                                <td>{{ $kendaraan->nomor_mesin }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold">
                                    <i class="fa fa-car text-primary me-2"></i>
                                    Nomor Polisi
                                </td>
                                <td>{{ $kendaraan->nomor_polisi }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-info-circle me-2"></i>
                            Detail Kendaraan
                        </h5>

                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted fw-bold" width="40%">
                                    <i class="fa fa-trademark text-primary me-2"></i>
                                    Merek
                                </td>
                                <td>{{ $kendaraan->merek }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold">
                                    <i class="fa fa-motorcycle text-primary me-2"></i>
                                    Model
                                </td>
                                <td>{{ $kendaraan->model }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-bold">
                                    <i class="fa fa-calendar text-primary me-2"></i>
                                    Tahun Pembuatan
                                </td>
                                <td>{{ $kendaraan->tahun_pembuatan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="fa fa-money-bill me-2"></i>
                            Informasi Harga
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 bg-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                                <i class="fa fa-tag text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-muted mb-1">Harga Modal</h6>
                                                <h4 class="mb-0">Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 bg-white">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                                <i class="fa fa-money-bill text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-muted mb-1">Harga Jual</h6>
                                                <h4 class="mb-0">Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash me-2"></i>
                    Hapus Kendaraan
                </button>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.card {
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.table td {
    padding: 0.75rem 0;
}
.card-header {
    border-bottom: 1px solid rgba(0,0,0,.125);
}
</style>
@endpush
@endsection