<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Librerians</h6>
                    <a class="px-3 bg-transparent border-0" href="/librerians/create">
                        <i class="material-icons opacity-10 text-white">add_circle</i>
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Birth Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Role</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($librerians)) {
                                foreach ($librerians as $librerian) { ?>
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0"><?= $librerian->id ?></p>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <div>
                                                    <img src="<?= isset($librerian->avatar) ? $librerian->avatar : 'https://placehold.co/50x50' ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm"><?= $librerian->firstname ?> <?= $librerian->lastname ?></h6>
                                                    <p class="text-xs text-secondary mb-0"><?= $librerian->email ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?= $librerian->birth_date ?></p>
                                        </td>
                                        <td>
                                            <!-- <span class="badge badge-sm bg-gradient-success">Online</span> -->
                                            <span class="text-xs font-weight-bold mb-0"><?= $librerian->role ?></span>
                                        </td>
                                        <td class="align-middle p-0">
                                            <a href="/librerians/edit?id=<?= $librerian->id ?>" class="font-weight-bold text-xs" data-bs-toggle="tooltip" data-bs-title="Edit librerian">
                                                <i class="material-icons opacity-10">edit</i>
                                            </a>
                                            &nbsp;
                                            <a href="#" onclick='deleteItem("<?= $librerian->firstname ?> <?= $librerian->lastname ?>", "<?= $librerian->id ?>", "/librerians/delete")' data-bs-toggle="tooltip" data-bs-title="Delete librerian">
                                                <i class="material-icons opacity-10">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-5'>No items</td></tr>";
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>