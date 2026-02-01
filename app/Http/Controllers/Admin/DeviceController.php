<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = \App\Models\ManagedDevice::orderBy('created_at', 'desc')->get();
        return view('admin.devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:managed_devices',
            'registration_code' => 'nullable|string|max:20|unique:managed_devices',
            'device_name' => 'required|string|max:100',
            'room_number' => 'required|string|max:10',
            'notes' => 'nullable|string',
        ]);

        $validated['is_active'] = false; // Default to inactive for manual registration

        \App\Models\ManagedDevice::create($validated);

        return redirect()->route('admin.devices.index')->with('success', 'Device registered successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        return view('admin.devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $validated = $request->validate([
            'device_id' => 'required|string|max:100|unique:managed_devices,device_id,' . $id,
            'registration_code' => 'nullable|string|max:20|unique:managed_devices,registration_code,' . $id,
            'device_name' => 'required|string|max:100',
            'room_number' => 'required|string|max:10',
            'notes' => 'nullable|string',
        ]);

        $device = \App\Models\ManagedDevice::findOrFail($id);
        $device->update($validated);

        return redirect()->route('admin.devices.index')->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        $device->delete();

        return redirect()->route('admin.devices.index')->with('success', 'Device deleted successfully.');
    }

    /**
     * Toggle device active status.
     */
    public function toggleActive(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        $device->is_active = !$device->is_active;
        
        // If activating and was never registered, set registered_at
        if ($device->is_active && !$device->registered_at) {
            $device->registered_at = now();
        }
        
        $device->save();

        $status = $device->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.devices.index')->with('success', "Device has been $status.");
    }

    /**
     * Show device tools page.
     */
    public function tools(string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        return view('admin.devices.tools', compact('device'));
    }

    /**
     * Execute ADB tool command.
     */
    public function executeToolCommand(Request $request, string $id)
    {
        $device = \App\Models\ManagedDevice::findOrFail($id);
        $command = $request->input('command');
        $ip = $device->ip_address;

        if (!$ip) {
            return response()->json(['status' => 'error', 'message' => 'IP Address not found. Connect device first.']);
        }

        // ADB Path - Using local binary in storage/adb
        $adbPath = storage_path('adb/adb.exe'); 
        
        // Check if device is connected, if not try to connect
        exec("\"$adbPath\" connect $ip:5555 2>&1", $connectOutput);
        
        $result = "";
        $success = true;

        try {
            switch($command) {
                case 'reboot':
                    exec("\"$adbPath\" -s $ip:5555 reboot 2>&1", $out);
                    $result = "Device is rebooting...";
                    break;
                case 'clear_cache':
                    // Need SystemApp model to get packages
                    $packages = \App\Models\SystemApp::whereNotNull('android_package')->pluck('android_package')->toArray();
                    if (empty($packages)) {
                        $packages = ['com.android.chrome', 'com.google.android.youtube']; // Fallback
                    }
                    foreach ($packages as $pkg) {
                        exec("\"$adbPath\" -s $ip:5555 shell pm clear $pkg 2>&1");
                    }
                    $result = "Guest data & cache cleared for all apps.";
                    break;
                case 'home':
                    exec("\"$adbPath\" -s $ip:5555 shell am start -n com.takeoff.launcher/.MainActivity 2>&1");
                    $result = "Device returned to Home Screen.";
                    break;
                case 'set_owner':
                    exec("\"$adbPath\" -s $ip:5555 shell dpm set-device-owner com.takeoff.launcher/.MyDeviceAdminReceiver 2>&1", $out);
                    $result = "Set Device Owner command sent. Check device screen.";
                    break;
                case 'set_default_launcher':
                    exec("\"$adbPath\" -s $ip:5555 shell pm disable-user com.google.android.tvlauncher 2>&1");
                    exec("\"$adbPath\" -s $ip:5555 shell cmd package set-home-activity com.takeoff.launcher/.MainActivity 2>&1");
                    $result = "TakeOff Launcher set as default system home.";
                    break;
                case 'logs':
                    exec("\"$adbPath\" -s $ip:5555 logcat -d *:W 2>&1", $logOutput);
                    $slicedLogs = array_slice($logOutput, -100);
                    $logsStr = implode("\n", $slicedLogs);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Logs fetched successfully',
                        'data' => $logsStr ?: "No logs found or device is offline."
                    ]);
                default:
                    $success = false;
                    $result = "Unknown command.";
            }
        } catch (\Exception $e) {
            $success = false;
            $result = "Error: " . $e->getMessage();
        }

        return response()->json([
            'status' => $success ? 'success' : 'error',
            'message' => $result
        ]);
    }


