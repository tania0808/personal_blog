<?php

use App\Controllers\AuthController;
use App\Controllers\SiteController;
use App\Controllers\PostController;
use App\Core\Application;
use App\Models\User;
use App\Repositories\PostRepository;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();


$config = [
    'userClass' => User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'contact']);

// auth
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/logout', [AuthController::class, 'logout']);

// Profile page
$app->router->get('/profile', [AuthController::class, 'profile']);


// Post page
$app->router->get('/posts', [PostController::class, 'index']);
$app->router->get('/post/create', [PostController::class, 'store']);
$app->router->post('/post/create', [PostController::class, 'store']);

$app->run();