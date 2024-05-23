<?php

use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\MemberController;
use App\Controllers\LoanController;
use App\Router;

$router = new Router();
$router->get("/", HomeController::class, "login");

// User routes
$router->post("/login", UserController::class, "login");
$router->post("/logout", UserController::class, "logout");
$router->get("/users", UserController::class, "index");
$router->post("/users", UserController::class, "store");
$router->put("/users", UserController::class, "update");
$router->delete("/users", UserController::class, "destroy");

// Member routes
$router->get("/members", MemberController::class, "index");

// Book routes
$router->get("/books", BookController::class, "index");
$router->post("/books", BookController::class, "store");
$router->get("/books/create", BookController::class, "create");
$router->get("/books/edit", BookController::class, "edit");
$router->post("/books/update", BookController::class, "update");
$router->post("/books/delete", BookController::class, "destroy");

// Loan routes
$router->get("/loans", LoanController::class, "index");
$router->post("/loans", LoanController::class, "store");
$router->get("/loans/create", LoanController::class, "create");
$router->get("/loans/edit", LoanController::class, "edit");
$router->post("/loans/update", LoanController::class, "update");
$router->post("/loans/delete", LoanController::class, "destroy");

// Dashboard routes
$router->get("/dashboard", DashboardController::class, "index");

// Not found route
$router->get("/not-found", HomeController::class, "not_found");

$router->dispatch();
