<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController; // taruh diatas
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokumenKendaraanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AuthController;
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

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Admin Routes (Protected by authentication)
Route::middleware('admin.auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('kendaraans', KendaraanController::class);
    Route::post('/kendaraans/{id}/update-status', [KendaraanController::class, 'updateStatus'])->name('kendaraans.updateStatus');
    Route::resource('dokumen-kendaraans', DokumenKendaraanController::class);
    Route::resource('categories', CategoryController::class);
});
