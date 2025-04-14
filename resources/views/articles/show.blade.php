<!DOCTYPE html>  
<html>  
<head>  
    <title>Detail Kendaraan</title>  
</head>  
<body>  
    <h1>Detail Kendaraan</h1>  
    <p>Nomor Polisi: {{ $kendaraan['nomor_polisi'] }}</p>  
    <p>Nomor Rangka: {{ $kendaraan['nomor_rangka'] }}</p>  
    <p>Merk: {{ $kendaraan['merek'] }}</p>  
    <p>Model: {{ $kendaraan['model'] }}</p>  
    <p>Tahun Pembutan: {{ $kendaraan['tahun_pembutan'] }}</p>  
    <p>Harga Modal: {{ $kendaraan['harga_modal'] }}</p>  
    <p>Harga Jual: {{ $kendaraan['harga_jual'] }}</p>  
    
    <a href="{{ route('kendaraans.index') }}">Kembali</a>  
</body>  
</html>  