<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SystemApp;

// Check if apps already exist
$count = SystemApp::count();
if ($count > 0) {
    echo "✓ SystemApp already has $count records. Skipping seed.\n";
    exit(0);
}

// Default apps for hotel STB
$defaultApps = [
    [
        'app_key' => 'youtube',
        'app_name' => 'YouTube',
        'app_name_en' => 'YouTube',
        'icon_path' => 'img/apps/youtube.png',
        'android_package' => 'com.google.android.youtube.tv',
        'apk_url' => null,
        'is_visible' => true,
        'sort_order' => 1
    ],
    [
        'app_key' => 'netflix',
        'app_name' => 'Netflix',
        'app_name_en' => 'Netflix',
        'icon_path' => 'img/apps/netflix.png',
        'android_package' => 'com.netflix.ninja',
        'apk_url' => null,
        'is_visible' => true,
        'sort_order' => 2
    ],
    [
        'app_key' => 'chrome',
        'app_name' => 'Browser',
        'app_name_en' => 'Browser',
        'icon_path' => 'img/apps/chrome.png',
        'android_package' => 'com.android.chrome',
        'apk_url' => null,
        'is_visible' => true,
        'sort_order' => 3
    ],
];

foreach ($defaultApps as $appData) {
    SystemApp::create($appData);
    echo "✓ Created app: {$appData['app_name']}\n";
}

echo "\n✅ Successfully seeded " . count($defaultApps) . " apps!\n";
