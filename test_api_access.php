<?php
// Test API endpoint accessibility
$baseUrl = 'http://192.168.100.191:8000';
$deviceId = 'D0D61B808EE3AE23';

echo "=== Testing API Endpoints ===\n\n";

// Test 1: Check Registration
echo "1. Testing checkRegistration...\n";
$url = "$baseUrl/api/launcher?action=checkRegistration&device_id=$deviceId";
echo "   URL: $url\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Code: $httpCode\n";
echo "   Response: " . substr($response, 0, 200) . "\n";

if ($httpCode == 200) {
    $data = json_decode($response, true);
    if ($data) {
        echo "   ✓ Parsed JSON:\n";
        echo "     - status: " . ($data['status'] ?? 'N/A') . "\n";
        echo "     - is_registered: " . var_export($data['is_registered'] ?? null, true) . "\n";
        echo "     - registration_code: " . ($data['registration_code'] ?? 'N/A') . "\n";
    }
} else {
    echo "   ✗ FAILED! HTTP $httpCode\n";
    if ($httpCode == 401 || $httpCode == 403) {
        echo "   ⚠ Authentication/Authorization required!\n";
    }
}

echo "\n";

// Test 2: Get Status
echo "2. Testing getStatus...\n";
$url = "$baseUrl/api/launcher?action=getStatus";
echo "   URL: $url\n";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Code: $httpCode\n";
echo "   Response: " . substr($response, 0, 200) . "\n\n";

// Test 3: From device IP
echo "3. Testing from device IP (192.168.100.206)...\n";
echo "   Simulating request from device...\n";

$url = "$baseUrl/api/launcher?action=checkRegistration&device_id=$deviceId";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'X-Forwarded-For: 192.168.100.206',
    'User-Agent: Dalvik/2.1.0 (Linux; U; Android 9; B866V2FA Build/PI)'
]);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "   HTTP Code: $httpCode\n";
echo "   Response: " . substr($response, 0, 200) . "\n";

if ($httpCode != 200) {
    echo "\n⚠ WARNING: API is not accessible!\n";
    echo "Possible causes:\n";
    echo "1. Authentication middleware blocking requests\n";
    echo "2. CORS issues\n";
    echo "3. Server configuration\n";
} else {
    echo "\n✓ API is accessible!\n";
}
