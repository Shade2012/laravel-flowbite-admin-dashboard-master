<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PelajaranController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;

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

Route::get('/', [AdminAuthController::class, 'login'])->name('sign-in');
Route::post('/sign-in-add', [AdminAuthController::class, 'loginStore'])->name('sign-in-add');

// Authentication
Route::group(["prefix" => "authentication"], function () {
    Route::get('/sign-up', [AdminAuthController::class, 'register'])->name('sign-up');
    Route::post('/sign-up-add', [AdminAuthController::class, 'registerStore'])->name('sign-up-add');

    Route::get('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password-add', [AdminAuthController::class, 'forgotPasswordStore'])->name('forgot-password-add');

    Route::get('/verify-code', [AdminAuthController::class, 'verifyCode'])->name('verify-code');
    Route::post('/verify-code-add', [AdminAuthController::class, 'verifyCodeStore'])->name('verify-code-add');
    Route::post('/resend-otp', [AdminAuthController::class, 'resendOtp'])->name('resend-otp');

    Route::get('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('reset-password');
    Route::post('/reset-password-add', [AdminAuthController::class, 'resetPasswordStore'])->name('reset-password-add');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Dashboard
Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('index');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/update', [AdminController::class, 'update'])->name('update');
    Route::put('/photoProfile', [AdminController::class, 'updateImage'])->name('photoProfile');
    Route::put('/change-password', [AdminController::class, 'changePassword'])->name('change-password');

    // Manajemen User
    Route::group(["prefix" => "/user"], function () {
        Route::get('all', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/detail/{id}', [UserController::class, 'show'])->name('admin.user.detail');
        Route::get('create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('add', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::delete('destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });

    // Manajemen Kelas
    Route::group(["prefix" => "/kelas"], function () {
        Route::get('all', [KelasController::class, 'index'])->name('admin.kelas.index');
        Route::get('/detail/{kelas}', [KelasController::class, 'show'])->name('admin.kelas.detail');
        Route::get('create', [KelasController::class, 'create'])->name('admin.kelas.create');
        Route::post('add', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::get('edit/{kelas}', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('update/{kelas}', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('delete/{kelas}', [KelasController::class, 'delete'])->name('admin.kelas.delete');
        Route::delete('delete/{kelas}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
    });


    // Manajemen Pelajaran
    Route::group(["prefix" => "/pelajaran"], function () {
        Route::get('all', [PelajaranController::class, 'index'])->name('admin.pelajaran.index');
        Route::get('/detail/{pelajaran}', [PelajaranController::class, 'show'])->name('admin.pelajaran.detail');
        Route::get('create', [PelajaranController::class, 'create'])->name('admin.pelajaran.create');
        Route::post('add', [PelajaranController::class, 'store'])->name('admin.pelajaran.store');
        Route::get('edit/{pelajaran}', [PelajaranController::class, 'edit'])->name('admin.pelajaran.edit');
        Route::put('update/{pelajaran}', [PelajaranController::class, 'update'])->name('admin.pelajaran.update');
        Route::delete('delete/{pelajaran}', [PelajaranController::class, 'delete'])->name('admin.pelajaran.delete');
        Route::delete('delete/{pelajaran}', [PelajaranController::class, 'destroy'])->name('admin.pelajaran.destroy');
    });

    // Manajemen Ruang
    Route::group(["prefix" => "/ruang"], function () {
        Route::get('all', [RuangController::class, 'index'])->name('admin.ruang.index');
        Route::get('/detail/{ruang}', [RuangController::class, 'show'])->name('admin.ruang.detail');
        Route::get('create', [RuangController::class, 'create'])->name('admin.ruang.create');
        Route::post('add', [RuangController::class, 'store'])->name('admin.ruang.store');
        Route::get('edit/{ruang}', [RuangController::class, 'edit'])->name('admin.ruang.edit');
        Route::put('update/{ruang}', [RuangController::class, 'update'])->name('admin.ruang.update');
        Route::delete('delete/{ruang}', [RuangController::class, 'delete'])->name('admin.ruang.delete');
        Route::delete('delete/{ruang}', [RuangController::class, 'destroy'])->name('admin.ruang.destroy');
    });

    // Manajemen Guru
    Route::group(["prefix" => "/guru"], function () {
        Route::get('all', [GuruController::class, 'index'])->name('admin.guru.index');
        Route::get('/detail/{id}', [GuruController::class, 'show'])->name('admin.guru.detail');
        Route::get('create', [GuruController::class, 'create'])->name('admin.guru.create');
        Route::post('add', [GuruController::class, 'store'])->name('admin.guru.store');
        Route::get('edit/{id}', [GuruController::class, 'edit'])->name('admin.guru.edit');
        Route::put('update/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
        Route::delete('delete/{id}', [GuruController::class, 'delete'])->name('admin.guru.delete');
        Route::delete('destroy/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
    });

    // Manajemen Siswa
    Route::group(["prefix" => "/siswa"], function () {
        Route::get('all', [SiswaController::class, 'index'])->name('admin.siswa.index');
        Route::get('/detail/{id}', [SiswaController::class, 'show'])->name('admin.siswa.detail');
        Route::get('create', [SiswaController::class, 'create'])->name('admin.siswa.create');
        Route::post('add', [SiswaController::class, 'store'])->name('admin.siswa.store');
        Route::get('edit/{id}', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
        Route::put('update/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
        Route::delete('delete/{id}', [SiswaController::class, 'delete'])->name('admin.siswa.delete');
        Route::delete('destroy/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    });

    // Manajemen Jadwal Pelajaran
    Route::group(["prefix" => "/jadwal-pelajaran"], function () {
        Route::get('all', [JadwalPelajaranController::class, 'index'])->name('admin.jadwal_pelajaran.index');
        Route::get('/detail/{id}', [JadwalPelajaranController::class, 'show'])->name('admin.jadwal_pelajaran.detail');
        Route::get('create', [JadwalPelajaranController::class, 'create'])->name('admin.jadwal_pelajaran.create');
        Route::post('add', [JadwalPelajaranController::class, 'store'])->name('admin.jadwal_pelajaran.store');
        Route::get('edit/{id}', [JadwalPelajaranController::class, 'edit'])->name('admin.jadwal_pelajaran.edit');
        Route::put('update/{id}', [JadwalPelajaranController::class, 'update'])->name('admin.jadwal_pelajaran.update');
        Route::delete('delete/{id}', [JadwalPelajaranController::class, 'delete'])->name('admin.jadwal_pelajaran.delete');
        Route::delete('destroy/{id}', [JadwalPelajaranController::class, 'destroy'])->name('admin.jadwal_pelajaran.destroy');
    });
});

// Pages
Route::get('pages/maintenance/', [PagesController::class, 'maintenance'])->name('pages.maintenance');

Route::get('pages/404/', [PagesController::class, 'pageNotFound'])->name('pages.404');

Route::get('pages/500/', [PagesController::class, 'serverError'])->name('pages.500');
