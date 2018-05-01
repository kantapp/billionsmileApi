<?php
if (PHP_SAPI == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

use Slim\Http\Request;
use Slim\Http\Response;
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../DB/dbcon.php';
session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';



$app->get('/',function(Request $request,Response $response){
    echo "Hello";
});

// Run app
$app->run();
