<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PromkesController;
use App\Http\Controllers\RepositoriController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BukuController::class, 'beranda']);
Route::get('/koleksi', [BukuController::class, 'index'])->name('books.index');
Route::get('/koleksi/{id}', [BukuController::class, 'show'])->name('books.show');
Route::get('/books/{id}/read', [BukuController::class, 'read'])->name('books.read');
Route::get('/books/read/{id}', [BukuController::class, 'read'])->name('books.read');

Route::get('/login', function () {return view('pages.login');})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profil', function () {return view('pages.profil');});

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');

Route::get('video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/artikel/{id}/read', [ArtikelController::class, 'read'])->name('artikel.read');

Route::post('/books/{id}/favorite', [BukuController::class, 'toggleFavorite'])->name('books.favorite')->middleware('auth');
Route::get('/favorite', [BukuController::class, 'favorit'])->name('books.favorit')->middleware('auth');

Route::get('/promkes', [PromkesController::class, 'index'])->name('promkes.index');
Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');
Route::get('/layanan', function () {return view('pages.Layanan.layanan');})->name('Layanan.index');

Route::middleware(['auth','role:super_admin,admin'])->group(function () {

    Route::get('/books/create', [BukuController::class, 'create'])->name('books.create');
    Route::post('/books', [BukuController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BukuController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BukuController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BukuController::class, 'destroy'])->name('books.delete');

    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('/video', [VideoController::class, 'store'])->name('video.store');
    Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

    Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    Route::get('/panduan/create', [PanduanController::class, 'create'])->name('panduan.create');
    Route::post('/panduan', [PanduanController::class, 'store'])->name('panduan.store');
    Route::get('/panduan/{id}/edit', [PanduanController::class, 'edit'])->name('panduan.edit');
    Route::put('/panduan/{id}', [PanduanController::class, 'update'])->name('panduan.update');
    Route::delete('/panduan/{id}', [PanduanController::class, 'destroy'])->name('panduan.destroy');

    Route::get('/promkes/create', [PromkesController::class, 'create'])->name('promkes.create');
    Route::post('/promkes', [PromkesController::class, 'store'])->name('promkes.store');
    Route::get('/promkes/{id}/edit', [PromkesController::class, 'edit'])->name('promkes.edit');
    Route::put('/promkes/{id}', [PromkesController::class, 'update'])->name('promkes.update');
    Route::delete('/promkes/{id}', [PromkesController::class, 'destroy'])->name('promkes.destroy');

});

Route::middleware(['auth','role:super_admin'])->group(function () {
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/tambah-akun', [AkunController::class, 'create'])->name('akun.create');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');

    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/akun/{id}', [AkunController::class, 'destroy'])->name('akun.destroy');

    Route::get('/repositori/create', [RepositoriController::class, 'create'])->name('repositori.create');
    Route::post('/repositori', [RepositoriController::class, 'store'])->name('repositori.store');
    Route::get('/repositori/{id}/edit', [RepositoriController::class, 'edit'])->name('repositori.edit');
    Route::put('/repositori/{id}', [RepositoriController::class, 'update'])->name('repositori.update');
    Route::delete('/repositori/{id}', [RepositoriController::class, 'destroy'])->name('repositori.destroy');
});

Route::middleware(['auth','role:super_admin,sekretaris'])->group(function () {

    Route::get('/repositori', [RepositoriController::class, 'index'])->name('repositori.index');

});





Route::redirect('/e-office', '/eoffice');

Route::prefix('eoffice')
    ->name('eoffice.')
    ->middleware(['auth'])
    ->group(function () {

        Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {
            Route::get('/', [\App\Http\Controllers\SuratMasukController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\SuratMasukController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\SuratMasukController::class, 'store'])->name('store');
            Route::get('/export/excel', [\App\Http\Controllers\SuratMasukController::class, 'exportExcel'])->name('export');
            Route::get('/{id}', [\App\Http\Controllers\SuratMasukController::class, 'show'])->name('show');
            Route::get('/{id}/pdf', [\App\Http\Controllers\SuratMasukController::class, 'exportPdf'])->name('export-pdf');
            // Approvve
            Route::post('/{id}/setujui', [\App\Http\Controllers\SuratMasukController::class, 'setujui'])->name('setujui');
            Route::post('/{id}/tolak', [\App\Http\Controllers\SuratMasukController::class, 'tolak'])->name('tolak');
        });

        Route::prefix('surat-keluar')->name('surat-keluar.')->group(function () {
            Route::get('/', [\App\Http\Controllers\SuratKeluarController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\SuratKeluarController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\SuratKeluarController::class, 'store'])->name('store');
            Route::get('/export/excel', [\App\Http\Controllers\SuratKeluarController::class, 'exportExcel'])->name('export-all');
            Route::get('/{id}', [\App\Http\Controllers\SuratKeluarController::class, 'show'])->name('show');
            Route::get('/{id}/pdf', [\App\Http\Controllers\SuratKeluarController::class, 'pdf'])->name('pdf');
            // Approve
            Route::post('/{id}/setujui', [\App\Http\Controllers\SuratKeluarController::class, 'setujui'])->name('setujui');
            Route::post('/{id}/tolak', [\App\Http\Controllers\SuratKeluarController::class, 'tolak'])->name('tolak');
        });

        Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
            Route::get('/', [\App\Http\Controllers\NotifikasiController::class, 'index'])->name('index');
            Route::post('/baca-semua', [\App\Http\Controllers\NotifikasiController::class, 'bacaSemua'])->name('baca-semua');
            Route::get('/{id}/baca', [\App\Http\Controllers\NotifikasiController::class, 'baca'])->name('baca');
        });
    });


