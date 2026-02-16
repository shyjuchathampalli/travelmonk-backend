<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/google', [AuthController::class, 'googleLogin']);

    Route::post('/forgot-password', [PasswordController::class, 'forgot']);
    Route::post('/reset-password', [PasswordController::class, 'reset']);

    // Email verification
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->away('http://localhost:3000/email-verified');
    })
    ->middleware(['signed'])
    ->name('verification.verify');

    Route::post('/email/resend', [AuthController::class, 'resendVerification'])
    ->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

