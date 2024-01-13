<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);

    Route::post('verify-otp', [AuthController::class, 'verifyCode']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        // Route::prefix('user')->controller(UserController::class)->group(function () {
        //     Route::get('/profile', 'profile');
        //     Route::put('/profile/update', 'update');
        // });

        Route::prefix('vehicle')->controller(VehicleController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{vehicle}', 'update');
            Route::delete('/{vehicle}', 'destroy');
        });
        Route::prefix('package')->controller(PackageController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{package}', 'update');
            Route::delete('/{package}', 'destroy');
        });
    });
});
