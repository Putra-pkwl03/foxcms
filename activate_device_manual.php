<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Manual Device Registration ===\n\n";

$deviceId = 'D0D61B808EE3AE23';
$deviceName = 'B866V2FA';
$roomNumber = '101'; // Ganti sesuai kebutuhan

// Cek apakah sudah ada
$device = \App\Models\ManagedDevice::where('device_id', $deviceId)->first();

if ($device) {
    echo "Device already exists. Updating...\n";
    $device->is_active = true;
    $device->registered_at = now();
    $device->device_name = $deviceName;
    $device->room_number = $roomNumber;
    $device->save();
    echo "✓ Device updated!\n";
} else {
    echo "Creating new device...\n";
    $device = \App\Models\ManagedDevice::create([
        'device_id' => $deviceId,
        'device_name' => $deviceName,
        'room_number' => $roomNumber,
        'is_active' => true,
        'registered_at' => now(),
        'ip_address' => '192.168.100.206',
        'status_online' => 'online',
        'last_seen' => now()
    ]);
    echo "✓ Device created!\n";
}

echo "\nDevice Details:\n";
echo "  - Device ID: " . $device->device_id . "\n";
echo "  - Registration Code: " . $device->registration_code . "\n";
echo "  - Device Name: " . $device->device_name . "\n";
echo "  - Room: " . $device->room_number . "\n";
echo "  - Active: " . ($device->is_active ? 'YES' : 'NO') . "\n";
echo "  - Registered At: " . $device->registered_at->format('Y-m-d H:i:s') . "\n";

echo "\n✓ Device is now ACTIVE and REGISTERED!\n";
echo "Restart the app on device to see main menu.\n";
