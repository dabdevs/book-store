<?php
function timeElapsed($datetime)
{
    $now = new DateTime();
    $then = new DateTime($datetime);
    $diff = $now->diff($then);

    if ($diff->y > 0) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    } elseif ($diff->m > 0) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    } elseif ($diff->d > 0) {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    } elseif ($diff->h > 0) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    } elseif ($diff->i > 0) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'just now';
    }
}

$td = strtotime("today");
$today = date("Y-m-d h:i:s", $td);
$tm = strtotime("tomorrow");
$tomorrow = date("Y-m-d h:i:s", $tm);

if (!isset($_SESSION["user"])) header("Location:/");

$authUser = (object)$_SESSION["user"];

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
        <?php if ($page !== "Profile") include_once "dashboard/cards.inc.php" ?>
        <!-- End Cards -->

        <!-- Content -->
        <?php if ($page === "Dashboard") { ?>
            <div class="row">
                <div class="col-md-7">
                    <div class="card my-4">
                        <div class="card-header pb-0 px-3">
                            <h6 class="mb-0">Top Books</h6>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                <?php if (!empty($topBooks)) {
                                    foreach ($topBooks as $book) { ?>
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm"><?= $book->title ?></h6>
                                                <span class="mb-2 text-xs">Description: <span class="text-dark font-weight-bold ms-sm-2"><?= $book->description ? $book->description : 'N/A' ?></span></span>
                                                <span class="mb-2 text-xs">Genre: <span class="text-dark ms-sm-2 font-weight-bold"><?= $book->genre ?></span></span>
                                                <span class="text-xs">Loans: <span class="text-dark ms-sm-2 font-weight-bold"><?= $book->loan_count ?></span></span>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card my-4">
                        <div class="card-header pb-0 px-3">
                            <h6 class="mb-0">Top Lenders</h6>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                <?php if (!empty($topMembers)) {
                                    foreach ($topMembers as $member) { ?>
                                        <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-3 text-sm"><?= $member->firstname ?> <?= $member->lastname ?></h6>
                                                <span class="mb-2 text-xs">Email: <span class="text-dark font-weight-bold ms-sm-2"><?= $member->email ?></span></span>
                                                <span class="mb-2 text-xs">City: <span class="text-dark ms-sm-2 font-weight-bold"><?= $member->city ?? 'N/A' ?></span></span>
                                                <span class="text-xs">Loans: <span class="text-dark ms-sm-2 font-weight-bold"><?= $member->loans ?></span></span>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-4" style="max-height: 550px">
                    <div class="card h-100 mb-4">
                        <div class="card-header pb-0 px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-0">Activity</h6>
                                </div>
                                <div class="col-md-6 d-flex justify-content-start justify-content-md-end align-items-center">
                                    <i class="material-icons me-2 text-lg">date_range</i>
                                    <small><?= date('M d') . "th, " . date('Y') ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4 p-3">
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Latest Loans</h6>
                            <ul class="list-group">
                                <?php if (!empty($latestLoans)) {
                                    foreach ($latestLoans as $loan) { ?>
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_more</i></button>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm"><?= $loan->title ?></h6>
                                                    <span class="text-xs">By <?= $loan->firstname ?> <?= $loan->lastname ?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                                <?= timeElapsed($loan->borrow_date) ?>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                            <h6 class="text-uppercase text-body text-xs font-weight-bolder my-3">Latest Returns</h6>
                            <ul class="list-group">
                                <?php if (!empty($latestReturns)) {
                                    foreach ($latestReturns as $loan) { ?>
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 p-3 btn-sm d-flex align-items-center justify-content-center"><i class="material-icons text-lg">expand_less</i></button>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm"><?= $loan->title ?></h6>
                                                    <span class="text-xs">By <?= $loan->firstname ?> <?= $loan->lastname ?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                                                <?= timeElapsed($loan->return_date) ?>
                                            </div>
                                        </li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- End Content -->
        <?php
        include_once "scripts.inc.html";

        // Book pages
        if ($page === "Books") include "books.php";
        if ($page === "Create Book" || $page === "Edit Book") include "forms/book.php";

        // Loan pages
        if ($page === "Loans") include "loans.php";
        if ($page === "Create Loan" || $page === "Edit Loan") include "forms/loan.php";

        // Member pages
        if ($page === "Members") include "members.php";
        if ($page === "Create Member" || $page === "Edit Member") include "forms/user.php";

        // Librerian pages
        if ($page === "Librerians") include "librerians.php";
        if ($page === "Create Librerian" || $page === "Edit Librerian") include "forms/user.php";

        // Profile page
        if ($page === "Profile") include "profile.php";
        ?>
        <!-- End content -->
    </div>
</main>

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
                <button type="button" class="btn" data-bs-dismiss="modal">Cancel</button>
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