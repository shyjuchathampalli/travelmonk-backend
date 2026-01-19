<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\StateController;
use App\Http\Controllers\Api\V1\ArrivalPointController;
use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\DestinationCategoryController;
use App\Http\Controllers\Api\V1\DestinationController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\TravelPurposeController;
use App\Http\Controllers\Api\V1\VendorController;

Route::prefix('v1')->group(function () {
    Route::get('/states', [StateController::class, 'index']);
});

Route::prefix('v1')->group(function () {
    Route::get('/arrival-points', [ArrivalPointController::class, 'index']);
});

Route::prefix('v1')->group(function () {
    Route::get('/activities/general', [ActivityController::class, 'general']);
    Route::get('/activities', [ActivityController::class, 'byDestination']);
});

Route::prefix('v1')->group(function () {
    Route::get('/countries', [CountryController::class, 'index']);
});

Route::prefix('v1')->group(function () {
    Route::get('/destination-categories', [
        DestinationCategoryController::class,
        'index',
    ]);
});

Route::prefix('v1')->group(function () {
    Route::get('/destinations', [DestinationController::class, 'index']);
});

Route::prefix('v1')->group(function () {
    Route::get('/packages', [PackageController::class, 'index']);
    Route::get('/packages/{package}', [PackageController::class, 'show']);
});

Route::prefix('v1')->group(function () {
    Route::get('/travel-purposes', [TravelPurposeController::class, 'index']);
});

Route::prefix('v1')->group(function () {
    Route::get('/vendors', [VendorController::class, 'index']);
});
