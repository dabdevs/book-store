<?php
$id = '';
$book_id = '';
$user_id = '';
$borrow_date = '';
$return_date = $tomorrow;
$status = '';

if (isset($loan)) {
    $id = $loan->getId(); 
    $book_id = $loan->getBook()->getId();
    $user_id = $loan->getUser()->id;
    $borrow_date = $loan->getBorrowDate();
    $return_date = $loan->getReturnDate();
    $status = $loan->getStatus();
}

if (isset($oldInputs["book_id"])) {
    $book_id = $oldInputs["book_id"];
    $user_id = $oldInputs["user_id"];
    $return_date = $oldInputs["return_date"];
    $status = isset($oldInputs["status"]) ? $oldInputs["status"] : '';
}

?>

<div class="card p-3 my-5">
    <form action="/loans<?= isset($loan) ? '/update' : '' ?>" method="POST">
        <div>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="book_id" class="form-label m-0">Book</label>
                    <select class="form-control border field" name="book_id" id="book_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($books as $book) {
                        ?>
                            <option value="<?= $book->id ?>" <?= $book_id === $book->id ? "selected" : ''; ?>> <?= $book->title ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <small class="text-danger"><?= $errors["book_id"] ?? '' ?></small>
                </div>
                <div class="col-sm-6">
                    <label for="user_id" class="form-label m-0">User</label>
                    <select class="form-control border field" name="user_id" id="user_id">
                        <option value="">Select</option>
                        <?php
                        foreach ($members as $member) {
                        ?>
                            <option value="<?= $member->id ?>" <?= $user_id == $member->id ? "selected" : ''; ?>> <?= $member->firstname ?> <?= $member->lastname ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <small class="text-danger"><?= $errors["user_id"] ?? '' ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <?php if ($page === "Edit Loan") { ?>
                    <div class="col-sm-2">
                        <label for="borrow_date" class="form-label m-0">Borrow Date</label>
                        <input type="datetime-local" class="form-control border field" value="<?= date('Y-m-d h:i:s', strtotime($borrow_date)) ?>" name="borrow_date" id="borrow_date" disabled>
                    </div>
                <?php } ?>

                <div class="col-sm-2">
                    <label for="return_date" class="form-label m-0">Return Date</label>
                    <input <?= $status === "RETURNED" ? 'disabled' : '' ?> type="datetime-local" class="form-control border field" value="<?= date('Y-m-d h:i:s', strtotime($return_date)) ?>" min="<?= $page === "Create Loan" ? $tomorrow : $today ?>" name="return_date" id="return_date">
                    <small class="text-danger"><?= $errors["return_date"] ?? '' ?></small>
                </div>

                <?php if ($page === "Edit Loan") { ?>
                    <div class="col-sm-3">
                        <label for="status" class="form-label m-0">Status</label>
                        <select class="form-control border field" name="status" id="status" <?= $status === "RETURNED" ? 'disabled' : '' ?>>
                            <option value="">Select</option>
                            <option value="BORROWED" <?= $status === "BORROWED" ? "selected" : "" ?>>Borrowed</option>
                            <option value="RETURNED" <?= $status === "RETURNED" ? "selected" : "" ?>>Returned</option>
                        </select>
                        <small class="text-danger"><?= $errors["status"] ?? '' ?></small>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="modal-footer">
            <a href="/loans" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submit-btn">
                <i class="material-icons opacity-10 text-white">save</i>
                Save
            </button>
        </div>
    </form>
</div>