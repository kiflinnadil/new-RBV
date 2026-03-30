<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Api\ArtikelApiController;
use App\Http\Controllers\Api\AkunApiController;


Route::apiResource('books', BukuApiController::class);
Route::apiResource('berita', BeritaApiController::class);
Route::apiResource('video', VideoApiController::class);
Route::apiResource('artikel', ArtikelApiController::class);
Route::apiResource('akun', AkunApiController::class);

