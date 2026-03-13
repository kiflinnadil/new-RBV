<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuApiController;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\VideoApiController;


/*
|--------------------------------------------------------------------------
| API BUKU
|--------------------------------------------------------------------------
*/

Route::apiResource('books', BukuApiController::class);

/*
|--------------------------------------------------------------------------
| API BERITA
|--------------------------------------------------------------------------
*/

Route::apiResource('berita', BeritaApiController::class);

Route::apiResource('berita', VideoApiController::class);