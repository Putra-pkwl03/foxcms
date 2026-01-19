<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Simulate HTTP request
$request = Illuminate\Http\Request::create(
    '/api/launcher?action=checkRegistration&device_id=A22C4111FD74304E',
    'GET'
);

$response = $kernel->handle($request);

echo "=== API Response Test ===\n\n";
echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Content:\n";
echo $response->getContent() . "\n\n";

$data = json_decode($response->getContent(), true);
if ($data) {
    echo "Parsed Data:\n";
    echo "  - status: " . ($data['status'] ?? 'N/A') . "\n";
    echo "  - is_registered: " . var_export($data['is_registered'] ?? null, true) . "\n";
    echo "  - registration_code: " . ($data['registration_code'] ?? 'N/A') . "\n";
}

$kernel->terminate($request, $response);
