<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Profile\OwnerProfileController;
use App\Http\Controllers\Profile\RenterProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // ── Public routes ────────────────────────────────────────────────────────
    Route::prefix('auth/{type}')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);
    });

    // ── Protected routes (butuh token) ───────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Logout
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Owner Profile
        Route::prefix('owner')->group(function () {
            Route::get('profile',     [OwnerProfileController::class, 'show']);
            Route::post('profile/kyc', [OwnerProfileController::class, 'kyc']);
        });

        // Renter Profile
        Route::prefix('renter')->group(function () {
            Route::get('profile',     [RenterProfileController::class, 'show']);
            Route::post('profile/kyc', [RenterProfileController::class, 'kyc']);
        });

    });

});
