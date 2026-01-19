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
        
        // Refresh to get latest data from DB (especially for boolean casts)
        $device->refresh();

        // Check Global Launcher Status
        $globalEnabled = GlobalSetting::where('setting_key', 'launcher_enabled')->first();
        if ($globalEnabled && $globalEnabled->setting_value === '0') {
            return response()->json([
                'status' => 'success',
                'is_registered' => false,
                'message' => 'Layanan Launcher sedang dimatikan oleh sistem.',
                'registration_code' => 'OFFLINE'
            ]);
        }

        // DEBUG: Log the actual value before returning
        $isRegistered = (bool)$device->is_active;
        \Log::info('CheckRegistration Response', [
            'device_id' => $deviceId,
            'is_active_raw' => $device->is_active,
            'is_active_type' => gettype($device->is_active),
            'is_registered' => $isRegistered
        ]);

        return response()->json([
            'status' => 'success',
            'is_registered' => $isRegistered,
            'registration_code' => $device->registration_code
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
        $text = $marquee ? $marquee->content : null;

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
            ->get(['app_key', 'app_name', 'app_name_en', 'icon_path', 'android_package', 'apk_url', 'is_visible']);

        // Normalize icon URLs and convert is_visible to boolean
        $apps = $apps->map(function ($app) {
            if (!empty($app->icon_path) && !preg_match('~^https?://~', $app->icon_path)) {
                $app->icon_path = url($app->icon_path);
            }
            
            // Convert is_visible to strict boolean for Android
            $app->is_visible = (bool)$app->is_visible;
            
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
            'version' => $version,
            'latest_apk' => 'launcher_update.apk'
        ]);
    }

    /**
     * Get home background image
     * GET /api/launcher?action=getHomeBackground
     */
    public function getHomeBackground()
    {
        $setting = GlobalSetting::where('setting_key', 'launcher_home_bg')->first();
        $backgroundUrl = $setting ? $setting->setting_value : 'img/hotel3.png';
        
        if (!preg_match('~^https?://~', $backgroundUrl)) {
            $backgroundUrl = url($backgroundUrl);
        }

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
                'action_value' => 'show_apps_dialog'
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
            ],
            [
                'menu_key' => 'amenities',
                'menu_name' => 'Amenities',
                'icon_path' => url('img/menu/amenities.png'),
                'action_type' => 'dialog',
                'action_value' => 'amenities'
            ],
            [
                'menu_key' => 'facilities',
                'menu_name' => $lang == 'en' ? 'Facilities' : 'Fasilitas Hotel',
                'icon_path' => url('img/menu/facilities.png'),
                'action_type' => 'dialog',
                'action_value' => 'facilities'
            ],
            [
                'menu_key' => 'clear_cache',
                'menu_name' => $lang == 'en' ? 'Clear Cache' : 'Hapus Cache',
                'icon_path' => url('img/menu/cache.png'),
                'action_type' => 'function',
                'action_value' => 'clear_cache'
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
            'getSplash' => $this->getSplash(),
            'getLogo' => $this->getLogo(),
            'clearDeviceData' => $this->clearDeviceData($request),
            default => response()->json([
                'status' => 'error',
                'message' => 'Aksi tidak dikenal'
            ])
        };
    }

    /**
     * Get splash video (intro video)
     * GET /api/launcher?action=getSplash
     */
    public function getSplash()
    {
        $setting = GlobalSetting::where('setting_key', 'intro_video_url')->first();
        $videoUrl = $setting ? $setting->setting_value : 'assets/videos/opening.mp4';
        
        // If it's a relative path, make it a URL
        if (!preg_match('~^https?://~', $videoUrl)) {
            $videoUrl = url($videoUrl);
        }

        return response()->json([
            'status' => 'success',
            'url' => $videoUrl
        ]);
    }

    /**
     * Get loading logo
     * GET /api/launcher?action=getLogo
     */
    public function getLogo()
    {
        $setting = GlobalSetting::where('setting_key', 'loading_logo_url')->first();
        $logoUrl = $setting ? $setting->setting_value : 'assets/img/logo.png';
        
        // If it's a relative path, make it a URL
        if (!preg_match('~^https?://~', $logoUrl)) {
            $logoUrl = url($logoUrl);
        }

        return response()->json([
            'status' => 'success',
            'url' => $logoUrl
        ]);
    }
    /**
     * Clear Cache & Data remotely via ADB when requested by STB
     * GET /api/v1/remote-clear
     */
    public function clearDeviceData(Request $request) 
    {
        try {
            $ip = $request->ip();
            
            // ADB Path
            $adbPath = storage_path('adb/adb.exe');
            if (!file_exists($adbPath)) {
                return response()->json(['status' => 'error', 'message' => 'ADB tools not found on server'], 500);
            }

            // Connect to device
            exec("\"$adbPath\" connect $ip:5555 2>&1");
            
            // List of packages to clear
            // In a real scenario, fetch this from SystemApp model where android_package is not null
            // For now, use the same default list as AHF-APP + browsers
            $packages = [
                'com.android.chrome',
                'com.google.android.webview', 
                'org.mozilla.firefox',
                'com.opera.browser',
                'com.google.android.youtube',
                'com.google.android.youtube.tv'
            ];
            
            $results = [];
            foreach ($packages as $pkg) {
                exec("\"$adbPath\" -s $ip:5555 shell pm clear $pkg 2>&1", $output, $returnVar);
                $results[$pkg] = ($returnVar === 0) ? 'Cleaned' : 'Failed/Not Found';
            }

            return response()->json([
                'status' => 'success',
                'target_ip' => $ip,
                'message' => 'Cache clearing commands executed',
                'results' => $results
            ]);

        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Get dining menus
     * GET /api/v1/dining-menus?lang=id
     */
    public function getDiningMenus(Request $request)
    {
        $lang = $request->query('lang', 'id');
        
        // Schema: name, name_en, description, price, image_url, status
        $menus = \App\Models\DiningMenu::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name', 'name_en', 'description', 'price', 'image_url']);

        // Normalize image URLs & Language
        $menus = $menus->map(function ($menu) use ($lang) {
            // Map image_url to image_path for API consistency
            $menu->image_path = $menu->image_url;

            if (!empty($menu->image_path) && !preg_match('~^https?://~', $menu->image_path)) {
                $menu->image_path = url($menu->image_path);
            }
            
            // Use language-specific fields
            $menu->display_name = $lang == 'en' ? ($menu->name_en ?: $menu->name) : $menu->name;
            // description_en column doesn't exist in migration, use description for both or empty
            $menu->display_description = $menu->description; 
            
            return $menu;
        });

        return response()->json([
            'status' => 'success',
            'menus' => $menus
        ]);
    }

    /**
     * Create dining order
     * POST /api/v1/dining-order
     * Body: { device_id, menu_id, quantity, notes }
     */
    public function createDiningOrder(Request $request)
    {
        $deviceId = $request->input('device_id');
        $menuId = $request->input('menu_id');
        $quantity = $request->input('quantity', 1);
        $notes = $request->input('notes', '');

        if (empty($deviceId) || empty($menuId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID dan Menu ID wajib diisi'
            ], 400);
        }

        $device = \App\Models\ManagedDevice::where('device_id', $deviceId)->first();
        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak terdaftar'
            ], 404);
        }

        $menu = \App\Models\DiningMenu::find($menuId);
        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }

        // Fetch guest name
        $checkin = \App\Models\GuestCheckin::where('room_number', $device->room_number)
            ->where('status', 'checked_in')
            ->first();
        $guestName = $checkin ? $checkin->guest_name : 'Unknown Guest';
        
        // Format items string
        $itemString = "{$quantity}x {$menu->name}";
        
        $order = \App\Models\HotelOrder::create([
            'room_number' => $device->room_number,
            'guest_name' => $guestName,
            'items' => $itemString . ($notes ? " (Note: $notes)" : ""),
            'total_price' => $menu->price * $quantity,
            'status' => 'Pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesanan berhasil dibuat',
            'order' => $order
        ], 201);
    }

    /**
     * Get dining orders for a device
     */
    public function getDiningOrders(Request $request)
    {
        $deviceId = $request->query('device_id');
        
        if (empty($deviceId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID wajib diisi'
            ], 400);
        }

        $device = \App\Models\ManagedDevice::where('device_id', $deviceId)->first();
        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak terdaftar'
            ], 404);
        }

        // Return orders linked by room number, as we don't save device_id in hotel_orders
        $orders = \App\Models\HotelOrder::where('room_number', $device->room_number)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

    /**
     * Get available amenities
     * GET /api/v1/amenities?lang=id
     */
    public function getAmenities(Request $request)
    {
        $lang = $request->query('lang', 'id');
        
        $amenities = \App\Models\RoomAmenity::orderBy('name')
            ->get(['id', 'name', 'name_en', 'description', 'description_en', 'icon_path']);

        // Normalize icon URLs
        $amenities = $amenities->map(function ($amenity) use ($lang) {
            if (!empty($amenity->icon_path) && !preg_match('~^https?://~', $amenity->icon_path)) {
                $amenity->icon_path = url($amenity->icon_path);
            }
            
            // Use language-specific fields
            $amenity->display_name = $lang == 'en' ? ($amenity->name_en ?: $amenity->name) : $amenity->name;
            $amenity->display_description = $lang == 'en' ? ($amenity->description_en ?: $amenity->description) : $amenity->description;
            
            return $amenity;
        });

        return response()->json([
            'status' => 'success',
            'amenities' => $amenities
        ]);
    }

    /**
     * Create amenity request
     * POST /api/v1/amenity-request
     * Body: { device_id, amenity_id, quantity, notes }
     */
    public function createAmenityRequest(Request $request)
    {
        $deviceId = $request->input('device_id');
        $amenityId = $request->input('amenity_id');
        $quantity = $request->input('quantity', 1);
        $notes = $request->input('notes', '');

        if (empty($deviceId) || empty($amenityId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID dan Amenity ID wajib diisi'
            ], 400);
        }

        $device = \App\Models\ManagedDevice::where('device_id', $deviceId)->first();
        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak terdaftar'
            ], 404);
        }

        $amenity = \App\Models\RoomAmenity::find($amenityId);
        if (!$amenity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Amenity tidak ditemukan'
            ], 404);
        }

        // Fetch guest name
        $checkin = \App\Models\GuestCheckin::where('room_number', $device->room_number)
            ->where('status', 'checked_in')
            ->first();
        $guestName = $checkin ? $checkin->guest_name : 'Unknown Guest';
        
        // Format items string
        $itemString = "{$quantity}x {$amenity->name}";

        $amenityRequest = \App\Models\AmenityRequest::create([
            'room_number' => $device->room_number,
            'guest_name' => $guestName,
            'items' => $itemString . ($notes ? " (Note: $notes)" : ""),
            'status' => 'Pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Request berhasil dibuat',
            'request' => $amenityRequest
        ], 201);
    }

    /**
     * Get amenity requests for a device
     * GET /api/v1/amenity-requests?device_id=xxx
     */
    public function getAmenityRequests(Request $request)
    {
        $deviceId = $request->query('device_id');
        
        if (empty($deviceId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device ID wajib diisi'
            ], 400);
        }

        $device = \App\Models\ManagedDevice::where('device_id', $deviceId)->first();
        if (!$device) {
            return response()->json([
                'status' => 'error',
                'message' => 'Device tidak terdaftar'
            ], 404);
        }

        $requests = \App\Models\AmenityRequest::where('device_id', $device->id)
            ->with('amenity')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'requests' => $requests
        ]);
    }

    /**
     * Get hotel information
     * GET /api/v1/hotel-info?lang=id
     */
    public function getHotelInfo(Request $request)
    {
        $lang = $request->query('lang', 'id');
        
        // Schema: title, title_en, description, description_en, icon_path (no is_active)
        $infos = \App\Models\HotelInfo::orderBy('sort_order')
            ->get(['id', 'title', 'title_en', 'description as content', 'description_en as content_en', 'icon_path']);

        // Normalize icon URLs
        $infos = $infos->map(function ($info) use ($lang) {
            if (!empty($info->icon_path) && !preg_match('~^https?://~', $info->icon_path)) {
                $info->icon_path = url($info->icon_path);
            }
            
            // Use language-specific fields
            $info->display_title = $lang == 'en' ? ($info->title_en ?: $info->title) : $info->title;
            $info->display_content = $lang == 'en' ? ($info->content_en ?: $info->content) : $info->content;
            
            return $info;
        });

        return response()->json([
            'status' => 'success',
            'infos' => $infos
        ]);
    }

    /**
     * Get hotel facilities
     * GET /api/v1/hotel-facilities?lang=id
     */
    public function getHotelFacilities(Request $request)
    {
        $lang = $request->query('lang', 'id');
        
        $facilities = \App\Models\HotelFacility::where('is_active', true)
            ->orderBy('name')
            // Schema only has description, no location/operating_hours
            ->get(['id', 'name', 'name_en', 'description', 'description_en', 'icon_path', 'is_active']);

        // Normalize icon URLs and map fields
        $facilities = $facilities->map(function ($facility) use ($lang) {
            if (!empty($facility->icon_path) && !preg_match('~^https?://~', $facility->icon_path)) {
                $facility->icon_path = url($facility->icon_path);
            }
            
            // Use language-specific fields
            $facility->display_name = $lang == 'en' ? ($facility->name_en ?: $facility->name) : $facility->name;
            $facility->display_description = $lang == 'en' ? ($facility->description_en ?: $facility->description) : $facility->description;

            // Map Android-specific fields
            $facility->is_available = (bool) $facility->is_active;
            $facility->location = null;
            $facility->operating_hours = null;
            
            return $facility;
        });

        return response()->json([
            'status' => 'success',
            'facilities' => $facilities
        ]);
    }
}
