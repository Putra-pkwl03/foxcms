<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ManagedDevice;

$deviceId = 'A22C4111FD74304E';

$device = ManagedDevice::where('device_id', $deviceId)->first();

if ($device) {
    $device->is_active = true;
    $device->registered_at = now();
    $device->save();
    
    echo "✓ Device activated successfully!\n";
    echo "Device ID: {$device->device_id}\n";
    echo "Registration Code: {$device->registration_code}\n";
    echo "Room: {$device->room_number}\n";
    echo "Active: " . ($device->is_active ? 'YES' : 'NO') . "\n";
} else {
    echo "✗ Device not found: $deviceId\n";
}
