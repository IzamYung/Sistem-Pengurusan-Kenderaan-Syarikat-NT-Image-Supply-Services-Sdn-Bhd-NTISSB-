<?php

use  App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['authcheck'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin_site.dashboard');
    })->name('admin_site.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user_site.dashboard');
    })->name('user_site.dashboard');

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
});