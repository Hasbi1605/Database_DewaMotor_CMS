<!DOCTYPE html>  
<html>  
<head>  
    <title>Detail Kendaraan</title>  
</head>  
<body>  
    <h1>Detail Kendaraan</h1>  
    
    <p><strong>Nomor Rangka:</strong> {{ $kendaraan['nomor_rangka'] }}</p>  
    <p><strong>Nomor Mesin:</strong> {{ $kendaraan['nomor_mesin'] }}</p>  
    <p><strong>Nomor Polisi:</strong> {{ $kendaraan['nomor_polisi'] }}</p>  
    <p><strong>Merek:</strong> {{ $kendaraan['merek'] }}</p>  
    <p><strong>Model:</strong> {{ $kendaraan['model'] }}</p>  
    <p><strong>Tahun Pembutan:</strong> {{ $kendaraan['tahun_pembutan'] }}</p>  
    <p><strong>Harga Modal:</strong> Rp. {{ number_format($kendaraan['harga_modal'], 2, ',', '.') }}</p>  
    <p><strong>Harga Jual:</strong> Rp. {{ number_format($kendaraan['harga_jual'], 2, ',', '.') }}</p>  
    
    <a href="{{ route('kendaraans.index') }}">Kembali</a>  
</body>  
</html>  