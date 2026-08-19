<?php

use Illuminate\Support\Facades\Route;

// Public Routes - redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Guest routes (login, register) are handled by Breeze
// Add admin login route
Route::middleware('guest')->group(function () {
    Route::get('/loginadmin', \App\Livewire\AdminLogin::class)->name('login.admin');
});

// User Routes (auth + verified)
Route::middleware(['auth'])->group(function () {
    // Pilih Bahasa (no language check needed here)
    Route::get('/pilih-bahasa', \App\Livewire\PilihBahasa::class)->name('pilih-bahasa');
    Route::get('/profil', \App\Livewire\Profil::class)->name('profil');

    // Routes that require language to be selected
    Route::middleware(['language.check'])->group(function () {
        Route::get('/beranda', \App\Livewire\Beranda::class)->name('beranda');
        Route::redirect('/dashboard', '/beranda')->name('dashboard');
        Route::get('/pelajaran/{materiId}', \App\Livewire\Pelajaran::class)->name('pelajaran');
        Route::get('/latihan', \App\Livewire\Latihan::class)->name('latihan');
        Route::get('/kuis', \App\Livewire\Kuis::class)->name('kuis');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/materi', \App\Livewire\Admin\MateriIndex::class)->name('admin.materi');
    Route::get('/materi/{id}', \App\Livewire\Admin\MateriDetail::class)->name('admin.materi.detail');
    Route::get('/kuis', \App\Livewire\Admin\KuisIndex::class)->name('admin.kuis');
    Route::get('/users', \App\Livewire\Admin\UsersIndex::class)->name('admin.users');
    Route::get('/pengunjung', \App\Livewire\Admin\PengunjungIndex::class)->name('admin.pengunjung');
    Route::get('/sound-effects', \App\Livewire\Admin\SoundEffects::class)->name('admin.sound-effects');
});

require __DIR__.'/auth.php';
