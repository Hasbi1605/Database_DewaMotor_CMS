# Fitur Keamanan Token Admin - Dewa Motor CMS

## Deskripsi

Fitur ini menambahkan lapisan keamanan tambahan pada sistem registrasi admin. Hanya pengguna yang memiliki token admin yang valid yang dapat membuat akun admin baru.

## Cara Kerja

### 1. Token Admin

-   Token disimpan dalam file `.env` dengan key `ADMIN_REGISTRATION_TOKEN`
-   Token default: `DEWAM0T0R2025`
-   Token dapat diubah sesuai kebutuhan

### 2. Proses Registrasi

1. Calon admin mengakses halaman registrasi `/register`
2. Mengisi form registrasi lengkap termasuk field "Token Admin"
3. Sistem memvalidasi token yang dimasukkan
4. Registrasi hanya berhasil jika token valid

### 3. Validasi Token

-   Token divalidasi di `AuthController@register`
-   Jika token tidak valid, registrasi ditolak dengan pesan error
-   Log keamanan dicatat untuk setiap percobaan registrasi

## Konfigurasi

### File .env

```env
# Token khusus untuk registrasi admin
ADMIN_REGISTRATION_TOKEN=DEWAM0T0R2025
```

### File config/app.php

```php
'admin_registration_token' => env('ADMIN_REGISTRATION_TOKEN', 'DEWAM0T0R2025'),
```

## Fitur Tambahan

### Halaman Informasi Token

-   URL: `/admin/token-info`
-   Hanya dapat diakses oleh admin yang sudah login
-   Menampilkan token saat ini
-   Fitur copy token dengan satu klik
-   **Generate token baru otomatis (Fitur Baru)**
-   Panduan penggunaan dan tips keamanan

### Generate Token Baru (Fitur Baru)

-   Tombol "Generate Token Baru" di halaman token info
-   Format token otomatis: `DEWA[8karakter][tahun]` (contoh: DEWAABC12XYZ2025)
-   Konfirmasi sebelum generate untuk mencegah kesalahan
-   Update otomatis file `.env`
-   Clear config cache otomatis
-   Logging aktivitas generate token
-   Feedback visual saat proses generate

### Menu Admin

-   Menu "Token Admin" ditambahkan di sidebar admin
-   Akses cepat ke informasi dan generate token

## Keamanan

### Tips Keamanan Token

1. **Ganti token secara berkala**
2. **Gunakan kombinasi yang kompleks** (huruf, angka, simbol)
3. **Jangan bagikan melalui media tidak aman** (email, chat)
4. **Dokumentasikan pemberian token**
5. **Revoke akses jika diperlukan**

### Logging

-   Semua percobaan registrasi dicatat dalam log
-   Token yang tidak valid dicatat sebagai warning
-   Registrasi berhasil dicatat sebagai info

## Cara Mengganti Token

### Method 1: Generate Otomatis (Direkomendasikan)

1. Login sebagai admin
2. Akses menu "Token Admin" di sidebar
3. Klik tombol "Generate Token Baru"
4. Konfirmasi generate token baru
5. Token baru akan otomatis tersimpan dan aktif

### Method 2: Edit .env Manual

```bash
# Edit file .env
ADMIN_REGISTRATION_TOKEN=TOKEN_BARU_ANDA

# Restart aplikasi jika menggunakan cache config
php artisan config:cache
```

### Method 3: Environment Variable

```bash
export ADMIN_REGISTRATION_TOKEN=TOKEN_BARU_ANDA
```

## Testing

### Test Token Valid

1. Akses `/register`
2. Isi form dengan token yang benar
3. Registrasi harus berhasil

### Test Token Invalid

1. Akses `/register`
2. Isi form dengan token yang salah
3. Harus muncul error "Token admin tidak valid"

## Error Messages

### Token Tidak Diisi

```
Token admin wajib diisi
```

### Token Tidak Valid

```
Token admin tidak valid. Hubungi administrator untuk mendapatkan token yang benar.
```

## File yang Dimodifikasi

1. `app/Http/Controllers/AuthController.php` - Validasi token
2. `resources/views/auth/register.blade.php` - Form token
3. `routes/web.php` - Route untuk halaman token info
4. `app/Http/Controllers/AdminTokenController.php` - Controller baru
5. `resources/views/admin/token-info.blade.php` - Halaman info token
6. `resources/views/layouts/app.blade.php` - Menu admin
7. `.env` - Konfigurasi token
8. `config/app.php` - Konfigurasi aplikasi

## Backup dan Recovery

### Jika Lupa Token

1. Cek file `.env` untuk melihat token saat ini
2. Atau login sebagai admin dan akses `/admin/token-info`
3. Jika tidak ada akses, edit langsung di `.env`

### Emergency Access

Jika diperlukan akses darurat, sementara nonaktifkan validasi token di `AuthController@register`:

```php
// Comment baris validasi token
// if ($request->admin_token !== $validToken) { ... }
```

**Penting:** Jangan lupa mengaktifkan kembali validasi setelah akses darurat!
