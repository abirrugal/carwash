<?php

use App\Http\Controllers\Api\AdditionalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\GuidelineController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\ReminderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VehicleModelController;
use App\Http\Controllers\Api\VehicleNameController;
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
    Route::post('admin/login', [AuthController::class, 'adminLogin']);

    Route::post('verify-otp', [AuthController::class, 'verifyCode']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);

        Route::prefix('vehicle_name')->controller(VehicleNameController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{vehicle}', 'update');
            Route::delete('/{vehicle}', 'destroy');
        });
        Route::prefix('vehicle_model')->controller(VehicleModelController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{vehicle}', 'update');
            Route::delete('/{vehicle}', 'destroy');
        });
        Route::prefix('user_vehicle')->controller(UserController::class)->group(function () {
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
        Route::prefix('additional')->controller(AdditionalController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{additional}', 'update');
            Route::delete('/{additional}', 'destroy');
        });
        Route::prefix('guideline')->controller(GuidelineController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::put('/{guideline}', 'update');
            Route::delete('/{guideline}', 'destroy');
        });
        Route::prefix('other')->controller(ReminderController::class)->group(function () {
            Route::get('/reminder', 'reminders');
            Route::post('/reminder', 'updateReminders');

            Route::get('/promotion', 'promotions');
            Route::post('/promotion', 'updatePromotion');
        });
        Route::prefix('user')->controller(UserController::class)->group(function () {
            // Route::get('/location', 'location');
            // Route::post('/location', 'updateLocation');
            Route::get('/profile', 'profile');
            Route::post('/profile', 'updateProfile');
        });
        Route::prefix('user')->controller(FeedbackController::class)->group(function () {
            Route::get('/feedback', 'index');
            Route::post('/feedback', 'store');
        });
        Route::prefix('order')->controller(OrderController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            // Route::put('/{guideline}', 'update');
            // Route::delete('/{guideline}', 'destroy');
        });
    });
});
