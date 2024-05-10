<?php 
session_start();

if (!isset($_SESSION['user'])) header("Location:/");

$user = $_SESSION['user'];

echo "welcome to your dashboard $user[f_name]";

?>