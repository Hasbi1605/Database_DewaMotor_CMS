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
Route::get('/articles', [ArticleController::class, 'index']);  
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::resource('kendaraans', KendaraanController::class);