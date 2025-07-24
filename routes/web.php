<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokumenKendaraanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminTokenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Store Routes for Customers (Public)
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{id}', [StoreController::class, 'show'])->name('store.show');

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Rute Admin (Dilindungi oleh autentikasi)
Route::middleware('admin.auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('kendaraans', KendaraanController::class);
    Route::post('/kendaraans/{id}/update-status', [KendaraanController::class, 'updateStatus'])->name('kendaraans.updateStatus');
    Route::post('/kendaraans/{id}/remove-photo', [KendaraanController::class, 'removePhoto'])->name('kendaraans.remove-photo');
    Route::resource('dokumen-kendaraans', DokumenKendaraanController::class);
    Route::post('/dokumen-kendaraans/{id}/remove-file', [DokumenKendaraanController::class, 'removeFile'])->name('dokumen-kendaraans.remove-file');
    Route::resource('categories', CategoryController::class);

    // Halaman informasi token admin
    Route::get('/admin/token-info', [AdminTokenController::class, 'showTokenInfo'])->name('admin.token-info');
    Route::post('/admin/generate-token', [AdminTokenController::class, 'generateNewToken'])->name('admin.generate-token');
});
