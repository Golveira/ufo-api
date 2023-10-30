<?php

use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Dossiers\DossierController;
use App\Http\Controllers\Api\V1\Dossiers\DossierReportController;
use App\Http\Controllers\Api\V1\Reports\ReportController;
use App\Http\Controllers\Api\V1\Reports\ReportImageController;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\UserDossierController;
use App\Http\Controllers\Api\V1\User\UserReportController;
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
        Route::get('/user', [ProfileController::class, 'show'])->name('user.show');
        Route::put('/user', [ProfileController::class, 'update'])->name('user.update');
        Route::get('/user/reports', [UserReportController::class, 'index'])->name('user.reports.index');
        Route::get('/user/dossiers', [UserDossierController::class, 'index'])->name('user.dossiers.index');
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
