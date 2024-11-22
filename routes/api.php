<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('portos', App\Http\Controllers\Api\v1\PortoController::class)
        ->only(['index', 'show']);

    Route::apiResource('experiences', App\Http\Controllers\Api\v1\ExperienceController::class)
        ->only(['index', 'show']);
});
