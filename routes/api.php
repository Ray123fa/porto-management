<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('v1/portos', App\Http\Controllers\Api\v1\PortoController::class)->only(['index', 'show']);
