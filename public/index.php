<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// display_errors = on

define('EOL', '<br />');

// throw new Exception('Exception message');
// echo "hallo fabian";

require_once __DIR__ . '/../vendor/autoload.php';

use protonx\basemvc\core\Application;
use protonx\basemvc\controllers\SiteController;
use protonx\basemvc\controllers\AuthController;

$rootPath = dirname(__DIR__);
$app = new Application($rootPath);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);

// TODO: Als POST implementieren
$app->router->get('/logout', [AuthController::class, 'logout']);

$app->router->get('/profile', [AuthController::class, 'profile']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

/*

$app->router->get('/contact', 'contact');

$app->router->post('/contact', function() {
     return 'Hello Contact POST';
 });

$app->router->get('/', 'home');
$app->router->get('/', function() {
    return 'Hello World';
});

*/

$app->run();