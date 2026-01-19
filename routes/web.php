<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

use App\Http\Controllers\Auth\LoginController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('dining-menu', App\Http\Controllers\Admin\DiningMenuController::class);
    Route::resource('devices', App\Http\Controllers\Admin\DeviceController::class);
    Route::post('devices/{id}/toggle-active', [App\Http\Controllers\Admin\DeviceController::class, 'toggleActive'])->name('devices.toggle-active');
    Route::get('devices/{id}/tools', [App\Http\Controllers\Admin\DeviceController::class, 'tools'])->name('devices.tools');
    Route::post('devices/{id}/tools/execute', [App\Http\Controllers\Admin\DeviceController::class, 'executeToolCommand'])->name('devices.tools.execute');
    Route::resource('facilities', App\Http\Controllers\Admin\FacilityController::class);
    Route::resource('system-apps', App\Http\Controllers\Admin\SystemAppController::class);
    Route::resource('checkin', App\Http\Controllers\Admin\CheckinController::class);
    Route::resource('info', App\Http\Controllers\Admin\InformationController::class);
    Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class);
    Route::resource('home-menus', App\Http\Controllers\Admin\HomeMenuController::class);
    
    Route::get('/requests/dining', [App\Http\Controllers\Admin\RequestController::class, 'dining'])->name('requests.dining');
    Route::get('/requests/dining/room/{room}', [App\Http\Controllers\Admin\RequestController::class, 'diningRoomDetail'])->name('requests.dining.room');
    Route::post('/requests/dining/{id}', [App\Http\Controllers\Admin\RequestController::class, 'updateDiningStatus'])->name('requests.dining.update');
    
    Route::get('/requests/amenities', [App\Http\Controllers\Admin\RequestController::class, 'amenities'])->name('requests.amenities');
    Route::get('/requests/amenities/room/{room}', [App\Http\Controllers\Admin\RequestController::class, 'amenityRoomDetail'])->name('requests.amenities.room');
    Route::post('/requests/amenities/{id}', [App\Http\Controllers\Admin\RequestController::class, 'updateAmenityStatus'])->name('requests.amenities.update');
    
    Route::get('/settings/marquee', [App\Http\Controllers\Admin\SettingController::class, 'marquee'])->name('settings.marquee');
    Route::post('/settings/marquee', [App\Http\Controllers\Admin\SettingController::class, 'updateMarquee'])->name('settings.marquee.update');
    
    Route::get('/settings/global', [App\Http\Controllers\Admin\SettingController::class, 'global'])->name('settings.global');
    Route::post('/settings/global', [App\Http\Controllers\Admin\SettingController::class, 'updateGlobal'])->name('settings.global.update');
});
