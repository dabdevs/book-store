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

if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);
} else {
    $error = null;
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
        // Book pages
        if ($page === "Books") include "books.php";
        if ($page === "Create Book" || $page === "Edit Book") include "forms/book.php";

        // Loan pages
        if ($page === "Loans") include "loans.php";
        if ($page === "Create Loan" || $page === "Edit Loan") include "forms/loan.php";

        // Member pages
        if ($page === "Members") include "members.php";
        if ($page === "Create Member" || $page === "Edit Member") include "forms/user.php";

        ?>
        <!-- End content -->
    </div>
</main>

<?php include_once "scripts.inc.html" ?>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast-alert" class="toast align-items-center text-bg-<?= $success ? 'success' : ($error ? 'danger' : '') ?> text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toast-body">
                <?= $success ?? "" ?>
                <?= $error ?? "" ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


<!-- Modal -->
<form class="modal fade" id="delete-form" method="POST" tabindex="-1" role="dialog" aria-labelledby="delete-form" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal" id="delete-form">Delete <b id="item-title"></b></h5>
                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="delete-id">
                Are you sure you want to continue?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn bg-gradient-primary">Confirm Delete</button>
            </div>
        </div>
    </div>
</form>



<?php
if (isset($success) || isset($error)) { ?>
    <script>
        const toastAlert = document.getElementById('toast-alert')
        const toast = new bootstrap.Toast(toastAlert)

        toast.show()
    </script>
<?php } ?>