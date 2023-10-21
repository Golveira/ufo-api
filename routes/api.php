<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\DossierController;
use App\Http\Controllers\Api\V1\DossierReportController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\UserDossierController;
use App\Http\Controllers\Api\V1\UserReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Reports
    Route::apiResource('reports', ReportController::class)->only(['index', 'show']);
    Route::apiResource('users.reports', UserReportController::class)->only('index');
    Route::apiResource('dossiers.reports', DossierReportController::class)->only('index');

    // Dossiers
    Route::apiResource('dossiers', DossierController::class)->only(['index', 'show']);
    Route::apiResource('users.dossiers', UserDossierController::class)->only('index');

    // Users
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        // Reports
        Route::apiResource('reports', ReportController::class)->only(['store', 'update', 'destroy']);

        // Dossiers
        Route::apiResource('dossiers', DossierController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('dossiers.reports', DossierReportController::class)->only(['store', 'destroy']);

        // Users
        Route::apiResource('users', UserController::class)->only(['update', 'delete']);
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
