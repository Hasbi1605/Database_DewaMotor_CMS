@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Tambah Kendaraan Baru</h2>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('kendaraans.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nomor Rangka</label>
                            <input type="text" name="nomor_rangka" class="form-control" value="{{ old('nomor_rangka') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor Mesin</label>
                            <input type="text" name="nomor_mesin" class="form-control" value="{{ old('nomor_mesin') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Nomor Polisi</label>
                            <input type="text" name="nomor_polisi" class="form-control" value="{{ old('nomor_polisi') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" class="form-control" value="{{ old('merek') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Tahun Pembuatan</label>
                            <input type="number" name="tahun_pembuatan" class="form-control" value="{{ old('tahun_pembuatan') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Modal</label>
                            <input type="number" name="harga_modal" class="form-control" value="{{ old('harga_modal') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Jual</label>
                            <input type="number" name="harga_jual" class="form-control" value="{{ old('harga_jual') }}" required>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('kendaraans.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection