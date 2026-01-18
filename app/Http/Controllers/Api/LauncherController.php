<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagedDevice;
use App\Models\GlobalSetting;
use App\Models\SystemMarquee;
use App\Models\SystemApp;

class LauncherController extends Controller
{
    /**
     * Check if device is registered
     * GET /api/launcher?action=checkRegistration&device_id=TV-XXXXX
     */
    public function checkRegistration(Request $request)
    {
        $deviceId = $request->input('device_id');
        
        if (empty($deviceId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID tidak ada'
            ]);
        }

        $isRegistered = ManagedDevice::where('device_id', $deviceId)->exists();

        return response()->json([
            'status' => 'success',
            'is_registered' => $isRegistered
        ]);
    }

    /**
     * Get launcher status (enabled/disabled)
     * GET /api/launcher?action=getStatus
     */
    public function getStatus()
    {
        $setting = GlobalSetting::where('setting_key', 'launcher_enabled')->first();
        $enabled = $setting ? (bool)$setting->setting_value : false;

        return response()->json([
            'status' => 'success',
            'is_launcher_enabled' => $enabled
        ]);
    }

    /**
     * Get guest information by device ID
     * GET /api/launcher?action=getGuestInfo&device_id=TV-XXXXX
     */
    public function getGuestInfo(Request $request)
    {
        $deviceId = $request->input('device_id');
        
        if (empty($deviceId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID tidak ada'
            ]);
        }

        $device = ManagedDevice::where('device_id', $deviceId)->first();

        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Perangkat belum terdaftar'
            ]);
        }

        // Simple guest name logic (can be enhanced with PMS integration)
        $guestName = 'Guest';
        if ($device->room_number === '87') {
            $guestName = 'Mr. Ogie';
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'guest_name' => $guestName,
                'room_number' => $device->room_number
            ]
        ]);
    }

    /**
     * Get marquee text (running text)
     * GET /api/launcher?action=getMarqueeText
     */
    public function getMarqueeText()
    {
        $marquee = SystemMarquee::where('is_active', true)->first();
        $text = $marquee ? $marquee->content : 'Selamat datang di hotel kami!';

        return response()->json([
            'status' => 'success',
            'text' => $text
        ]);
    }

    /**
     * Get visible apps list
     * GET /api/launcher?action=getAppVisibility
     */
    public function getAppVisibility()
    {
        $apps = SystemApp::where('is_visible', true)
            ->orderBy('sort_order', 'asc')
            ->get(['app_key', 'app_name', 'app_name_en', 'icon_path', 'android_package', 'is_visible']);

        // Normalize icon URLs
        $apps = $apps->map(function ($app) {
            if (!empty($app->icon_path) && !preg_match('~^https?://~', $app->icon_path)) {
                $app->icon_path = url($app->icon_path);
            }
            return $app;
        });

        return response()->json([
            'status' => 'success',
            'apps' => $apps
        ]);
    }

    /**
     * Get app version
     * GET /api/launcher?action=getAppVersion
     */
    public function getAppVersion()
    {
        $setting = GlobalSetting::where('setting_key', 'launcher_version')->first();
        $version = $setting ? $setting->setting_value : '1.0.0';

        return response()->json([
            'status' => 'success',
            'version' => $version
        ]);
    }

    /**
     * Get home background image
     * GET /api/launcher?action=getHomeBackground
     */
    public function getHomeBackground()
    {
        $setting = GlobalSetting::where('setting_key', 'launcher_home_bg')->first();
        $backgroundUrl = $setting ? url($setting->setting_value) : url('img/hotel3.png');

        return response()->json([
            'status' => 'success',
            'background_url' => $backgroundUrl
        ]);
    }

    /**
     * Get weather data (placeholder - integrate with OpenWeather API)
     * GET /api/launcher?action=getWeather
     */
    public function getWeather()
    {
        // Placeholder - integrate with actual weather API
        return response()->json([
            'status' => 'success',
            'data' => [
                'temp' => 28,
                'description' => 'Cerah',
                'icon' => '01d'
            ]
        ]);
    }

    /**
     * Get custom greeting message
     * GET /api/launcher?action=getCustomGreeting
     */
    public function getCustomGreeting()
    {
        $title = GlobalSetting::where('setting_key', 'custom_greeting_title')->first();
        $message = GlobalSetting::where('setting_key', 'custom_welcome_greeting')->first();
        $image = GlobalSetting::where('setting_key', 'custom_greeting_image')->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'title' => $title ? $title->setting_value : 'Welcome',
                'message' => $message ? $message->setting_value : 'Welcome to our hotel!',
                'image_url' => $image ? url($image->setting_value) : null
            ]
        ]);
    }

    /**
     * Main API router (compatible with legacy format)
     * GET /api/launcher?action=xxx
     */
    public function handle(Request $request)
    {
        $action = $request->input('action');

        return match($action) {
            'checkRegistration' => $this->checkRegistration($request),
            'getStatus' => $this->getStatus(),
            'getGuestInfo' => $this->getGuestInfo($request),
            'getMarqueeText' => $this->getMarqueeText(),
            'getAppVisibility' => $this->getAppVisibility(),
            'getAppVersion' => $this->getAppVersion(),
            'getHomeBackground' => $this->getHomeBackground(),
            'getWeather' => $this->getWeather(),
            'getCustomGreeting' => $this->getCustomGreeting(),
            default => response()->json([
                'status' => 'error',
                'message' => 'Aksi tidak dikenal'
            ])
        };
    }
}
