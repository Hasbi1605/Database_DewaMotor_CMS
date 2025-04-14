<!DOCTYPE html>  
<html>  
<head>  
    <title>Edit Kendaraan</title>  
</head>  
<body>  
    <h1>Edit Kendaraan</h1>  
    <form action="{{ route('kendaraans.update', $kendaraan['id']) }}" method="POST">  
        @csrf  
        @method('PUT')  
        <label>Nomor Rangka:</label><input type="text" name="nomor_rangka" value="{{ $kendaraan['nomor_rangka'] }}"><br>  
        <label>Nomor Mesin:</label><input type="text" name="nomor_mesin" value="{{ $kendaraan['nomor_mesin'] }}"><br>  
        <label>Nomor Polisi:</label><input type="text" name="nomor_polisi" value="{{ $kendaraan['nomor_polisi'] }}"><br>  
        <label>Merek:</label><input type="text" name="merek" value="{{ $kendaraan['merek'] }}"><br>  
        <label>Model:</label><input type="text" name="model" value="{{ $kendaraan['model'] }}"><br>  
        <label>Tahun Pembutan:</label><input type="number" name="tahun_pembutan" value="{{ $kendaraan['tahun_pembutan'] }}"><br>  
        <label>Harga Modal:</label><input type="number" name="harga_modal" value="{{ $kendaraan['harga_modal'] }}"><br>  
        <label>Harga Jual:</label><input type="number" name="harga_jual" value="{{ $kendaraan['harga_jual'] }}"><br>  
        <button type="submit">Update</button>  
    </form>  
</body>  
</html>  