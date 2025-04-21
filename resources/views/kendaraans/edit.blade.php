@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')
    <h1>Edit Kendaraan</h1>

    <form action="{{ route('kendaraans.update', $kendaraan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nomor Rangka:</label>
        <input type="text" name="nomor_rangka" value="{{ $kendaraan->nomor_rangka }}" required>
        <br>

        <label>Nomor Mesin:</label>
        <input type="text" name="nomor_mesin" value="{{ $kendaraan->nomor_mesin }}" required>
        <br>

        <label>Nomor Polisi:</label>
        <input type="text" name="nomor_polisi" value="{{ $kendaraan->nomor_polisi }}" required>
        <br>

        <label>Merek:</label>
        <input type="text" name="merek" value="{{ $kendaraan->merek }}" required>
        <br>

        <label>Model:</label>
        <input type="text" name="model" value="{{ $kendaraan->model }}" required>
        <br>

        <label>Tahun Pembutan:</label>
        <input type="number" name="tahun_pembutan" value="{{ $kendaraan->tahun_pembutan }}" required>
        <br>

        <label>Harga Modal:</label>
        <input type="number" name="harga_modal" value="{{ $kendaraan->harga_modal }}" required>
        <br>

        <label>Harga Jual:</label>
        <input type="number" name="harga_jual" value="{{ $kendaraan->harga_jual }}" required>
        <br>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a href="{{ route('kendaraans.index') }}">Kembali</a>
@endsection