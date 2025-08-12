# Format Penamaan File Gambar

## 🔄 Update Terbaru: Nama File dengan Tanggal Upload

### 📅 Format Nama File Saat Ini

```
kendaraan_{YYYY-MM-DD_HH-mm-ss}_{unique_id}.{extension}
```

**Contoh nama file:**

-   `kendaraan_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg`
-   `kendaraan_2025-08-11_16-45-22_64f7a2b3c8d1f.png`

### 🎯 Keuntungan Format Ini:

-   ✅ **Mudah diurutkan**: File akan terurut berdasarkan tanggal upload
-   ✅ **Mudah dicari**: Dapat mencari file berdasarkan tanggal tertentu
-   ✅ **Informatif**: Langsung tahu kapan file diupload
-   ✅ **Unik**: Kombinasi tanggal + unique ID mencegah duplikasi
-   ✅ **Kompatibel**: Format nama file aman untuk semua sistem operasi

### 📝 Komponen Nama File:

1. **Prefix**: `kendaraan_` - Identifikasi jenis file
2. **Tanggal**: `YYYY-MM-DD` - Tahun-Bulan-Hari
3. **Waktu**: `HH-mm-ss` - Jam-Menit-Detik (format 24 jam)
4. **Unique ID**: `{uniqid()}` - ID unik untuk mencegah collision
5. **Extension**: `{extension}` - Ekstensi file asli (jpg, png, etc.)

## 🔧 Opsi Format Alternatif

Jika Anda ingin menggunakan format yang berbeda, berikut beberapa opsi:

### Opsi 1: Format Pendek (Tanggal Saja)

```php
$uploadDate = date('Y-m-d'); // Format: 2025-08-11
$photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
```

Hasil: `kendaraan_2025-08-11_64f7a2b3c8d1e.jpg`

### Opsi 2: Format dengan Timestamp Unix

```php
$timestamp = time();
$uploadDate = date('Y-m-d', $timestamp);
$photoName = "kendaraan_{$uploadDate}_{$timestamp}.{$extension}";
```

Hasil: `kendaraan_2025-08-11_1691757015.jpg`

### Opsi 3: Format Indonesia

```php
$uploadDate = date('d-m-Y_H-i-s'); // Format: 11-08-2025_14-30-15
$photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
```

Hasil: `kendaraan_11-08-2025_14-30-15_64f7a2b3c8d1e.jpg`

### Opsi 4: Format Kompakt

```php
$uploadDate = date('YmdHis'); // Format: 20250811143015
$photoName = "kendaraan_{$uploadDate}_{$uniqueId}.{$extension}";
```

Hasil: `kendaraan_20250811143015_64f7a2b3c8d1e.jpg`

## 📂 Contoh Struktur Direktori

```
storage/app/public/kendaraan/
├── kendaraan_2025-08-11_09-15-30_64f7a2b3c8d1a.jpg
├── kendaraan_2025-08-11_10-22-45_64f7a2b3c8d1b.png
├── kendaraan_2025-08-11_14-30-15_64f7a2b3c8d1c.jpg
├── kendaraan_2025-08-11_16-45-22_64f7a2b3c8d1d.gif
└── kendaraan_2025-08-12_08-00-10_64f7a2b3c8d1e.jpg
```

## 🔍 Tips Penggunaan:

1. **Pencarian berdasarkan tanggal**: Gunakan pattern `kendaraan_2025-08-11*` untuk mencari semua file yang diupload pada 11 Agustus 2025
2. **Sorting otomatis**: File akan terurut secara kronologis di file explorer
3. **Backup per tanggal**: Mudah untuk backup file berdasarkan tanggal tertentu

---

**Status**: ✅ Format nama file dengan tanggal upload telah diterapkan
**Format Aktif**: `kendaraan_{YYYY-MM-DD_HH-mm-ss}_{unique_id}.{extension}`
