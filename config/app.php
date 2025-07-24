<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Nama Aplikasi
    |--------------------------------------------------------------------------
    |
    | Nilai ini adalah nama aplikasi Anda. Nilai ini digunakan ketika
    | framework perlu menempatkan nama aplikasi dalam notifikasi atau
    | lokasi lain yang diperlukan oleh aplikasi atau paket-paketnya.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Lingkungan Aplikasi
    |--------------------------------------------------------------------------
    |
    | Nilai ini menentukan "lingkungan" aplikasi Anda saat ini
    | berjalan. Ini dapat menentukan bagaimana Anda lebih suka mengkonfigurasi
    | berbagai layanan yang digunakan aplikasi. Atur ini di file ".env" Anda.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Mode Debug Aplikasi
    |--------------------------------------------------------------------------
    |
    | Ketika aplikasi Anda dalam mode debug, pesan error terperinci dengan
    | stack trace akan ditampilkan pada setiap error yang terjadi dalam
    | aplikasi Anda. Jika dinonaktifkan, halaman error generik sederhana ditampilkan.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL Aplikasi
    |--------------------------------------------------------------------------
    |
    | URL ini digunakan oleh konsol untuk menghasilkan URL dengan benar saat
    | menggunakan alat command line Artisan. Anda harus mengatur ini ke root
    | aplikasi Anda sehingga digunakan saat menjalankan tugas Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Zona Waktu Aplikasi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan zona waktu default untuk aplikasi Anda, yang
    | akan digunakan oleh fungsi tanggal dan waktu PHP. Kami telah melangkah
    | lebih jauh dan mengatur ini ke default yang masuk akal untuk Anda.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Lokal Aplikasi
    |--------------------------------------------------------------------------
    |
    | Lokal aplikasi menentukan lokal default yang akan digunakan
    | oleh penyedia layanan terjemahan. Anda bebas mengatur nilai ini
    | ke salah satu lokal yang akan didukung oleh aplikasi.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Lokal Fallback Aplikasi
    |--------------------------------------------------------------------------
    |
    | Lokal fallback menentukan lokal yang akan digunakan ketika yang saat ini
    | tidak tersedia. Anda dapat mengubah nilai ini agar sesuai dengan salah satu
    | folder bahasa yang disediakan melalui aplikasi Anda.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Lokal Faker
    |--------------------------------------------------------------------------
    |
    | Lokal ini akan digunakan oleh pustaka Faker PHP saat menghasilkan data
    | palsu untuk seed database Anda. Sebagai contoh, ini akan digunakan untuk
    | mendapatkan nomor telepon, informasi alamat jalan, dan lainnya yang terlokalisasi.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Kunci Enkripsi
    |--------------------------------------------------------------------------
    |
    | Kunci ini digunakan oleh layanan enkripsi Illuminate dan harus diatur
    | ke string acak 32 karakter, jika tidak string terenkripsi ini
    | tidak akan aman. Silakan lakukan ini sebelum menyebarkan aplikasi!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Driver Mode Maintenance
    |--------------------------------------------------------------------------
    |
    | Opsi konfigurasi ini menentukan driver yang digunakan untuk menentukan dan
    | mengelola status "mode maintenance" Laravel. Driver "cache" akan
    | memungkinkan mode maintenance dikontrol di beberapa mesin.
    |
    | Driver yang didukung: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Penyedia Layanan Yang Dimuat Otomatis
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Token Registrasi Admin
    |--------------------------------------------------------------------------
    |
    | Token khusus yang diperlukan untuk registrasi admin. Token ini harus
    | diketahui oleh administrator untuk dapat membuat akun admin baru.
    |
    */

    'admin_registration_token' => env('ADMIN_REGISTRATION_TOKEN', 'DEWAM0T0R2025'),

];
