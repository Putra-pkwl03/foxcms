<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking Managed Devices ===\n\n";

$devices = \App\Models\ManagedDevice::latest()->take(5)->get();

if ($devices->isEmpty()) {
    echo "No devices found in database.\n";
} else {
    foreach ($devices as $device) {
        echo "Device ID: " . $device->device_id . "\n";
        echo "  - is_active (raw): " . var_export($device->getAttributes()['is_active'], true) . "\n";
        echo "  - is_active (cast): " . var_export($device->is_active, true) . "\n";
        echo "  - Type: " . gettype($device->is_active) . "\n";
        echo "  - Registration Code: " . $device->registration_code . "\n";
        echo "  - Room Number: " . $device->room_number . "\n";
        echo "  - Last Seen: " . ($device->last_seen ? $device->last_seen->format('Y-m-d H:i:s') : 'Never') . "\n";
        echo "  - Registered At: " . ($device->registered_at ? $device->registered_at->format('Y-m-d H:i:s') : 'Not registered') . "\n";
        echo "\n";
    }
}
