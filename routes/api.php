<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ReportController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Reports
    Route::apiResource('reports', ReportController::class)->only('index', 'show');

    Route::middleware('auth:sanctum')->group(function () {
        // Reports
        Route::apiResource('reports', ReportController::class)->only('store', 'update', 'destroy');
    });

    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('/register', [RegisterController::class, 'store'])->name('register');
        Route::post('/login', [LoginController::class, 'store'])->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
        });
    });
});
