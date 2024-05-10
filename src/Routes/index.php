<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Router;
use App\Database;

try {
    $db = Database::getInstance("127.0.0.1", "8889", "root", "root", "book_store");
} catch (\Throwable $th) {
    throw $th;
}

$router = new Router();
$router->get('/', HomeController::class, 'index');
$router->post('/users', UserController::class, 'index');
$router->put('/users', UserController::class, 'update');
$router->get('/users/delete', UserController::class, 'destroy');

$router->dispatch();
