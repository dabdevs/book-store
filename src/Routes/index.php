<?php

use App\Controllers\BookController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\LibrerianController;
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
$router->post("/members", MemberController::class, "store");
$router->get("/members/create", MemberController::class, "create");
$router->get("/members/edit", MemberController::class, "edit");
$router->post("/members/update", MemberController::class, "update");
$router->post("/members/delete", MemberController::class, "destroy");

// Librerian routes
$router->get("/librerians", LibrerianController::class, "index");
$router->post("/librerians", LibrerianController::class, "store");
$router->get("/librerians/create", LibrerianController::class, "create");
$router->get("/librerians/edit", LibrerianController::class, "edit");
$router->post("/librerians/update", LibrerianController::class, "update");
$router->post("/librerians/delete", LibrerianController::class, "destroy");

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

// Profile routes
$router->get("/profile", UserController::class, "profile");
$router->post("/profile", UserController::class, "updateProfile");

// Dashboard routes
$router->get("/dashboard", DashboardController::class, "index");


// Not found route
$router->get("/not-found", HomeController::class, "not_found");

$router->dispatch();
