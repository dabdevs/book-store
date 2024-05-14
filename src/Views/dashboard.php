<?php

if (!isset($_SESSION["user"])) header("Location:/");

$user = $_SESSION["user"];

if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];
    $oldInputs = $_SESSION['oldInputs'];
    unset($_SESSION["errors"], $_SESSION['oldInputs']);
} else {
    $errors = null;
    $oldInputs = [];
}

if (isset($_SESSION["success"])) {
    $success = $_SESSION["success"];
    unset($_SESSION["success"]);
} else {
    $success = null;
} 
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
        if ($page === "Members") include "members.php";
        if ($page === "Books") include "books.php";
        if ($page === "Create Book") include "forms/book.php";
        if ($page === "Loans") include "loans.php";
        ?>
        <!-- End content -->
    </div>
</main>

<?php include_once "scripts.inc.html" ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast-alert" class="toast align-items-center text-bg-success text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= $success ?? "" ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php 
    if (isset($success)) { ?>
        <script>
            const toastAlert = document.getElementById('toast-alert')
            const toast = new bootstrap.Toast(toastAlert)

            toast.show()
        </script>
<?php } ?>