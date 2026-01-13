<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KenderaanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\RekodPermohonanController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\LaporanKerosakanController;
use App\Http\Controllers\StatusPerjalananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['authcheck'])->group(function () {
    Route::prefix('admin')->name('admin_site.')->group(function () {
        Route::get('/halaman-utama', [KelulusanController::class, 'halamanUtama'])
            ->name('halaman_utama');

        Route::post('/lulus/{id_permohonan}', [KelulusanController::class, 'lulus'])
            ->name('permohonan.lulus');

        Route::post('/tidak-lulus/{id_permohonan}', [KelulusanController::class, 'tidakLulus'])
            ->name('permohonan.tidak_lulus');

        Route::post('/tidak-lulus-kerosakan/{id_permohonan}', [KelulusanController::class, 'tidakLulusRosak'])
            ->name('permohonan.tidak_lulus_rosak');

        Route::get('/rekod-permohonan', [RekodPermohonanController::class, 'index'])
            ->name('rekod_permohonan');

        Route::get('/senarai-kenderaan', [KenderaanController::class, 'index'])
            ->name('senarai_kenderaan');

        Route::get('/senarai-kenderaan/search', [KenderaanController::class, 'search'])
            ->name('senarai_kenderaan.search');

        Route::get('/tambah-kenderaan', [KenderaanController::class, 'create'])
            ->name('tambah_kenderaan.create');

        Route::post('/tambah-kenderaan', [KenderaanController::class, 'store'])
            ->name('tambah_kenderaan.store');

        Route::get('/tambah-kenderaan/{no_pendaftaran}/edit', [KenderaanController::class, 'edit'])
            ->name('tambah_kenderaan.edit');

        Route::post('/tambah-kenderaan/{no_pendaftaran}/update', [KenderaanController::class, 'update'])
            ->name('tambah_kenderaan.update');

        Route::delete('/senarai-kenderaan/delete', [KenderaanController::class, 'destroy'])
            ->name('senarai_kenderaan.delete');

        Route::get('/kerosakan', [LaporanKerosakanController::class, 'index'])
            ->name('kerosakkan_kenderaan');

        Route::post('/kerosakan/store', [LaporanKerosakanController::class, 'store'])
            ->name('kerosakkan_kenderaan.store');

        Route::post('/kerosakan/selesai/{id}', [LaporanKerosakanController::class, 'selesai'])
            ->name('kerosakkan_kenderaan.selesai');

        Route::get('/senarai-pengguna', [UserController::class, 'index'])
            ->name('senarai_pengguna');

        Route::get('/senarai-pengguna/search', [UserController::class, 'search'])
            ->name('senarai_pengguna.search');

        Route::get('/tambah-pengguna', [UserController::class, 'create'])
            ->name('tambah_pengguna.create');

        Route::post('/tambah-pengguna', [UserController::class, 'store'])
            ->name('tambah_pengguna.store');

        Route::get('/tambah-pengguna/{id}/edit', [UserController::class, 'edit'])
            ->name('tambah_pengguna.edit');

        Route::post('/tambah-pengguna/{id}/update', [UserController::class, 'update'])
            ->name('tambah_pengguna.update');

        Route::delete('/senarai-pengguna/delete', [UserController::class, 'destroy'])
            ->name('senarai_pengguna.delete');
    });

    Route::prefix('user')->name('user_site.')->group(function () {
        Route::get('/halaman_utama', [PermohonanController::class, 'index'])
            ->name('permohonan.index');

        Route::get('/borang/{no_pendaftaran}', [PermohonanController::class, 'borang'])
            ->name('permohonan.borang');

        Route::post('/borang/store', [PermohonanController::class, 'store'])
            ->name('permohonan.store');

        Route::get('/status-permohonan', [PermohonanController::class, 'status'])
            ->name('status_permohonan');

        Route::get('/pemeriksaan/{id_permohonan}', [PermohonanController::class, 'pemeriksaan'])
            ->name('permohonan.pemeriksaan');

        Route::post('/pemeriksaan/simpan', [PermohonanController::class, 'simpanPemeriksaan'])
            ->name('permohonan.simpan_pemeriksaan');

        Route::get('/status-perjalanan', [StatusPerjalananController::class, 'index'])
            ->name('status_perjalanan');

        Route::post('/status-perjalanan/simpan', [StatusPerjalananController::class, 'simpan'])
            ->name('status_perjalanan.simpan');

        Route::get('/rekod-permohonan', [RekodPermohonanController::class, 'index'])
            ->name('rekod_permohonan');
    });

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
});