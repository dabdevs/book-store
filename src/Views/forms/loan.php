<?php
$id = '';
$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : '';
$member_id = '';
$member = '';
$borrow_date = '';
$due_date = '';
$status = '';

if (isset($loan)) {
    $id = $loan->getId();
    $book_id = $loan->getBook()->getId();
    $book_title = $loan->getBook()->getTitle();
    $member_id = $loan->getMember()->getId();
    $member = $loan->getMember()->getFirstname() . " " . $loan->getMember()->getLastname();
    $borrow_date = $loan->getBorrowDate();
    $due_date = $loan->getDueDate();
    $return_date = $loan->getReturnDate();
    $status = $loan->getStatus();
    $creator = $loan->getCreator()->getFirstname() . " " . $loan->getCreator()->getLastname();
    $date_created = $loan->getDateCreated();
    $date_updated = $loan->getLastUpdated();
}

if (isset($oldInputs["book_id"])) {
    $book_id = $oldInputs["book_id"];
    $member_id = $oldInputs["member_id"];
    $due_date = $oldInputs["due_date"];
    $status = isset($oldInputs["status"]) ? $oldInputs["status"] : '';
}

$show_form = empty($id) || isset($_GET["book_id"]) ? "" : "d-none";
?>

<div class="card p-3 my-5">
    <?php if (!empty($id)) { ?>
        <a class="btn btn-sm btn-primary position-absolute end-1 top-1" onclick="editForm()">
            <i class="material-icons opacity-10 fs-5">edit</i>
        </a>
    <?php } ?>

    <div class="row plain-value <?= $show_form === "" ? 'd-none' : '' ?> mt-3">
        <div class="col-sm-3">
            <p><b>Book: </b> <?= $book_title ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Member: </b> <?= $member ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Date Borrowed: </b><?= $borrow_date ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Due Date: </b><?= $due_date ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Return Date: </b><?= $return_date ?? 'N/A' ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Creator:</b> <?= $creator ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Date Created:</b> <?= $date_created ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Last Updated:</b> <?= $last_updated ?? 'N/A' ?></p>
        </div>
        <div class="modal-footer px-2">
            <a href="/loans" class="btn">Cancel</a>
        </div>
    </div>

    <form id="loan-form" class="form-value <?= $show_form ?>" action="/loans<?= isset($loan) ? '/update' : '' ?>" method="POST">
        <fieldset <?php if ($status === "RETURNED") echo 'disabled' ?>>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="book_id" class="form-label m-0">Book</label> <br>
                    <select <?php if ($status === "RETURNED") echo 'disabled' ?> style="width: 100%;" class="form-control border field select2" name="book_id" id="book_id" onchange="validateInput('book_id')">
                        <option value="">Select</option>
                        <?php
                        foreach ($books as $book) {
                        ?>
                            <option value="<?= $book->id ?>" <?= $book_id === $book->id ? "selected" : ''; ?>> <?= $book->title ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <small class="text-danger" id="book_id_error"><?= $errors["book_id"] ?? '' ?></small>
                </div>
                <div class="col-sm-6">
                    <label for="member-box" class="form-label m-0">Member</label> <br>
                    <div style="height: 42px;" class="input-group mb-0" id="member-box">
                        <input type="text" class="h-100 form-control border border-end-0 field" aria-describedby="search-member-btn" id="member" placeholder="Search by Document ID or email" value="<?= $member ?>">
                        <button class="btn btn-outline-primary" type="button" id="search-member-btn" onclick="getMember($('#member').val())"><?= empty($id) ? 'Search' : 'Clear' ?></button>
                    </div>
                    <small class="text-danger" id="member_error"><?= $errors["member_id"] ?? '' ?></small>
                    <input value="<?= $member_id ?>" type="hidden" id="member_id" name="member_id">
                </div>
            </div>
            <div class="row mb-3">
                <?php if ($page === "Show Loan") { ?>
                    <div class="col-sm-2">
                        <label for="borrow_date" class="form-label m-0">Borrow Date</label>
                        <input type="datetime-local" class="form-control border field" value="<?= date('Y-m-d h:i:s', strtotime($borrow_date)) ?>" name="borrow_date" id="borrow_date" disabled>
                    </div>
                <?php } ?>

                <div class="col-sm-2">
                    <label for="due_date" class="form-label m-0">Due Date</label>
                    <input type="datetime-local" class="form-control border field" value="<?= empty($due_date) ? '' : date('Y-m-d h:i:s', strtotime($due_date)) ?>" min="<?= empty($due_date) ? ($page === "Create Loan" ? $tomorrow : $today) : '' ?>" name="due_date" id="due_date">
                    <small class="text-danger" id="due_date_error"><?= $errors["due_date"] ?? '' ?></small>
                </div>
                <?php if ($page === "Show Loan") { ?>
                    <div class="col-sm-3">
                        <label for="status" class="form-label m-0">Status</label>
                        <select class="form-control border field" name="status" id="status">
                            <option value="">Select</option>
                            <option value="BORROWED" <?= $status === "BORROWED" ? "selected" : "" ?>>Borrowed</option>
                            <option value="RETURNED" <?= $status === "RETURNED" ? "selected" : "" ?>>Returned</option>
                        </select>
                        <small class="text-danger"><?= $errors["status"] ?? '' ?></small>
                    </div>
                <?php } ?>
            </div>
        </fieldset>
        <div class="modal-footer">
            <a href="/loans" class="btn">Cancel</a>
            <?php if ($status !== "RETURNED") { ?>
                <button type="button" value="save" class="btn btn-primary" id="submit-btn" onclick="validateLoanForm()">
                    <i class="material-icons opacity-10 text-white">save</i>
                    Save
                </button>
            <?php } ?>
        </div>
    </form>
</div>