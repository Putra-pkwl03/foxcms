<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Checking for New Device ===\n\n";

$newDeviceId = 'D0D61B808EE3AE23';

$device = \App\Models\ManagedDevice::where('device_id', $newDeviceId)->first();

if ($device) {
    echo "✓ Device FOUND in database!\n\n";
    echo "Device ID: " . $device->device_id . "\n";
    echo "Device Name: " . $device->device_name . "\n";
    echo "Registration Code: " . $device->registration_code . "\n";
    echo "Room Number: " . $device->room_number . "\n";
    echo "is_active: " . ($device->is_active ? 'TRUE (Active)' : 'FALSE (Inactive)') . "\n";
    echo "IP Address: " . ($device->ip_address ?? 'N/A') . "\n";
    echo "Last Seen: " . ($device->last_seen ? $device->last_seen->format('Y-m-d H:i:s') : 'Never') . "\n";
    echo "Registered At: " . ($device->registered_at ? $device->registered_at->format('Y-m-d H:i:s') : 'Not registered') . "\n";
    
    if (!$device->is_active) {
        echo "\n⚠ WARNING: Device is NOT ACTIVE!\n";
        echo "To activate, run:\n";
        echo "  php artisan tinker --execute=\"\\\$d = \\App\\Models\\ManagedDevice::where('device_id', '$newDeviceId')->first(); \\\$d->is_active = true; \\\$d->registered_at = now(); \\\$d->save(); echo 'Device activated!';\"\n";
    } else {
        echo "\n✓ Device is ACTIVE and ready!\n";
    }
} else {
    echo "✗ Device NOT found in database yet.\n";
    echo "The device should auto-register when it calls checkRegistration API.\n";
    echo "Wait a few seconds and run this script again.\n";
}

echo "\n=== All Devices ===\n";
\App\Models\ManagedDevice::orderBy('created_at', 'desc')->take(5)->get()->each(function($d) {
    echo "- " . $d->device_id . " | " . $d->device_name . " | Active: " . ($d->is_active ? 'Yes' : 'No') . " | Last: " . ($d->last_seen ? $d->last_seen->diffForHumans() : 'Never') . "\n";
});
