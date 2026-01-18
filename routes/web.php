<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dining-menu', App\Http\Controllers\Admin\DiningMenuController::class);
    Route::resource('devices', App\Http\Controllers\Admin\DeviceController::class);
    Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
    Route::resource('system-apps', App\Http\Controllers\Admin\SystemAppController::class);
    Route::resource('checkin', App\Http\Controllers\Admin\CheckinController::class);
    Route::resource('info', App\Http\Controllers\Admin\InformationController::class);
    Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class);
    
    Route::get('/requests/dining', [App\Http\Controllers\Admin\RequestController::class, 'dining'])->name('requests.dining');
    Route::post('/requests/dining/{id}', [App\Http\Controllers\Admin\RequestController::class, 'updateDiningStatus'])->name('requests.dining.update');
    
    Route::get('/requests/amenities', [App\Http\Controllers\Admin\RequestController::class, 'amenities'])->name('requests.amenities');
    Route::post('/requests/amenities/{id}', [App\Http\Controllers\Admin\RequestController::class, 'updateAmenityStatus'])->name('requests.amenities.update');
    
    Route::get('/settings/marquee', [App\Http\Controllers\Admin\SettingController::class, 'marquee'])->name('settings.marquee');
    Route::post('/settings/marquee', [App\Http\Controllers\Admin\SettingController::class, 'updateMarquee'])->name('settings.marquee.update');
    
    Route::get('/settings/global', [App\Http\Controllers\Admin\SettingController::class, 'global'])->name('settings.global');
    Route::post('/settings/global', [App\Http\Controllers\Admin\SettingController::class, 'updateGlobal'])->name('settings.global.update');
});
