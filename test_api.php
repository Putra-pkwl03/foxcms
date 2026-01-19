<?php

$url = "http://192.168.100.191:8000/api/v1/check-registration?device_id=A22C4111FD74304E";

$response = file_get_contents($url);
$data = json_decode($response, true);

echo "=== API TEST RESULT ===\n";
echo "URL: $url\n\n";
echo "Raw Response:\n";
echo $response . "\n\n";

echo "Parsed Data:\n";
echo "status: " . $data['status'] . "\n";
echo "is_registered: " . var_export($data['is_registered'], true) . "\n";
echo "registration_code: " . $data['registration_code'] . "\n";

if ($data['is_registered'] === true) {
    echo "\n✅ API RETURNS TRUE - Device is ACTIVE!\n";
} else {
    echo "\n❌ API RETURNS FALSE - Device is NOT ACTIVE!\n";
}