// Route::prefix('promkes')->name('promkes.')->group(function () {

//     // Akses publik — semua user (termasuk tamu) bisa melihat daftar
//     Route::get('/', [PromkesController::class, 'index'])->name('index');

//     // Hanya admin & super_admin yang bisa tambah/edit/hapus
//     Route::middleware(['auth'])->group(function () {
//         Route::get('/create', [PromkesController::class, 'create'])->name('create');
//         Route::post('/', [PromkesController::class, 'store'])->name('store');
//         Route::get('/{id}/edit', [PromkesController::class, 'edit'])->name('edit');
//         Route::put('/{id}', [PromkesController::class, 'update'])->name('update');
//         Route::delete('/{id}', [PromkesController::class, 'destroy'])->name('destroy');
//     });
// });

// ─── REPOSITORI ─────────────────────────────────────────────────────────────
// Route::prefix('repositori')->name('repositori.')->group(function () {

//     Route::get('/', [RepositoriController::class, 'index'])->name('index');

//     Route::middleware(['auth'])->group(function () {
//         Route::get('/create', [RepositoriController::class, 'create'])->name('create');
//         Route::post('/', [RepositoriController::class, 'store'])->name('store');
//         Route::get('/{id}/edit', [RepositoriController::class, 'edit'])->name('edit');
//         Route::put('/{id}', [RepositoriController::class, 'update'])->name('update');
//         Route::delete('/{id}', [RepositoriController::class, 'destroy'])->name('destroy');
//     });
// });

// // ─── PANDUAN, PEDOMAN & SOP ─────────────────────────────────────────────────
// Route::prefix('panduan')->name('panduan.')->group(function () {

//     Route::get('/', [PanduanController::class, 'index'])->name('index');

//     Route::middleware(['auth'])->group(function () {
//         Route::get('/create', [PanduanController::class, 'create'])->name('create');
//         Route::post('/', [PanduanController::class, 'store'])->name('store');
//         Route::get('/{id}/edit', [PanduanController::class, 'edit'])->name('edit');
//         Route::put('/{id}', [PanduanController::class, 'update'])->name('update');
//         Route::delete('/{id}', [PanduanController::class, 'destroy'])->name('destroy');
//     });
// });
// -------------- //
// Route::get('/', [BukuController::class, 'beranda']);

// Route::get('/koleksi', [BukuController::class, 'index'])->name('books.index');
// Route::get('/koleksi/{id}', [BukuController::class, 'show'])->name('books.show');
// Route::get('/books/{id}/read', [BukuController::class, 'read'])->name('books.read');
// Route::get('/books/{id}/edit', [BukuController::class, 'edit'])->name('books.edit');
// Route::put('/books/{id}', [BukuController::class, 'update'])->name('books.update');
// Route::delete('/books/{id}', [BukuController::class, 'delete'])->name('books.delete');
// Route::get('/books/create', [BukuController::class, 'create'])->name('books.create');
// Route::post('/books', [BukuController::class, 'store'])->name('books.store');
// Route::post('/koleksi/{id}/favorite', [BukuController::class, 'toggleFavorite'])->name('books.favorite');
// Route::get('/favorite', [BukuController::class, 'favorit'])->name('books.favorit');

// Route::get('/berita', [BeritaController::class, 'berita'])->name('berita.index');
// Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
// Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
// Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
// Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
// Route::put('/berita/{id}', [BeritaController::class, 'update'])->name('berita.update');
// // Route::delete('/berita/{id}', [BeritaController::class, 'delete'])->name('berita.delete');
// Route::delete('/berita/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');

// Route::get('/video', [VideoController::class, 'index'])->name('video.index');
// Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
// Route::post('/video', [VideoController::class, 'store'])->name('video.store');
// Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');
// Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
// Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
// Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

// Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
// Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
// Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');
// Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
// Route::put('/artikel/{id}', [ArtikelController::class, 'update'])->name('artikel.update');
// Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy'])->name('artikel.delete');
// Route::post('/artikel', [ArtikelController::class, 'store'])->name('artikel.store');

// Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route::get('register', function () {
//     return view('pages.register');

// });

// Route::get('/profil', [AuthController::class, 'profile'])->name('profil');
// Route::get('/profil', [ProfileController::class, 'index'])->name('profil.index');
// // Route::post('/logout', [ProfileController::class, 'logout'])->name('profile.logout');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
