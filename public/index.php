<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Onderhoudsmodus check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap de app
/** @var \Illuminate\Foundation\Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Resolve de HTTP-kernel en verwerk de request
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

// Zend de response naar de browser
$response->send();

// Voer eventuele terminate-middleware af
$kernel->terminate($request, $response);

