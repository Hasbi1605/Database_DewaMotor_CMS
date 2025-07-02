<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController; // taruh diatas
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DokumenKendaraanController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreController;
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

Route::get('/', [HomeController::class, 'index']);
Route::resource('kendaraans', KendaraanController::class);
Route::post('/kendaraans/{id}/update-status', [KendaraanController::class, 'updateStatus'])->name('kendaraans.updateStatus');
Route::resource('dokumen-kendaraans', DokumenKendaraanController::class);
Route::resource('categories', CategoryController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Store Routes for Customers
Route::get('/store', [StoreController::class, 'index'])->name('store.index');
Route::get('/store/{id}', [StoreController::class, 'show'])->name('store.show');
