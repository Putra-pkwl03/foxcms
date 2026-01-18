<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Launcher API - Compatible with legacy format
// Usage: /api/launcher?action=checkRegistration&device_id=TV-XXXXX
Route::any('/launcher', [App\Http\Controllers\Api\LauncherController::class, 'handle']);

// Clean Laravel Style Routes (Match AHF-APP for STB compatibility)
Route::prefix('v1')->group(function () {
    Route::get('/check-registration', [App\Http\Controllers\Api\LauncherController::class, 'checkRegistration']);
    Route::get('/status', [App\Http\Controllers\Api\LauncherController::class, 'getStatus']);
    Route::get('/guest-info', [App\Http\Controllers\Api\LauncherController::class, 'getGuestInfo']);
    Route::get('/marquee', [App\Http\Controllers\Api\LauncherController::class, 'getMarqueeText']);
    Route::get('/home-menus', [App\Http\Controllers\Api\LauncherController::class, 'getHomeMenus']);
    Route::get('/apps', [App\Http\Controllers\Api\LauncherController::class, 'getAppVisibility']);
    Route::get('/background', [App\Http\Controllers\Api\LauncherController::class, 'getHomeBackground']);
    Route::get('/latest-apk', [App\Http\Controllers\Api\LauncherController::class, 'getAppVersion']);
    Route::get('/greeting', [App\Http\Controllers\Api\LauncherController::class, 'getCustomGreeting']);
    Route::get('/weather', [App\Http\Controllers\Api\LauncherController::class, 'getWeather']);
});
