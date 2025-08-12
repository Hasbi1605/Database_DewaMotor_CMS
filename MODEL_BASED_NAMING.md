# Format Penamaan File Berdasarkan Model Motor

## 🚗 Update Terbaru: Nama File Sesuai Model Motor

### 📝 Format Nama File Baru

```
{merek}_{model}_{YYYY-MM-DD_HH-mm-ss}_{unique_id}.{extension}
```

**Contoh nama file:**

-   `honda_beat_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg`
-   `yamaha_mio_2025-08-11_16-45-22_64f7a2b3c8d1f.png`
-   `suzuki_nex_ii_2025-08-11_09-15-30_64f7a2b3c8d1g.jpg`

### 🎯 Keuntungan Format Baru:

-   ✅ **Identifikasi Mudah**: Langsung tahu merek dan model dari nama file
-   ✅ **Pengelompokan Otomatis**: File terkelompok berdasarkan merek dan model
-   ✅ **Pencarian Efisien**: Mudah mencari foto berdasarkan merek/model tertentu
-   ✅ **Tetap Unik**: Kombinasi tanggal + unique ID mencegah duplikasi
-   ✅ **Kompatibel**: Format aman untuk semua sistem operasi

### 📂 Contoh Struktur File:

```
storage/app/public/kendaraan/
├── honda_beat_2025-08-11_09-15-30_64f7a2b3c8d1a.jpg
├── honda_beat_2025-08-11_10-22-45_64f7a2b3c8d1b.png
├── honda_vario_125_2025-08-11_11-30-15_64f7a2b3c8d1c.jpg
├── yamaha_mio_2025-08-11_14-45-22_64f7a2b3c8d1d.jpg
├── yamaha_nmax_2025-08-11_15-10-30_64f7a2b3c8d1e.png
├── suzuki_nex_ii_2025-08-11_16-20-45_64f7a2b3c8d1f.jpg
└── kawasaki_ninja_250_2025-08-12_08-00-10_64f7a2b3c8d1g.jpg
```

### 🔧 Komponen Nama File:

1. **Merek**: Nama merek motor (dibersihkan dan lowercase)
2. **Model**: Nama model motor (dibersihkan dan lowercase)
3. **Tanggal**: `YYYY-MM-DD_HH-mm-ss` format upload
4. **Unique ID**: ID unik untuk mencegah collision
5. **Extension**: Ekstensi file asli

### 🧹 Proses Pembersihan Nama:

Sistem otomatis membersihkan nama merek dan model:

-   Mengubah ke huruf kecil
-   Mengganti spasi dengan underscore
-   Menghilangkan karakter khusus
-   Menghilangkan underscore berturut-turut

**Contoh pembersihan:**

-   `"Honda Beat"` → `honda_beat`
-   `"Yamaha MIO S"` → `yamaha_mio_s`
-   `"Suzuki NEX-II"` → `suzuki_nex_ii`
-   `"Kawasaki Ninja 250"` → `kawasaki_ninja_250`

### 🔍 Tips Pencarian File:

1. **Cari berdasarkan merek**: `honda_*`
2. **Cari berdasarkan model**: `*_beat_*`
3. **Cari berdasarkan tanggal**: `*_2025-08-11_*`
4. **Kombinasi**: `honda_beat_2025-08-11_*`

### 🔄 Fallback System:

Jika data merek atau model tidak tersedia, sistem akan menggunakan format fallback:

```
kendaraan_{YYYY-MM-DD_HH-mm-ss}_{unique_id}.{extension}
```

### 📋 Contoh Implementasi:

**Input form:**

-   Merek: "Honda"
-   Model: "Beat Street"
-   Upload time: 2025-08-11 14:30:15

**Hasil nama file:**

```
honda_beat_street_2025-08-11_14-30-15_64f7a2b3c8d1e.jpg
```

### 🚀 Manfaat untuk Manajemen:

1. **Inventory Management**: Mudah mengelompok foto berdasarkan tipe motor
2. **Quick Search**: Pencarian foto lebih cepat dan akurat
3. **File Organization**: Struktur file yang terorganisir secara natural
4. **Backup Strategy**: Backup bisa dilakukan per merek/model
5. **Report Generation**: Mudah membuat laporan berdasarkan jenis motor

---

**Status**: ✅ Format nama file dengan merek dan model telah diterapkan
**Format Aktif**: `{merek}_{model}_{tanggal}_{unique_id}.{extension}`
