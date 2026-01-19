<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Direct DB query
$pdo = DB::connection()->getPdo();
$stmt = $pdo->prepare("SELECT * FROM managed_devices WHERE device_id = ?");
$stmt->execute(['A22C4111FD74304E']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "=== DIRECT DATABASE QUERY ===\n";
if ($row) {
    echo "device_id: {$row['device_id']}\n";
    echo "registration_code: {$row['registration_code']}\n";
    echo "is_active (raw): " . var_export($row['is_active'], true) . "\n";
    echo "is_active (type): " . gettype($row['is_active']) . "\n";
    echo "is_active (bool): " . var_export((bool)$row['is_active'], true) . "\n";
    echo "is_active === 1: " . var_export($row['is_active'] === 1, true) . "\n";
    echo "is_active == 1: " . var_export($row['is_active'] == 1, true) . "\n";
} else {
    echo "Device not found!\n";
}
