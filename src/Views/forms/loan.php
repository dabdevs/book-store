<?php
$id = '';
$book_id = '';
$user_id = '';
$today = date('Y-m-d h:i:s');
$tm = strtotime("tomorrow");
$tomorrow = date("Y-m-d h:i:s", $tm);

if ($page === 'Create Loan') {
    $borrow_date = $today;
    $borrow_date_readonly = true;
} else {
    $borrow_date = '';
    $borrow_date_readonly = false;
}

$return_date = '';
$status = '';

if (isset($loan)) {
    $id = $loan->id;
    $book_id = $loan->book_id;
    $user_id = $loan->user_id;
    $borrow_date = $loan->borrow_date;
    $return_date = $loan->return_date;
    $status = $loan->status;
}

if (isset($oldInputs["book_id"])) {
    $book_id = $oldInputs["book_id"];
    $user_id = $oldInputs["user_id"];
    $borrow_date = $oldInputs["borrow_date"];
    $return_date = $oldInputs["return_date"];
    $status = $oldInputs["status"];
}

?>

<div class="card p-3 my-5">
    <form action="/loans<?= isset($loan) ? '/update' : '' ?>" method="POST" enctype="multipart/form-data">
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
                        foreach ($users as $user) {
                        ?>
                            <option value="<?= $user->id ?>" <?= $user_id === $user->id ? "selected" : ''; ?>> <?= $user->firstname ?> <?= $user->lastname ?> </option>
                        <?php
                        }
                        ?>
                    </select>
                    <small class="text-danger"><?= $errors["user_id"] ?? '' ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2">
                    <label for="borrow_date" class="form-label m-0">Borrow Date</label>
                    <input <?= $borrow_date_readonly ? 'readonly' : '' ?> type="datetime-local" min="<?= $today ?>" class="form-control border field" value="<?= $borrow_date ?>" name="borrow_date" id="borrow_date">
                    <small class="text-danger"><?= $errors["borrow_date"] ?? '' ?></small>
                </div>
                <div class="col-sm-2">
                    <label for="return_date" class="form-label m-0">Return Date</label>
                    <input type="datetime-local" class="form-control border field" value="<?= $return_date ?>" min="<?= $tomorrow ?>" name="return_date" id="return_date">
                    <small class="text-danger"><?= $errors["return_date"] ?? '' ?></small>
                </div>
                <div class="col-sm-3">
                    <label for="status" class="form-label m-0">Status</label>
                    <select class="form-control border field" name="status" id="status">
                        <option value="">Select</option>
                        <option value="BORROWED">Borrowed</option>
                        <option value="RETURNED">Returned</option>
                    </select>
                    <small class="text-danger"><?= $errors["status"] ?? '' ?></small>
                </div>
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