<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Api\LauncherController;

$request = Request::create('/api/v1/apps', 'GET', [
    'lang' => 'id'
]);

$controller = new LauncherController();
$response = $controller->getAppVisibility($request);

echo $response->getContent();
