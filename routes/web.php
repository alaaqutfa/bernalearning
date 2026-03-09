<?php

use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LevelController as AdminLevelController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// تسجيل الدخول
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// مجموعة المسارات المحمية (للمستخدمين العاديين)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/level/{level:slug}', [LevelController::class, 'show'])->name('level.show');
    Route::get('/video/{video}', [VideoController::class, 'show'])->name('video.show');
});

// مجموعة مسارات الإدارة
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('levels', AdminLevelController::class);
    Route::resource('videos', AdminVideoController::class);
    Route::resource('coupons', AdminCouponController::class)->except(['edit', 'update', 'destroy']);
});
