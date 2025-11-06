<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['authcheck'])->group(function () {
    // Admin routes
    Route::prefix('admin')->name('admin_site.')->group(function () {
        Route::get('/halaman-utama', function () {
            return view('admin_site.halaman_utama');
        })->name('halaman_utama');

        Route::get('/status-perjalanan', function () {
            return view('admin_site.status_perjalanan');
        })->name('status_perjalanan');

        Route::get('/rekod-permohonan', function () {
            return view('admin_site.rekod_permohonan');
        })->name('rekod_permohonan');

        Route::get('/senarai-kenderaan', function () {
            return view('admin_site.senarai_kenderaan');
        })->name('senarai_kenderaan');

        Route::get('/kerosakan-kenderaan', function () {
            return view('admin_site.kerosakkan_kenderaan');
        })->name('kerosakkan_kenderaan');

        Route::get('/tambah-pengguna', function () {
            return view('admin_site.tambah_pengguna');
        })->name('tambah_pengguna');
    });

    // User routes 
    Route::prefix('user')->name('user_site.')->group(function () {
        Route::get('/halaman-utama', function () {
            return view('user_site.halaman_utama');
        })->name('halaman_utama');

        Route::get('/status-permohonan', function () {
            return view('user_site.status_permohonan');
        })->name('status_permohonan');

        Route::get('/status-perjalanan', function () {
            return view('user_site.status_perjalanan');
        })->name('status_perjalanan');

        Route::get('/rekod-permohonan', function () {
            return view('user_site.rekod_permohonan');
        })->name('rekod_permohonan');
    });

    // Profile controller
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
});
