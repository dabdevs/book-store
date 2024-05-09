<?php

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');
$router->get('/users', UserController::class, 'index');

$router->dispatch();
