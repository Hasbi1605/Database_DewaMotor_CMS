# Test Manual untuk Fitur Token Admin

## Persiapan

1. Pastikan server Laravel berjalan: `php artisan serve`
2. Akses aplikasi di: http://localhost:8000

## Test Case 1: Registrasi dengan Token Valid

1. **Langkah:**

    - Buka http://localhost:8000/register
    - Isi form registrasi:
        - Nama: "Test Admin"
        - Email: "testadmin@dewamoto.com"
        - Token Admin: "DEWAM0T0R2025"
        - Password: "password123"
        - Konfirmasi Password: "password123"
    - Klik "Daftar"

2. **Expected Result:**
    - Registrasi berhasil
    - Redirect ke dashboard admin
    - Pesan sukses: "Akun admin berhasil dibuat. Selamat datang!"

## Test Case 2: Registrasi dengan Token Invalid

1. **Langkah:**

    - Buka http://localhost:8000/register
    - Isi form registrasi:
        - Nama: "Test Admin 2"
        - Email: "testadmin2@dewamoto.com"
        - Token Admin: "TOKENPALSU123"
        - Password: "password123"
        - Konfirmasi Password: "password123"
    - Klik "Daftar"

2. **Expected Result:**
    - Registrasi gagal
    - Error message: "Token admin tidak valid. Hubungi administrator untuk mendapatkan token yang benar."
    - Form tetap di halaman registrasi
    - Data yang sudah diisi tetap ada (kecuali password dan token)

## Test Case 3: Registrasi tanpa Token

1. **Langkah:**

    - Buka http://localhost:8000/register
    - Isi form registrasi tapi kosongkan field "Token Admin"
    - Klik "Daftar"

2. **Expected Result:**
    - Validasi error: "Token admin wajib diisi"

## Test Case 4: Akses Halaman Token Info (Admin Login)

1. **Langkah:**

    - Login sebagai admin yang sudah terdaftar
    - Di sidebar, klik menu "Token Admin"
    - Atau akses langsung: http://localhost:8000/admin/token-info

2. **Expected Result:**
    - Halaman menampilkan token saat ini: "DEWAM0T0R2025"
    - Ada tombol copy untuk menyalin token
    - Ada panduan penggunaan token

## Test Case 5: Copy Token Function

1. **Langkah:**

    - Di halaman Token Info, klik tombol copy (ikon copy)

2. **Expected Result:**
    - Tombol berubah menjadi checkmark hijau selama 2 detik
    - Token tersalin ke clipboard

## Verifikasi di Log

Cek file log Laravel di `storage/logs/laravel.log` untuk memastikan:

-   Percobaan registrasi tercatat
-   Token invalid dicatat sebagai warning
-   Registrasi berhasil dicatat sebagai info

## Token Default

-   Token yang valid: `DEWAM0T0R2025`
-   Lokasi konfigurasi: file `.env` dengan key `ADMIN_REGISTRATION_TOKEN`

## Troubleshooting

Jika ada masalah:

1. Pastikan file `.env` sudah diupdate dengan token
2. Restart server Laravel jika perlu
3. Cek log di `storage/logs/laravel.log`
4. Pastikan cache config sudah di-clear: `php artisan config:clear`
