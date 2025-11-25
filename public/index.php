<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check if the application is in maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap the Laravel application
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

/** @var \Illuminate\Contracts\Http\Kernel $kernel */
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Handle the incoming request
$request = Request::capture();
$response = $kernel->handle($request); // THIS MUST RUN

// Send the response to the browser
$response->send(); // THIS MUST RUN

// Terminate the kernel (run termination middleware)
$kernel->terminate($request, $response); // THIS MUST RUN
