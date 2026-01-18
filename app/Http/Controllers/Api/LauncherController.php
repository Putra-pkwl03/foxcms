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
        $deviceId = strtoupper(trim($request->input('device_id')));
        $deviceName = $request->input('device_name');
        
        if (empty($deviceId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID tidak ada'
            ]);
        }

        $device = ManagedDevice::where('device_id', $deviceId)->first();

        if (!$device) {
            // Auto-discover: create new device record as inactive
            $device = ManagedDevice::create([
                'device_id' => $deviceId,
                'device_name' => $deviceName ?: ('New STB (' . $request->ip() . ')'),
                'room_number' => '-',
                'is_active' => false,
                'ip_address' => $request->ip(),
                'status_online' => 'online',
                'last_seen' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'is_registered' => false,
                'registration_code' => $device->registration_code
            ]);
        }

        // Update last seen & IP
        $device->update([
            'last_seen' => now(),
            'ip_address' => $request->ip(),
            'status_online' => 'online'
        ]);

        return response()->json([
            'status' => 'success',
            'is_registered' => (bool)$device->is_active
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
     * Get home menus
     * GET /api/v1/home-menus
     */
    public function getHomeMenus(Request $request)
    {
        $lang = $request->query('lang', 'id');
        
        // Default menus if table doesn't exist yet
        $menus = [
            [
                'menu_key' => 'tv',
                'menu_name' => $lang == 'en' ? 'Live TV' : 'TV Langsung',
                'icon_path' => url('img/menu/tv.png'),
                'action_type' => 'function',
                'action_value' => 'openTv'
            ],
            [
                'menu_key' => 'apps',
                'menu_name' => $lang == 'en' ? 'Apps' : 'Aplikasi',
                'icon_path' => url('img/menu/apps.png'),
                'action_type' => 'dialog',
                'action_value' => 'apps'
            ],
            [
                'menu_key' => 'info',
                'menu_name' => $lang == 'en' ? 'Hotel Info' : 'Informasi Hotel',
                'icon_path' => url('img/menu/info.png'),
                'action_type' => 'dialog',
                'action_value' => 'info'
            ],
            [
                'menu_key' => 'dining',
                'menu_name' => $lang == 'en' ? 'Dining' : 'Restoran',
                'icon_path' => url('img/menu/dining.png'),
                'action_type' => 'dialog',
                'action_value' => 'dining'
            ]
        ];

        return response()->json([
            'status' => 'success',
            'menus' => $menus
        ]);
    }

    /**
     * Get weather data
     * GET /api/launcher?action=getWeather
     */
    public function getWeather(Request $request)
    {
        $lang = $request->query('lang', 'id');
        // Placeholder - integrate with actual weather API
        return response()->json([
            'status' => 'success',
            'data' => [
                'temp' => 28,
                'description' => $lang == 'en' ? 'Sunny' : 'Cerah',
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
                'content' => $message ? $message->setting_value : 'Welcome to our hotel!',
                'image' => $image ? url($image->setting_value) : url('img/hotel3.png')
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
        \Log::info('Launcher API Request', ['action' => $action, 'device_id' => $request->input('device_id'), 'ip' => $request->ip()]);

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
