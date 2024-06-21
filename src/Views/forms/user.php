<?php

if (isset($member)) {
    $user = $member;
} elseif (isset($librerian)) {
    $user = $librerian;
} elseif (isset($admin)) {
    $user = $admin;
}

$id = "";
$firstname = "";
$lastname = "";
$td = strtotime("today");
$today = date("Y-m-d h:i:s", $td);
$tm = strtotime("tomorrow");
$tomorrow = date("Y-m-d h:i:s", $tm);
$email = "";
$password = "";
$birth_date = "";
$avatar = "";
$document_id = "";
$phone = "";
$city = "";
$date_created = "";
$last_updated = "";

if (str_contains($page, "Member")) {
    $role = "MEMBER";
    $action = "members";
} elseif (str_contains($page, "Librerian")) {
    $role = "LIBRERIAN";
    $action = "librerians";
} elseif (str_contains($page, "Admin")) {
    $role = "ADMIN";
    $action = "admins";
}

if (isset($user)) {
    $id = $user->getId();
    $document_id = $user->getDocumentId();
    $firstname = $user->getFirstname();
    $lastname = $user->getLastname();
    $email = $user->getEmail();
    $birth_date = $user->getBirthdate();
    $role = $user->getRole();
    $phone = $user->getCellPhone() ?? "N/A";
    $city = $user->getCity() ?? "N/A";
    $avatar = $user->getAvatar() ?? "N/A";
    $date_created = $user->getDateCreated();
    $last_updated = $user->getLastUpdated() ?? "N/A";
}

if (isset($oldInputs["firstname"])) {
    $firstname = $oldInputs["firstname"];
    $lastname = $oldInputs["lastname"];
    $email = $oldInputs["email"];
    $password = $oldInputs["password"];
    $birth_date = $oldInputs["birth_date"];
    $avatar = isset($oldInputs["avatar"]) ? $oldInputs["avatar"] : '';
}

$show_form = empty($id) ? "" : "d-none";

if ($page === "Show Member") $path = "/members";
if ($page === "Show Librerian") $path = "/librerians";
?>

<div class="card p-3 my-5">
    <?php if (!empty($id)) { ?>
        <a class="btn btn-sm btn-primary position-absolute end-1 top-1" onclick="editForm()">
            <i class="material-icons opacity-10 fs-5">edit</i>
        </a>
    <?php } ?>

    <div class="row plain-value <?= $show_form === "" ? 'd-none' : '' ?> mt-3">
        <div class="col-sm-3">
            <p><b>Document ID: </b> <?= $document_id ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Firstname: </b> <?= $firstname ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Lastname: </b><?= $lastname ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Email: </b><?= $email ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Date of Birth: </b><?= $birth_date ?? 'N/A' ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Role:</b> <?= $role ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Phone:</b> <?= $phone ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>City:</b> <?= $city ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Date Created:</b> <?= $date_created ?></p>
        </div>
        <div class="col-sm-3">
            <p><b>Last Updated:</b> <?= $last_updated ?></p>
        </div>
        <div class="modal-footer px-2">
            <a href="<?= $path ?>" class="btn">Cancel</a>
        </div>
    </div>

    <form class="form-value <?= $show_form ?>" action="/<?= $action ?><?= isset($user) ? '/update' : '' ?>" method="POST" enctype="multipart/form-data">
        <div>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <label for="firstname" class="form-label m-0">Firstname </label>
                    <input type="text" class="form-control border field" value="<?= $firstname ?>" name="firstname" id="firstname">
                    <small class="text-danger"><?= $errors["firstname"] ?? '' ?></small>
                </div>
                <div class="col-sm-6">
                    <label for="lastname" class="form-label m-0">Lastname</label>
                    <input type="text" class="form-control border field" value="<?= $lastname ?>" name="lastname" id="lastname">
                    <small class="text-danger"><?= $errors["lastname"] ?? '' ?></small>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="email" class="form-label m-0">Email </label>
                    <input autocomplete="false" type="email" class="form-control border field" value="<?= $email ?>" name="email" id="email">
                    <small class="text-danger"><?= $errors["email"] ?? '' ?></small>
                </div>
                <div class="col-sm-3">
                    <label for="password" class="form-label m-0">Password</label>
                    <input autocomplete="false" type="password" class="form-control border field" value="<?= $password ?>" name="password" id="password">
                    <small class="text-danger"><?= $errors["password"] ?? '' ?></small>
                </div>
                <div class="col-sm-2">
                    <label for="birth_date" class="form-label m-0">Birthdate</label>
                    <input autocomplete="false" type="date" class="form-control border field" value="<?= $birth_date ?>" name="birth_date" id="birth_date">
                    <small class="text-danger"><?= $errors["birth_date"] ?? '' ?></small>
                </div>
                <?php if (empty($user)) { ?>
                    <input type="hidden" name="role" value="<?= $role ?>">
                <?php } else { ?>
                    <div class="col-sm-2">
                        <label for="role" class="form-label m-0">Role</label>
                        <select class="form-control border field" name="role" value="" id="role">
                            <option value="">Select</option>
                            <option value="ADMIN" <?= $role === "ADMIN" ? "selected" : ''; ?>>ADMIN</option>
                            <option value="LIBRERIAN" <?= $role === "LIBRERIAN" ? "selected" : ''; ?>>LIBRERIAN</option>
                            <option value="MEMBER" <?= $role === "MEMBER" ? "selected" : ''; ?>>MEMBER</option>
                        </select>
                        <small class="text-danger"><?= $errors["role"] ?? '' ?></small>
                    </div>
                <?php } ?>
                <!-- <div class="col-sm-5">
                    <label for="avatar" class="form-label m-0">Avatar</label>
                    <input accept="image/jpg, image/jpeg" type="file" class="form-control border field" value="<?= $avatar ?>" name="avatar" id="avatar">
                    <small class="text-danger"><?= $errors["avatar"] ?? '' ?></small>
                </div> -->
            </div>
        </div>
        <div class="modal-footer">
            <a href="/<?= $action ?>" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submit-btn">
                <i class="material-icons opacity-10 text-white">save</i>
                Save
            </button>
        </div>
    </form>
</div>