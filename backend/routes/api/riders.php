<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RiderAuthController;
use App\Http\Controllers\Api\RiderProfileController;
use App\Http\Controllers\Api\RiderResetPasswordController;
use App\Http\Controllers\Api\RiderForgotPasswordController;

// Rider Route
Route::middleware(['assign.guard:riders'])->prefix('rider')->group(function () {
    Route::post('/register', [RiderAuthController::class, 'register']);
    Route::post('/login', [RiderAuthController::class, 'login']);
    Route::post('/refresh', [RiderAuthController::class, 'refresh']);

    // Reset password routes
    Route::post('/forgot-password', [RiderForgotPasswordController::class, 'sendPasswordResetLink']);
    Route::post('/reset-password', [RiderResetPasswordController::class, 'callResetPassword']);

    // Authenticated routes
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/logout', [RiderAuthController::class, 'logout']);

        // Profile routes
        Route::get('/profile', [RiderProfileController::class, 'profile']);
        Route::post('/profile', [RiderProfileController::class, 'updateProfile']);
        Route::post('/address', [RiderProfileController::class, 'updateAddress']);
        Route::post('/profile-photo', [RiderProfileController::class, 'updateProfilePhoto']);
        Route::post('/update-verification', [RiderProfileController::class, 'updateVerification']);
        Route::post('/change-password', [RiderProfileController::class, 'changePassword']);
    });
});