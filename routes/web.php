<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth
Route::get('/', 'AuthController@formlogin')->name('auth.index');

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/home', 'HomeController@index')->name('home');
    // Profile
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    // Kelola Pengguna
    Route::middleware('can:kelola pengguna')->group(function () {
        Route::resource('pengguna', PenggunaController::class);
    });
    // Kelola Surat
    Route::middleware('can:kelola surat')->group(function () {
        // Surat Masuk
        Route::resource('suratmasuk', SuratmasukController::class);
        Route::get('suratmasuk/file/hapus/{id}', 'SuratmasukController@hapus_file')->name('suratmasuk.hapus_file');
        // Surat Masuk
        Route::resource('suratkeluar', SuratkeluarController::class);
        Route::get('suratkeluar/file/hapus/{id}', 'SuratkeluarController@hapus_file')->name('suratkeluar.hapus_file');
        // Surat Cuti Tahunan
        Route::resource('cutitahunan', CutitahunanController::class);
        Route::get('cutitahunan/file/hapus/{id}', 'CutitahunanController@hapus_file')->name('cutitahunan.hapus_file');
        // Surat Cuti Melahirkan
        Route::resource('cutimelahirkan', CutimelahirkanController::class);
        Route::get('cutimelahirkan/file/hapus/{id}', 'CutimelahirkanController@hapus_file')->name('cutimelahirkan.hapus_file');
        // Surat Cuti Alasan Penting
        Route::resource('cutialasanpenting', CutialasanpentingController::class);
        Route::get('cutialasanpenting/file/hapus/{id}', 'CutialasanpentingController@hapus_file')->name('cutialasanpenting.hapus_file');
        // Surat Menduduki Jabatan
        Route::resource('mendudukijabatan', MendudukijabatanController::class);
        Route::get('mendudukijabatan/file/hapus/{id}', 'MendudukijabatanController@hapus_file')->name('mendudukijabatan.hapus_file');
        // Surat Mutasi
        Route::resource('mutasi', MutasiController::class);
        Route::get('mutasi/file/hapus/{id}', 'MutasiController@hapus_file')->name('mutasi.hapus_file');
    });
});
