<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\AuthenticatedUserController;
use App\Http\Controllers\Api\V1\AuthenticatedUserDossierController;
use App\Http\Controllers\Api\V1\AuthenticatedUserReportController;
use App\Http\Controllers\Api\V1\DossierController;
use App\Http\Controllers\Api\V1\DossierReportController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\ReportImageController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Reports
    Route::apiResource('reports', ReportController::class)->only(['index', 'show']);
    Route::apiResource('dossiers.reports', DossierReportController::class)->only('index');

    // Dossiers
    Route::apiResource('dossiers', DossierController::class)->only(['index', 'show']);

    // Users
    Route::apiResource('users', UserController::class)->only(['index', 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        // Reports
        Route::apiResource('reports', ReportController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('reports.images', ReportImageController::class)->only(['store', 'destroy']);

        // Dossiers
        Route::apiResource('dossiers', DossierController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('dossiers.reports', DossierReportController::class)->only(['store', 'destroy']);

        // User
        Route::get('/user', [AuthenticatedUserController::class, 'show'])->name('user.show');
        Route::put('/user', [AuthenticatedUserController::class, 'update'])->name('user.update');
        Route::get('/user/reports', [AuthenticatedUserReportController::class, 'index'])->name('user.reports.index');
        Route::get('/user/dossiers', [AuthenticatedUserDossierController::class, 'index'])->name('user.dossiers.index');
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
