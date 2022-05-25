<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\RefundRequestController;
use App\Http\Controllers\Api\CustomerProfileController;
use App\Http\Controllers\Api\CustomerResetPasswordController;
use App\Http\Controllers\Api\CustomerForgotPasswordController;
use App\Http\Controllers\Api\ReviewController;

// Customer Route
Route::middleware(['assign.guard:customers'])->prefix('customer')->group(function () {
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::post('/refresh', [CustomerAuthController::class, 'refresh']);

    // Reset password routes
    Route::post('/forgot-password', [CustomerForgotPasswordController::class, 'sendPasswordResetLink']);
    Route::post('/reset-password', [CustomerResetPasswordController::class, 'callResetPassword']);

    // Authenticated routes
    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::post('/logout', [CustomerAuthController::class, 'logout']);

        // Profile routes
        Route::get('/profile', [CustomerProfileController::class, 'profile']);
        Route::post('/profile', [CustomerProfileController::class, 'updateProfile']);
        Route::post('/address', [CustomerProfileController::class, 'updateAddress']);
        Route::post('/profile-photo', [CustomerProfileController::class, 'updateProfilePhoto']);
        Route::post('/change-password', [CustomerProfileController::class, 'changePassword']);

        // Wallet routes
        Route::get('/wallet/transactions', [WalletController::class, 'transaction']);
        Route::post('/wallet/add-money', [WalletController::class, 'addMoney']);
        //   Refund routes
        Route::apiResource('refund-requests', RefundRequestController::class);

        Route::post('favourites/{product}/toggle', [FavouriteController::class, 'toggle']);
        Route::get('favourites', [FavouriteController::class, 'favourite']);
    });
});