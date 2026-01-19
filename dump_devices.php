<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ManagedDevice;

$devices = ManagedDevice::all(['device_id', 'is_active', 'registration_code', 'device_name']);
echo json_encode($devices, JSON_PRETTY_PRINT);
