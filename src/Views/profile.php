<div class="card card-body">
    <div class="row gx-4 mb-2">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <img src="../assets/img/default-user.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
            <h5 class="m-0"><?= $authUser->firstname ?> <?= $authUser->lastname ?></h5>
            <p class="m-0"><?= $authUser->role ?></p>
        </div>
        <form class="card-body p-3" action="/profile" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <input type="hidden" name="id" value="<?= $authUser->id ?>">
                <div class="col-sm-6 my-3">
                    <label for="firstname" class="form-label h6 text-dark m-0">Firstname </label>
                    <input type="text" class="form-control border field" value="<?= $authUser->firstname ?>" name="firstname" id="firstname">
                    <small class="text-danger"><?= $errors["firstname"] ?? '' ?></small>
                </div>
                <div class="col-sm-6 my-3">
                    <label for="lastname" class="form-label h6 text-dark m-0">Lastname </label>
                    <input type="text" class="form-control border field" value="<?= $authUser->lastname ?>" name="lastname" id="lastname">
                    <small class="text-danger"><?= $errors["lastname"] ?? '' ?></small>
                </div>
                <div class="col-sm-12">
                    <label for="cellphone" class="form-label h6 text-dark m-0">Profile Bio </label>
                    <textarea class="form-control border field" name="bio" id="bio"><?= $authUser->bio ?></textarea>
                    <small class="text-danger"><?= $errors["bio"] ?? ''; ?></small>
                </div>
                <div class="col-sm-3 my-3">
                    <label for="cellphone" class="form-label h6 text-dark m-0">Cellphone </label>
                    <input type="text" class="form-control border field" value="<?= $authUser->cellphone ?>" name="cellphone" id="cellphone">
                    <small class="text-danger"><?= $errors["cellphone"] ?? '' ?></small>
                </div>
                <div class="col-sm-3 my-3">
                    <label for="email" class="form-label h6 text-dark m-0">Email </label>
                    <input readonly type="email" class="form-control border field" value="<?= $authUser->email ?>" name="email" id="email">
                    <small class="text-danger"><?= $errors["email"] ?? '' ?></small>
                </div>
                <div class="col-sm-3 my-3">
                    <label for="city" class="form-label h6 text-dark m-0">City </label>
                    <input type="text" class="form-control border field" value="<?= $authUser->city ?>" name="city" id="city">
                    <small class="text-danger"><?= $errors["city"] ?? '' ?></small>
                </div>
                <input type="hidden" name="role" value="<?= $authUser->role ?>">
            </div>
            <div class="row my-2">
                <div class="col-sm-6">
                    <label for="avatar" class="form-label h6 text-dark m-0">Avatar </label>
                    <input type="file" class="form-control border field" value="<?= $authUser->avatar ?>" name="avatar" id="avatar">
                    <small class="text-danger"><?= $errors["avatar"] ?? '' ?></small>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/books" class="btn">Cancel</a>
                <button type="submit" class="btn btn-primary" id="submit-btn">
                    <i class="material-icons opacity-10 text-white">save</i>
                    Save
                </button>
            </div>
        </form>
    </div>