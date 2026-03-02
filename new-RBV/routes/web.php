<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BukuController::class, 'beranda']);

Route::get('/koleksi', [BukuController::class, 'index'])->name('books.index');
Route::get('/koleksi/{id}', [BukuController::class, 'show'])->name('books.show');
Route::get('/books/{id}/read', [BukuController::class, 'read'])->name('books.read');

Route::get('/berita', [BeritaController::class, 'berita']);
Route::get('/berita{id}', [BeritaController::class, 'show'])->name('berita.show');

Route::get('video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');

Route::get('/artikel', function () {
    return view('pages.Artikel.artikel');
});

Route::get('/video', function () {
    return view('pages.Video.video');
});

Route::get('video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');

Route::get('login', function () {
    return view('pages.login');
});
Route::get('register', function () {
    return view('pages.register');

});
