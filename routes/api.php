<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Profile\OwnerProfileController;
use App\Http\Controllers\Profile\RenterProfileController;
use App\Http\Controllers\Review\ReviewController;
use App\Http\Controllers\Search\SearchVehicleController;
use App\Http\Controllers\Vehicle\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // ── Public routes ────────────────────────────────────────────────────────
    Route::prefix('auth/{type}')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login',    [AuthController::class, 'login']);
    });

    // ── Public vehicle routes (tidak butuh token) ─────────────────────────
     Route::prefix('renter/vehicles')->group(function () {
        Route::get('search', [SearchVehicleController::class, 'search']);
        Route::get('{id}',   [SearchVehicleController::class, 'show']);
    });

    // ── Protected routes (butuh token) ───────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

        // Logout
        Route::post('auth/logout', [AuthController::class, 'logout']);

        // Owner Profile
        Route::prefix('owner')->group(function () {
            Route::get('profile',     [OwnerProfileController::class, 'show']);
            Route::post('profile/kyc', [OwnerProfileController::class, 'kyc']);

            Route::get('vehicles',          [VehicleController::class, 'index']);
            Route::post('vehicles',         [VehicleController::class, 'store']);
            Route::patch('vehicles/{id}',   [VehicleController::class, 'update']);
            Route::delete('vehicles/{id}',  [VehicleController::class, 'destroy']);

            Route::get('bookings',                    [BookingController::class, 'ownerIndex']);
            Route::patch('bookings/{id}/status',      [BookingController::class, 'updateStatus']);
        });

        // Renter Profile
        Route::prefix('renter')->group(function () {

            // Get
            Route::get('profile',     [RenterProfileController::class, 'show']);
            Route::post('profile/kyc', [RenterProfileController::class, 'kyc']);

            // Bookings
            Route::get('bookings',  [BookingController::class, 'renterIndex']);
            Route::post('bookings', [BookingController::class, 'store']);

            
            // Reviews
            Route::post('reviews', [ReviewController::class, 'store']);
        });

    });

});
