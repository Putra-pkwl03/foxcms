<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Api\LauncherController;

$request = Request::create('/api/v1/check-registration', 'GET', [
    'device_id' => '10DA6152D41CEBEF',
    'device_name' => 'B866V2FA'
]);

$controller = new LauncherController();
$response = $controller->checkRegistration($request);

echo $response->getContent();
