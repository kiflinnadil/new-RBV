<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BukuController::class, 'beranda']);

Route::get('/koleksi', [BukuController::class, 'index'])->name('books.index');
Route::get('/koleksi/{id}', [BukuController::class, 'show'])->name('books.show');
Route::get('/books/{id}/read', [BukuController::class, 'read'])->name('books.read');
Route::get('/books/{id}/edit', [BukuController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', [BukuController::class, 'update'])->name('books.update');
Route::delete('/books/{id}', [BukuController::class, 'delete'])->name('books.delete');
Route::get('/books/create', [BukuController::class, 'create'])->name('books.create');
Route::post('/books', [BukuController::class, 'store'])->name('books.store');
Route::post('/koleksi/{id}/favorite', [BukuController::class, 'toggleFavorite'])->name('books.favorite');

Route::get('/berita', [BeritaController::class, 'berita']);
Route::get('/berita{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
Route::get('//berita/edit/{id}',[BeritaController::class,'edit'])->name('berita.edit');
Route::put('/berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
Route::delete('/berita/delete/{id}', [BeritaController::class, 'delete'])->name('berita.delete');
Route::post('/berita/store', [BeritaController::class, 'store'])->name('berita.store');

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

Route::get('/favorite', [BukuController::class, 'favorit'])->name('books.favorit');

Route::get('login', function () {
    return view('pages.login');
})->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', function () {
    return view('pages.register');

});
