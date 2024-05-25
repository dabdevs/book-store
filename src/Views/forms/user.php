<?php
$id = '';
$firstname = '';
$lastname = '';
$td = strtotime("today");
$today = date("Y-m-d h:i:s", $td);
$tm = strtotime("tomorrow");
$tomorrow = date("Y-m-d h:i:s", $tm);
$email = '';
$password = '';
$birth_date = '';
$avatar = '';

if ($page === "Create Member") {
    $role = "MEMBER";
} elseif ($page === "Create Librerian") {
    $role = "LIBRERIAN";
} elseif ($page === "Create Admin") {
    $role = "ADMIN";
}

if (isset($member)) {
    $id = $member->getId();
    $firstname = $member->getFirstname();
    $lastname = $member->getLastname();
    $email = $member->getEmail();
    $password = $member->getPassword();
    $birth_date = $member->getBirthdate();
    $role = $member->getRole();
    $avatar = $member->getAvatar();
}

if (isset($oldInputs["firstname"])) {
    $firstname = $oldInputs["firstname"];
    $lastname = $oldInputs["lastname"];
    $email = $oldInputs["email"];
    $password = $oldInputs["password"];
    $birth_date = $oldInputs["birth_date"];
    $avatar = $oldInputs["avatar"];
}

?>

<div class="card p-3 my-5">
    <form action="/members<?= isset($member) ? '/update' : '' ?>" method="POST" enctype="multipart/form-data">
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
                    <input type="email" class="form-control border field" value="<?= $email ?>" name="email" id="email">
                    <small class="text-danger"><?= $errors["email"] ?? '' ?></small>
                </div>
                <div class="col-sm-3 <?= $page === 'Edit Member' ? 'd-none' : '' ?>">
                    <label for="password" class="form-label m-0">Password</label>
                    <input type="password" class="form-control border field" value="<?= $password ?>" name="password" id="password">
                    <small class="text-danger"><?= $errors["password"] ?? '' ?></small>
                </div>
                <div class="col-sm-2">
                    <label for="birth_date" class="form-label m-0">Birthdate</label>
                    <input type="date" class="form-control border field" value="<?= $birth_date ?>" name="birth_date" id="birth_date">
                    <small class="text-danger"><?= $errors["birth_date"] ?? '' ?></small>
                </div>
                <div class="col-sm-2">
                    <label for="role" class="form-label m-0">Role</label>
                    <input readonly type="text" class="form-control border field" value="<?= $role ?>" name="role" id="role">
                    <small class="text-danger"><?= $errors["role"] ?? '' ?></small>
                </div>
                <div class="col-sm-5">
                    <label for="avatar" class="form-label m-0">Avatar</label>
                    <input accept="image/jpg, image/jpeg" type="file" class="form-control border field" value="<?= $avatar ?>" name="avatar" id="avatar">
                    <small class="text-danger"><?= $errors["avatar"] ?? '' ?></small>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="/members" class="btn">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submit-btn">
                <i class="material-icons opacity-10 text-white">save</i>
                Save
            </button>
        </div>
    </form>
</div>