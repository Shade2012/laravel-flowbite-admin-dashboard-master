<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login/google', [AuthController::class, 'loginGoogle']);
Route::post('/send-otp', [OTPController::class, 'sendOtp'])->name('sendOtp');
Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
Route::get('/send-notification-auto', [NotificationController::class, 'sendNotificationScheduler']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::post('/register_fcm', [AuthController::class, 'postFCMToken']);

    Route::group(["prefix" => "/user"], function () {
        Route::get('/detail', [AuthController::class, 'show']);
        Route::post('/update', [AuthController::class, 'update']);
    });

    Route::get('/notification', [NotificationController::class, 'getUserNotifications']);
    
    Route::get('/kelas', [JadwalController::class, 'getKelas']);
    
    Route::group(["prefix" => "/pelajaran"], function () {
        Route::get('/guru', [JadwalController::class, 'getGuruMataPelajaran']);
        Route::get('/siswa', [JadwalController::class, 'getMataPelajaran']);
    });

    Route::group(["prefix" => "/jadwal"], function () {
        Route::get('/filter', [JadwalController::class, 'getFilteredJadwal']);
        Route::get('/siswa', [JadwalController::class, 'getSiswaJadwal']);
        Route::get('/detail/{id}', [JadwalController::class, 'show']);
    });
});
