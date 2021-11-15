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
    // Kelola Pengguna
    Route::middleware('can:kelola surat')->group(function () {
        Route::resource('suratmasuk', SuratmasukController::class);
        Route::get('suratmasuk/file/hapus/{id}', 'SuratmasukController@hapus_file')->name('suratmasuk.hapus_file');
    });
});
