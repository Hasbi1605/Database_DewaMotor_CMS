<!DOCTYPE html>
<html>
<head>
<title>Upload Gambar</title>
</head>
<body>
<h2>Form Upload Gambar</h2>
@if (session('success'))
<p style="color: green;">{{ session('success') }}</p>
@endif

@if (session('deleted'))
<p style="color: red;">{{ session('deleted') }}</p>
@endif
<!-- Form Upload -->
<form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
@csrf
<label>Judul:</label><br>
<input type="text" name="title"><br><br>
<label>Pilih Gambar:</label><br>
<input type="file" name="image"><br><br>
<button type="submit">Upload</button>
</form>

<!-- Preview Gambar -->
@if (isset($image))
<h3>Gambar yang baru diupload:</h3>
<p><strong>{{ $image->title }}</strong></p>
<img src="{{ asset('storage/' . $image->image_path) }}" width="200">
<form action="{{ route('image.delete', $image->id) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">
        Hapus Gambar
    </button>
</form>
@endif
</body>
</html>