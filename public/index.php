<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\SiteController;
use App\Controllers\PostController;
use App\Core\Application;
use App\Models\User;

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

// Post page
$app->router->get('/posts', [PostController::class, 'index']);
$app->router->get('/post/create', [PostController::class, 'store']);
$app->router->post('/post/create', [PostController::class, 'store']);
$app->router->get('/posts/{id}', [PostController::class, 'show']);
$app->router->get('/posts/edit/{id}/', [PostController::class, 'edit']);
$app->router->post('/posts/edit/{id}/', [PostController::class, 'edit']);
$app->router->get('/posts/delete/{id}/', [PostController::class, 'delete']);

// Comment
$app->router->post('/posts/{id}', [PostController::class, 'addComment']);
$app->router->get('/posts/{postId}/comments/delete/{id}', [PostController::class, 'deleteComment']);

// Admin posts
$app->router->get('/admin/posts', [AdminController::class, 'index']);
$app->router->get('/admin/posts/approve/{id}', [AdminController::class, 'approvePost']);
$app->router->get('/admin/posts/disapprove/{id}', [AdminController::class, 'disapprovePost']);
$app->router->get('/admin/posts/delete/{id}', [AdminController::class, 'deletePost']);

// Admin comments
$app->router->get('/admin/comments', [AdminController::class, 'showComments']);
$app->router->get('/admin/comments/approve/{id}', [AdminController::class, 'approveComment']);
$app->router->get('/admin/comments/disapprove/{id}', [AdminController::class, 'disapproveComment']);
$app->router->get('/admin/comments/delete/{id}', [AdminController::class, 'deleteComment']);

$app->run();
