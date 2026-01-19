<?php

$url = "http://192.168.100.191:8000/api/v1/apps";

$response = file_get_contents($url);
$data = json_decode($response, true);

echo "=== API /apps TEST ===\n";
echo "Status: " . $data['status'] . "\n";
echo "Apps count: " . count($data['apps']) . "\n\n";

if (!empty($data['apps'])) {
    echo "First app sample:\n";
    $firstApp = $data['apps'][0];
    foreach ($firstApp as $key => $value) {
        $type = gettype($value);
        $valueStr = is_bool($value) ? ($value ? 'true' : 'false') : $value;
        echo "  $key: [$valueStr] (type: $type)\n";
    }
    
    echo "\n";
    if (is_bool($firstApp['is_visible'])) {
        echo "✅ is_visible is BOOLEAN - Android will accept this!\n";
    } else {
        echo "❌ is_visible is " . gettype($firstApp['is_visible']) . " - Android will reject this!\n";
    }
}
