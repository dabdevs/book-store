<?php

require '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__ . "../"));
$dotenv->load();

require '../src/Routes/index.php';
