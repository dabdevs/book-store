<?php

use App\Controllers\BookController;
use App\Controllers\WebController;
use App\Controllers\UserController;
use App\Controllers\DashboardController;
use App\Controllers\LibrerianController;
use App\Controllers\MemberController;
use App\Controllers\LoanController;
use App\Router;

$router = new Router();
$router->get("/", WebController::class, "login");

// User routes
$router->post("/login", UserController::class, "login");
$router->post("/logout", UserController::class, "logout");
$router->get("/users", UserController::class, "index");
$router->post("/users", UserController::class, "store");
$router->put("/users", UserController::class, "update");
$router->delete("/users", UserController::class, "destroy");

// Member routes
$router->get("/members", MemberController::class, "index", "admin");
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
$router->get("/profile", UserController::class, "profile", "admin");
$router->post("/profile", UserController::class, "updateProfile");

// Dashboard routes
$router->get("/dashboard", DashboardController::class, "index");

// Forbidden route
$router->get("/forbidden", WebController::class, "forbidden");

// Not found route
$router->get("/not-found", WebController::class, "notFound");

$router->dispatch();
