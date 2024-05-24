<div class="row my-4" style="overflow-x: hidden;">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="d-flex justify-content-between bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">Loans</h6>
                    <a class="px-3 bg-transparent border-0" href="/books/create">
                        <i class="material-icons opacity-10 text-white">add_circle</i>
                    </a>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="text-left">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Book</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Borrowed Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Return Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($loans as $loan) { ?>
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0"><?= $loan->title ?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $loan->firstname ?> <?= $loan->lastname ?></p>
                                    </td>
                                    <td>
                                        <span class="text-xs font-weight-bold mb-0"><?= $loan->borrow_date ?></span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $loan->return_date ?></p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-success"><?= $loan->available ? 'Available' : 'Borrowed' ?></span>
                                    </td>
                                    <td class="align-middle p-0">
                                        <a href="/books/edit?id=<?= $loan->id ?>" class="font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                            <i class="material-icons opacity-10 text-success">edit</i>
                                        </a>
                                        &nbsp;
                                        <a href="#" onclick='deleteItem("<?= $loan->title ?>", "<?= $loan->id ?>", "/books/delete")'>
                                            <i class="material-icons opacity-10 text-danger">delete</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>