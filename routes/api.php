<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Launcher API - Compatible with legacy format
// Usage: /api/launcher?action=checkRegistration&device_id=TV-XXXXX
Route::get('/launcher', [App\Http\Controllers\Api\LauncherController::class, 'handle']);
