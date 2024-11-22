<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::apiResource('v1/portos', App\Http\Controllers\Api\v1\PortoController::class)
    ->only(['index', 'show'])
    ->middleware('auth:sanctum');
