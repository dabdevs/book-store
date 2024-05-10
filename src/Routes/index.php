<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Router;
use App\Database;

try {
    // Connect to the database
    Database::getInstance($_ENV["DB_HOST"], $_ENV["DB_PORT"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_NAME"]);
} catch (\Throwable $th) {
    throw $th;
}

$router = new Router();
$router->get('/', HomeController::class, 'login');

// User routes
$router->get('/users', UserController::class, 'index');
$router->post('/users', UserController::class, 'store');
$router->put('/users', UserController::class, 'update');
$router->delete('/users', UserController::class, 'destroy');

// Not found route
$router->get('/not-found', HomeController::class, 'not_found');

$router->dispatch();
