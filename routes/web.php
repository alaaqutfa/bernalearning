<?php

use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\LevelController as AdminLevelController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\TrackViewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== مسارات المصادقة ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==================== مسارات المستخدمين العاديين (محمية) ====================
Route::middleware('auth')->group(function () {
    // الصفحة الرئيسية بعد تسجيل الدخول
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // عرض المستوى والفيديو
    Route::get('/level/{level:slug}/{video?}', [LevelController::class, 'show'])->name('level.show');

    // تتبع المشاهدات
    Route::post('/track/view', [TrackViewController::class, 'store'])->name('track.view');
});

// ==================== مسارات الإدارة (محمية + شرط admin) ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // لوحة التحكم الرئيسية
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // إدارة المستويات
    Route::resource('levels', AdminLevelController::class);

    // إدارة الفيديوهات
    Route::resource('videos', AdminVideoController::class);

    // إدارة الكوبونات (بدون edit, update, destroy)
    Route::resource('coupons', AdminCouponController::class)->except(['edit', 'update', 'destroy']);

    // إدارة المستخدمين
    Route::resource('users', AdminUserController::class)->only(['index', 'create', 'store', 'show']);

    // مسارات إضافية للمستخدمين
    Route::prefix('users/{user}')->name('users.')->group(function () {
        Route::get('/add-coupon', [AdminUserController::class, 'addCouponForm'])->name('add-coupon');
        Route::post('/coupons', [AdminUserController::class, 'storeCoupon'])->name('store-coupon');
    });

    // تحديث حالة الكوبون (تعطيل)
    Route::patch('/coupons/{coupon}/deactivate', [AdminUserController::class, 'deactivateCoupon'])->name('users.deactivate-coupon');

    // ========== التقارير المالية ==========
    Route::prefix('financial')->name('financial.')->group(function () {
        // الصفحة الرئيسية للتقرير الشهري
        Route::get('/', [FinancialReportController::class, 'index'])->name('index');

        // التقرير السنوي
        Route::get('/yearly/{year}', [FinancialReportController::class, 'yearlyReport'])->name('yearly');

        // إدارة المصاريف
        Route::post('/expenses', [FinancialReportController::class, 'storeExpense'])->name('expenses.store');
        Route::put('/expenses/{expense}', [FinancialReportController::class, 'updateExpense'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [FinancialReportController::class, 'destroyExpense'])->name('expenses.destroy');
    });
});
