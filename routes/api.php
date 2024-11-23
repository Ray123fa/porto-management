<?php

use App\Http\Controllers\Api\v1\ExperienceController;
use App\Http\Controllers\Api\v1\PortoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('portos', PortoController::class)
        ->only(['index', 'show']);

    Route::apiResource('experiences', ExperienceController::class)
        ->only(['index', 'show']);
});
