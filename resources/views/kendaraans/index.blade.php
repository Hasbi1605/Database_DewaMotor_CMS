<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kendaraan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Data Kendaraan</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('kendaraans.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nomor Polisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kendaraans as $kendaraan)
                <tr>
                    <td>{{ $kendaraan->nomor_polisi }}</td>
                    <td>
                        <a href="{{ route('kendaraans.show', $kendaraan->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('kendaraans.edit', $kendaraan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('kendaraans.destroy', $kendaraan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>