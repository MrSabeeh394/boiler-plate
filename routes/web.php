<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OTPController;
use Illuminate\Support\Facades\Route;

Route::post('/otp/send', [OTPController::class, 'sendOtp'])->name('otp.send');
Route::post('/otp/verify', [OTPController::class, 'verifyOtp'])->name('otp.verify');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // MFA Settings
    Route::get('/mfa/settings', [\App\Http\Controllers\Auth\MfaController::class, 'settings'])->name('mfa.settings');
    Route::post('/mfa/settings', [\App\Http\Controllers\Auth\MfaController::class, 'updateSettings'])->name('mfa.settings.update');

    // Impersonation
    Route::post('/impersonate/{user}', [\App\Http\Controllers\Admin\ImpersonationController::class, 'impersonate'])
        ->name('impersonate')
        ->middleware('portal.permission:admin,impersonate-users');

    Route::get('/impersonate/leave', [\App\Http\Controllers\Admin\ImpersonationController::class, 'leave'])
        ->name('impersonate.leave');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/logs', [\App\Http\Controllers\Admin\LogViewerController::class, 'index'])
            ->name('logs')
            ->middleware('portal.permission:admin,view-logs');

        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->middleware('portal.permission:admin,manage-users');
        Route::post('users/{id}/restore', [\App\Http\Controllers\Admin\UserController::class, 'restore'])
            ->name('users.restore')
            ->middleware('portal.permission:admin,manage-users');
    });
});

require __DIR__.'/auth.php';
