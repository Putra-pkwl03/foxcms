<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ManagedDevice;

$deviceId = 'A22C4111FD74304E';

$device = ManagedDevice::where('device_id', $deviceId)->first();

if ($device) {
    echo "=== DEBUG DEVICE INFO ===\n";
    echo "Device ID: {$device->device_id}\n";
    echo "Registration Code: {$device->registration_code}\n";
    echo "Room: {$device->room_number}\n";
    echo "\n--- is_active Analysis ---\n";
    echo "Raw value: " . var_export($device->is_active, true) . "\n";
    echo "Type: " . gettype($device->is_active) . "\n";
    echo "Boolean cast: " . var_export((bool)$device->is_active, true) . "\n";
    echo "Strict comparison (=== true): " . var_export($device->is_active === true, true) . "\n";
    echo "Strict comparison (=== 1): " . var_export($device->is_active === 1, true) . "\n";
    echo "Loose comparison (== true): " . var_export($device->is_active == true, true) . "\n";
    
    echo "\n--- What API will return ---\n";
    echo "is_registered: " . var_export((bool)$device->is_active, true) . "\n";
    
    echo "\n--- Raw Attributes ---\n";
    print_r($device->getAttributes());
} else {
    echo "✗ Device not found: $deviceId\n";
}
