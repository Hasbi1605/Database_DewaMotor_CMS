@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Stats Card -->
    <div class="row mb-4">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Kendaraan</p>
                                <h4 class="card-title">{{ $totalKendaraan }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Polisi</th> 
                                    <th>Merek</th>
                                    <th>Model</th>
                                    <th>Tahun</th>
                                    <th>Harga Modal</th>
                                    <th>Harga Jual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kendaraans as $index => $kendaraan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $kendaraan->nomor_polisi }}</td>
                                    <td>{{ $kendaraan->merek }}</td>
                                    <td>{{ $kendaraan->model }}</td>
                                    <td>{{ $kendaraan->tahun_pembuatan }}</td>
                                    <td>Rp {{ number_format($kendaraan->harga_modal, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($kendaraan->harga_jual, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
