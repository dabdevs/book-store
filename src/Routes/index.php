<?php

use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\MemberController;
use App\Controllers\LoanController;
use App\Router;

$router = new Router();
$router->get('/', HomeController::class, 'login');

// User routes
$router->post('/login', UserController::class, 'login');
$router->get('/users', UserController::class, 'index');
$router->post('/users', UserController::class, 'store');
$router->put('/users', UserController::class, 'update');
$router->delete('/users', UserController::class, 'destroy');

// Member routes
$router->get('/members', MemberController::class, 'index');

// Book routes
$router->get('/books', BookController::class, 'index');

// Loan routes
$router->get('/loans', LoanController::class, 'index');

// Dashboard routes
$router->get('/dashboard', DashboardController::class, 'index');

// Not found route
$router->get('/not-found', HomeController::class, 'not_found');

$router->dispatch();
