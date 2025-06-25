<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LicenseAdminController;

Route::get('/', function () {
    return view('welcome');
});

// ✅ Dashboard ใช้ controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ✅ กลุ่ม route ที่ล็อกอินแล้วเท่านั้น
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/licenses', [LicenseAdminController::class, 'index'])->name('licenses.index');
    Route::get('/licenses/{license}', [LicenseAdminController::class, 'show'])->name('licenses.show');
    Route::post('/licenses/{license}/deactivate', [LicenseAdminController::class, 'deactivate'])->name('licenses.deactivate');
    Route::delete('/licenses/{license}', [LicenseAdminController::class, 'destroy'])->name('licenses.destroy');
    Route::get('licenses/create', [LicenseAdminController::class, 'create'])->name('licenses.create');
    Route::post('licenses', [LicenseAdminController::class, 'store'])->name('licenses.store');
    Route::resource('licenses', App\Http\Controllers\Admin\LicenseAdminController::class);

});

// ✅ รวม route การล็อกอิน/สมัคร/รีเซ็ตรหัสผ่าน
require __DIR__.'/auth.php';