// public function executeToolCommand(Request $request, string $id)
// {
//     $device = \App\Models\ManagedDevice::findOrFail($id);
//     $command = $request->input('command');
//     $ip = $device->ip_address;

//     if (!$ip) {
//         return response()->json(['status' => 'error', 'message' => 'IP Address tidak ditemukan.']);
//     }

//     // FIX: Gunakan path lengkap adb di Ubuntu Docker agar user www-data mengenalinya
//     $adb = "/usr/lib/android-sdk/platform-tools/adb";
    
//     // Pastikan terkoneksi sebelum eksekusi perintah
//     exec("timeout 5 $adb connect $ip:5555 2>&1");
    
//     $result = "";
//     $success = true;

//     try {
//         switch($command) {
//             case 'reboot':
//                 exec("timeout 5 $adb -s $ip:5555 reboot 2>&1");
//                 $result = "Device sedang reboot...";
//                 break;

//             case 'clear_cache':
//                 $packages = \App\Models\SystemApp::whereNotNull('android_package')->pluck('android_package')->toArray();
//                 if (empty($packages)) {
//                     $packages = ['com.takeoff.launcher']; 
//                 }
//                 foreach ($packages as $pkg) {
//                     exec("timeout 5 $adb -s $ip:5555 shell am force-stop $pkg 2>&1");
//                     exec("timeout 5 $adb -s $ip:5555 shell pm clear $pkg 2>&1");
//                     exec("timeout 5 $adb -s $ip:5555 shell pm enable $pkg 2>&1");
//                 }
//                 $result = "Data tamu & cache berhasil dibersihkan.";
//                 break;

//             case 'home':
//                 // Mengembalikan fungsi Home dari versi Windows
//                 exec("timeout 5 $adb -s $ip:5555 shell am start -n com.takeoff.launcher/.MainActivity 2>&1");
//                 $result = "Device kembali ke layar utama.";
//                 break;

//             case 'set_owner':
//                 // Mengembalikan fungsi Device Owner dari versi Windows
//                 exec("timeout 5 $adb -s $ip:5555 shell dpm set-device-owner com.takeoff.launcher/.MyDeviceAdminReceiver 2>&1");
//                 $result = "Perintah Set Device Owner dikirim. Cek layar STB.";
//                 break;

//             case 'set_default_launcher':
//                 // Mengembalikan fungsi Default Launcher dari versi Windows
//                 exec("timeout 5 $adb -s $ip:5555 shell pm disable-user com.google.android.tvlauncher 2>&1");
//                 exec("timeout 5 $adb -s $ip:5555 shell cmd package set-home-activity com.takeoff.launcher/.MainActivity 2>&1");
//                 $result = "TakeOff Launcher diset sebagai default.";
//                 break;

//             case 'logs':
//                 exec("timeout 10 $adb -s $ip:5555 logcat -d -t 100 *:W 2>&1", $logOutput);
//                 $logsStr = implode("\n", $logOutput);
//                 return response()->json([
//                     'status' => 'success',
//                     'message' => 'Logs fetched successfully',
//                     'data' => $logsStr ?: "Tidak ada log atau device offline."
//                 ]);

//             default:
//                 $success = false;
//                 $result = "Perintah ($command) tidak dikenal.";
//         }
//     } catch (\Exception $e) {
//         $success = false;
//         $result = "Error: " . $e->getMessage();
//     }

//     return response()->json([
//         'status' => $success ? 'success' : 'error',
//         'message' => $result
//     ]);
// }
}
