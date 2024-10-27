<?php
session_start();
define('BASE_PATH', __DIR__);
require_once 'Core/Application.php';
$app = new Application();
$router = $app->getRouter();

// Define routes
$router->get('/', [UserController::class, 'index']);
$router->get('/test', [UserController::class, 'test']);
$router->get('/create', [UserController::class, 'create']);
$router->post('/create', [UserController::class, 'create']);
$router->get('/update/{id}', [UserController::class, 'update']);
$router->post('/update/{id}', [UserController::class, 'update']);
$router->post('/{id}', [UserController::class, 'delete']);
$router->get('/{id}', [UserController::class, 'detail']);

$app->run();
