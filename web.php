<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticController;
use App\Http\Controllers\MapController;
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

Route::get('/',[StaticController::class, 'index']);

Route::get('/upload', [MapController::class, 'showUploadForm'])->name('uploadForm');
Route::post('/upload', [MapController::class, 'upload'])->name('upload');
Route::get('/map', [MapController::class, 'displayMap'])->name('map');
