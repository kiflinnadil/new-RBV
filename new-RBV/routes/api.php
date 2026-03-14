<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\VideoApiController;
use App\Http\Controllers\Api\ArtikelApiController;


Route::apiResource('books', BukuApiController::class);
Route::apiResource('berita', BeritaApiController::class);
Route::apiResource('berita', VideoApiController::class);
Route::apiResource('berita', ArtikelApiController::class);
