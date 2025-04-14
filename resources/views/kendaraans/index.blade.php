<!DOCTYPE html>  
<html>  
<head>  
    <title>Daftar Kendaraan</title>  
</head>  
<body>  
    <h1>Daftar Kendaraan</h1>  

    @if(session('success'))  
        <div style="color: green;">  
            {{ session('success') }}  
        </div>  
    @endif  

    <a href="{{ route('kendaraans.create') }}">Tambah Kendaraan</a>  
    <ul>  
        @foreach($kendaraans as $kendaraan)  
            <li>  
                {{ $kendaraan->nomor_polisi }} -   
                <a href="{{ route('kendaraans.show', $kendaraan->id) }}">Detail</a>  
            </li>  
        @endforeach  
    </ul>  
</body>  
</html>  