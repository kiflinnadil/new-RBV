<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Api\ArtikelApiController;
use App\Http\Controllers\Api\AkunApiController;
use App\Http\Controllers\Api\PanduanApiController;
use App\Http\Controllers\Api\PromkesApiController;
use App\Http\Controllers\Api\RepositoriApiController;
use App\Http\Controllers\Api\AuthController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('books', BukuApiController::class);
    Route::apiResource('berita', BeritaApiController::class);
    Route::apiResource('video', VideoApiController::class);
    Route::apiResource('artikel', ArtikelApiController::class);
    Route::apiResource('akun', AkunApiController::class);
    Route::apiResource('panduan', PanduanApiController::class);
    Route::apiResource('promkes', PromkesApiController::class);
    Route::apiResource('repositori', RepositoriApiController::class);

});