<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Clear Specific Device ===\n\n";

// Ganti dengan Device ID yang ingin dihapus
$deviceIdToDelete = 'A22C4111FD74304E'; // Device lama

$device = \App\Models\ManagedDevice::where('device_id', $deviceIdToDelete)->first();

if ($device) {
    echo "Found device:\n";
    echo "  - Device ID: " . $device->device_id . "\n";
    echo "  - Device Name: " . $device->device_name . "\n";
    echo "  - Room: " . $device->room_number . "\n";
    echo "  - Active: " . ($device->is_active ? 'Yes' : 'No') . "\n\n";
    
    // Uncomment baris di bawah untuk benar-benar menghapus
    // $device->delete();
    // echo "✓ Device deleted!\n";
    
    echo "⚠ Device NOT deleted (uncomment line to delete)\n";
} else {
    echo "✗ Device not found: $deviceIdToDelete\n";
}

echo "\n=== All Devices in Database ===\n";
\App\Models\ManagedDevice::all()->each(function($d) {
    echo "- " . $d->device_id . " | " . $d->device_name . " | Active: " . ($d->is_active ? 'Yes' : 'No') . "\n";
});
