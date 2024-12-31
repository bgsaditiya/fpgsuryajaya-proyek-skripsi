<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AnalisisController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\SesiController;
use Illuminate\Support\Facades\Route;

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



//middleware guest
Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login'])->name('auth');
});


//middleware auth
Route::middleware(['auth'])->group(function () {
    // Route::get('/home', [DataController::class, 'index']);

    Route::controller(DataController::class)->group(function () {
        Route::get('/data', 'index')->name('data');
        Route::get('/data/edit/{id}', 'show');
        Route::put('/data/update/{id}', 'update')->name('data.update');
        Route::get('/data/tambah', 'create')->name('data.tambah');
        Route::post('/data/store', 'store')->name('data.store');
        Route::delete('/data/hapus/{id}', 'destroy')->name('data.destroy');
        Route::get('/data/search', 'search')->name('data.cari');
        Route::get('/data/import', 'view_import')->name('data.view.import');
        Route::post('data-import', 'import')->name('data.import');
    });

    Route::controller(AnalisisController::class)->group(function () {
        Route::get('/analisis', 'index')->middleware('hakAkses:admin')->name('analisis');
        Route::post('/analisis/fpg', 'fpgrowth')->middleware('hakAkses:admin')->name('fpgrowth');
    });

    Route::get('/hasil', function () {
        return view('menu.hasil.index', [
            'title' => 'Hasil',
            'active' => 'hasil',
        ]);
    });

    Route::controller(PengaturanController::class)->group(function () {
        Route::get('/pengaturan', 'index')->name('pengaturan');
        Route::get('/pengaturan/password', 'password')->name('password');
        Route::put('/pengaturan/ganti/password', 'gantiPassword')->name('ganti.password');

        Route::get('/pengaturan/admin', 'admin')->middleware('hakAkses:admin')->name('admin');
        Route::get('/pengaturan/admin/edit/{username}', 'adminEdit')->middleware('hakAkses:admin')->name('admin.edit');
        Route::put('/pengaturan/admin/update/{username}', 'adminUpdate')->middleware('hakAkses:admin')->name('admin.update');
        Route::get('/pengaturan/admin/tambah', 'adminCreate')->middleware('hakAkses:admin')->name('admin.tambah');
        Route::post('/pengaturan/admin/store', 'adminStore')->middleware('hakAkses:admin')->name('admin.store');
        Route::delete('/pengaturan/admin/hapus/{username}', 'adminHapus')->middleware('hakAkses:admin')->name('admin.destroy');
        Route::get('/pengaturan/admin/search', 'adminSearch')->middleware('hakAkses:admin')->name('admin.cari');

        Route::get('/pengaturan/pegawai', 'pegawai')->middleware('hakAkses:admin')->name('pegawai');
        Route::get('/pengaturan/pegawai/tambah', 'pegawaiCreate')->middleware('hakAkses:admin')->name('pegawai.tambah');
        Route::post('/pengaturan/pegawai/store', 'pegawaiStore')->middleware('hakAkses:admin')->name('pegawai.store');
        Route::get('/pengaturan/pegawai/edit/{username}', 'pegawaiEdit')->middleware('hakAkses:admin')->name('pegawai.edit');
        Route::put('/pengaturan/pegawai/update/{username}', 'pegawaiUpdate')->middleware('hakAkses:admin')->name('pegawai.update');
        Route::delete('/pengaturan/pegawai/hapus/{username}', 'pegawaiHapus')->middleware('hakAkses:admin')->name('pegawai.destroy');
    });

    Route::controller(ArsipController::class)->group(function () {
        Route::get('/arsip', 'index')->middleware('hakAkses:admin')->name('arsip');
        Route::get('/arsip/{id_arsip}', 'show')->middleware('hakAkses:admin')->name('arsip.show');
        Route::delete('/arsip/hapus/{id_arsip}', 'destroy')->middleware('hakAkses:admin')->name('arsip.destroy');
    });

    Route::controller(PanduanController::class)->group(function () {
        Route::get('/panduan', 'index')->name('panduan');
        Route::get('/panduan/view', 'view')->name('view');
    });

    Route::get('/logout', [SesiController::class, 'logout'])->name('logout');

    // Route::get('/dashboard/admin', [AdminController::class,'index']);
});