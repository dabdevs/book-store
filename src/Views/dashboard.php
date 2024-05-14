<?php

if (!isset($_SESSION['user'])) header("Location:/");

$user = $_SESSION['user'];

?>

<?php include_once "head.inc.html" ?>

<?php include_once "dashboard/sidebar.inc.php" ?>

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php include_once "dashboard/navbar.inc.php" ?>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
        <!-- Cards -->
        <?php include_once "dashboard/cards.inc.php" ?>
        <!-- End Cards -->

        <!-- Content -->
        <?php 
            if (isset($members)) include "members.php";
            if (isset($books)) include "books.php";
            if (isset($transactions)) include "loans.php";

        ?>
        <!-- End content -->
    </div>
</main>
<?php include_once "scripts.inc.html" ?>