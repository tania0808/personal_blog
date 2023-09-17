<?php

require_once __DIR__ . '/../vendor/autoload.php';
use app\core\Application;
use app\controllers\SiteController;

$app = new Application(dirname(__DIR__));


$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handleContact']);

// auth
$app->router->get('/login', [SiteController::class, 'login']);
$app->router->get('/register', [SiteController::class, 'register']);

$app->run();