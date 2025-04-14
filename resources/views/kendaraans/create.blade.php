<!DOCTYPE html>  
<html>  
<head>  
    <title>Tambah Kendaraan</title>  
</head>  
<body>  
    <h1>Tambah Kendaraan</h1>  

    <form action="{{ route('kendaraans.store') }}" method="POST">  
        @csrf  
        <label>Nomor Rangka:</label>  
        <input type="text" name="nomor_rangka" required>  
        <br>  

        <label>Nomor Mesin:</label>  
        <input type="text" name="nomor_mesin" required>  
        <br>  

        <label>Nomor Polisi:</label>  
        <input type="text" name="nomor_polisi" required>  
        <br>  

        <label>Merek:</label>  
        <input type="text" name="merek" required>  
        <br>  

        <label>Model:</label>  
        <input type="text" name="model" required>  
        <br>  

        <label>Tahun Pembutan:</label>  
        <input type="number" name="tahun_pembutan" required>  
        <br>  

        <label>Harga Modal:</label>  
        <input type="number" name="harga_modal" required>  
        <br>  

        <label>Harga Jual:</label>  
        <input type="number" name="harga_jual" required>  
        <br>  

        <button type="submit">Simpan</button>  
    </form>  

    <a href="{{ route('kendaraans.index') }}">Kembali</a>  
</body>  
</html>  