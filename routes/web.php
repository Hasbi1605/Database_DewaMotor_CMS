<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\HomeController;
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
// Route untuk artikel
Route::resource('kendaraans', KendaraanController::class);
Route::post('/kendaraans/{id}/update-status', [KendaraanController::class, 'updateStatus'])->name('kendaraans.updateStatus');

Route::get('/home', function () {
    return view('home');
})->name('home');
